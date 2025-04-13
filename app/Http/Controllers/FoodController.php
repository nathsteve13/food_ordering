<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $menus = Menu::with('images')->get();
        return view('foods.index', compact('menus'));
    }

    public function create()
    {
        return view('foods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'nutrition_fact' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $menu = Menu::create($request->only(['name', 'description', 'nutrition_fact', 'price', 'stock', 'categories_id']));

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('menus', 'public');

                    MenuImage::create([
                        'menus_id' => $menu->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('foods.index')->with('success', 'Menu created successfully with images.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create menu: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $food = Menu::with('images')->findOrFail($id);

        if (!$food) {
            return redirect()->route('foods.index')->with('error', 'Menu not found.');
        }
        return view('foods.show', compact('food'));
    }

    public function edit($id)
    {
        $food = Menu::findOrFail($id);
        if (!$food) {
            return redirect()->route('foods.index')->with('error', 'Menu not found.');
        }
        return view('foods.edit', compact('food'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'nutrition_fact' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        $food = Menu::findOrFail($id);

        DB::beginTransaction();

        try {
            $food->update($request->only(['name', 'description', 'nutrition_fact', 'price', 'stock', 'categories_id']));

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('menus', 'public');

                    MenuImage::create([
                        'menus_id' => $food->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('foods.index')->with('success', 'Menu updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update menu: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $food = Menu::with('images')->findOrFail($id);

            if (!$food) {
                return redirect()->route('foods.index')->with('error', 'Menu not found.');
            }

            if ($food->images) {
                foreach ($food->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            $food->delete();

            DB::commit();
            return redirect()->route('foods.index')->with('success', 'Menu deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('foods.index')
                ->with('error', 'Failed to delete menu: ' . $e->getMessage());
        }
    }
}
