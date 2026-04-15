<?php
 
namespace App\Http\Controllers;
 
use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Exports\LendingExport;
use Maatwebsite\Excel\Facades\Excel;
 
class LendingController extends Controller
{
    public function index()
    {
        $lendings = Lending::with(['item', 'user'])->latest()->get();
        $items = Item::all();
        return view('operator.lendings.index', compact('lendings', 'items'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*' => 'required|exists:items,id',
            'totals' => 'required|array',
            'totals.*' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);
 
        try {
            DB::transaction(function () use ($request) {
                $requestedByItem = [];

                foreach ($request->items as $index => $itemId) {
                    $qty = (int) $request->totals[$index];
                    $requestedByItem[$itemId] = ($requestedByItem[$itemId] ?? 0) + $qty;
                }

                $lockedItems = Item::whereIn('id', array_keys($requestedByItem))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($requestedByItem as $itemId => $requestedQty) {
                    $item = $lockedItems->get($itemId);

                    if (!$item) {
                        throw ValidationException::withMessages([
                            'items' => 'Item tidak ditemukan saat proses peminjaman.',
                        ]);
                    }

                    $available = (int) $item->total - ((int) $item->lending + (int) $item->repair);

                    if ($requestedQty > $available) {
                        throw ValidationException::withMessages([
                            'totals' => "Stok {$item->name} tidak cukup. Available: {$available}, diminta: {$requestedQty}.",
                        ]);
                    }
                }

                foreach ($request->items as $index => $itemId) {
                    $qty = (int) $request->totals[$index];
 
                    // 1. Simpan data peminjaman
                    Lending::create([
                        'item_id'     => $itemId,
                        'user_id'     => Auth::id(),
                        'name'        => $request->name,
                        'total'       => $qty,
                        'notes'       => $request->notes,
                        'date'        => now(),
                        'is_returned' => false,
                    ]);
 
                    // 2. LOGIC: Tambahin jumlah lending di tabel ITEMS
                    // jadi bakal otomatis mengurangi "Available" di halaman items
                    $item = $lockedItems->get($itemId);
                    $item->increment('lending', $qty);
                }
            });
 
            return redirect()->back()->with('success', 'Peminjaman berhasil dicatat!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
 
    // UBAH parameter fungsinya jadi kaya ini
   public function updateReturn(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'returned_to' => 'required|string|max:255' // TAMBAHAN VALIDASI
        ]);

        $lending = Lending::findOrFail($id);

        if (!$lending->is_returned) {
            $lending->update([
                'is_returned' => true,
                'returned_to' => $request->returned_to // TAMBAHAN SIMPAN DATA
            ]);

            $item = Item::find($lending->item_id);
            if ($item) {
                $item->lending = max(0, (int) $item->lending - (int) $lending->total);
                $item->save();
            }
        }

        return redirect()->back()->with('success', 'Barang telah dikembalikan kepada ' . $request->returned_to . '!');
    }
 
    public function destroy($id)
    {
        $lending = Lending::findOrFail($id);
 
        // kalo dihapus tapi status belum kembali (is_returned = false)
        // Maka gw harus mengembalikan stok ke Available (kurangi kolom lending di items)
        if (!$lending->is_returned) {
            $item = Item::find($lending->item_id);
            if ($item) {
                $item->lending = max(0, (int) $item->lending - (int) $lending->total);
                $item->save();
            }
        }
 
        $lending->delete();
        return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
 
    public function exportExcel()
    {
        return Excel::download(new LendingExport, 'lendings.csv');
    }
}