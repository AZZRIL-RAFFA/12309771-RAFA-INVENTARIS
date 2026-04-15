<?php
 
namespace App\Http\Controllers;
 
use App\Models\Item;
use App\Models\Category;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;
 
class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        $categories = Category::all();
        return view('admin.items.index', compact('items', 'categories'));
    }

    public function detailLending(Request $request)
    {
        $itemId = $request->query('item_id');

        $lendings = Lending::with(['item', 'user'])
            ->when($itemId, function ($query) use ($itemId) {
                $query->where('item_id', $itemId);
            })
            ->latest()
            ->get();

        $selectedItem = $itemId ? Item::find($itemId) : null;

        return view('admin.items.detail_lending', compact('lendings', 'selectedItem'));
    }
 
    public function indexStaff()
    {
        $items = Item::with('category')->get();
        return view('operator.items.index', compact('items'));
    }
 
    public function exportExcel()
    {
        return Excel::download(new ItemsExport, 'items.csv');
    }
 
   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'total' => 'required|numeric',
        ]);

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => 0,
            'lending' => 0,
        ]);

        $category = Category::find($request->category_id);

        return redirect()->back()->with([
            'success' => 'Item created successfully!',
            'last_cat_id' => $request->category_id,
            'last_cat_name' => $category ? $category->name : '',
            'show_reentry_prompt' => true // Tambahin flag ini
        ]);
    }
 
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'total' => 'required|numeric',
            'new_broke_item' => 'nullable|integer|min:0',
        ]);
 
        $item = Item::findOrFail($id);
 
        $newTotal = (int) $request->total;
        $currentRepair = (int) ($item->repair ?? 0);
        $additionalRepair = (int) $request->input('new_broke_item', 0);

        // If old repair data is invalid (greater than total), reset baseline to 0
        // so admin can input a valid new repair amount.
        if ($currentRepair > $newTotal) {
            $currentRepair = 0;
        }

        $totalRepair = $currentRepair + $additionalRepair;

        if ($totalRepair > $newTotal) {
            return redirect()->back()->with('error', 'Update gagal: jumlah repair tidak boleh melebihi total item.');
        }

        $currentLending = (int) ($item->lending ?? 0);
        if (($currentLending + $totalRepair) > $newTotal) {
            return redirect()->back()->with('error', 'Update gagal: total item tidak boleh lebih kecil dari jumlah lending + repair saat ini.');
        }
 
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $newTotal,
            'repair' => $totalRepair,
        ]);
 
        return redirect()->back()->with('success', 'Item updated and repair stock accumulated!');
    }
 
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        DB::transaction(function () use ($item) {
            // Cascade delete in application logic: remove child lendings first.
            $item->lendings()->delete();
            $item->delete();
        });

        return redirect()->back()->with('success', 'Item and related lending history deleted successfully!');
    }
}