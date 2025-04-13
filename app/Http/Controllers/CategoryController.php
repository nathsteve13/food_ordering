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
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
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

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $category = Category::with('menus')->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::with('menus')->findOrFail($id);
        return view('categories.edit', compact('category'));
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

            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to update category: ' . $e->getMessage());
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

            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}
