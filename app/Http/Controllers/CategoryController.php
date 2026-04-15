<?php
 
namespace App\Http\Controllers;
 
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;
 
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('items')->get();
        return view('admin.categories.index', compact('categories'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required'
        ]);
 
        Category::create($request->all());
 
        return redirect()->back()->with('success', 'Category created successfully!');
    }
 
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required'
        ]);
 
        $category = Category::findOrFail($id);
        $category->update($request->all());
 
        return redirect()->back()->with('success', 'Category updated successfully!');
    }
 
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
 
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function exportExcel()
    {
    return Excel::download(new CategoriesExport, 'categories.xlsx');
    }
}