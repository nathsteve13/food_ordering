<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
            }

            Category::create([
                'name' => $request->name,
                'image_path' => $imagePath,
            ]);

            DB::commit();

            return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $category = Category::with('menus')->findOrFail($id);
        return view('admin.category.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::with('menus')->findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($category->image_path) {
                    Storage::disk('public')->delete($category->image_path);
                }
                $category->image_path = $request->file('image')->store('categories', 'public');
            }

            $category->name = $request->name;
            $category->save();

            DB::commit();

            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }

            $category->delete();

            DB::commit();

            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('admin.category.index')
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    public function trashed()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.trashed', compact('categories'));
    }
    public function restore($id)
    {
        try {
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->restore();

            return redirect()->route('admin.category.trashed')->with('success', 'Category restored successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.category.trashed')
                ->with('error', 'Failed to restore category: ' . $e->getMessage());
        }
    }
}
