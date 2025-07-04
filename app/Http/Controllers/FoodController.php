<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuImage;
use App\Models\MenuHasIngredient;
use App\Models\Ingredient;
use App\Models\MenusHasIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user || !$user->role || $user->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        $menus = Menu::with('images', 'category')->paginate(10);
        return view('admin.food.index', compact('menus'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user || !$user->role || $user->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
        $kategories = Category::all();
        $ingredients = Ingredient::all();
        return view('admin.food.create', compact('kategories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'categories_id' => 'nullable|exists:categories,id',
            'nutrition_fact' => 'required',
            'stock' => 'required|integer',
            'description' => 'required',
            'ingredients.*' => 'nullable|exists:ingredients,id',
            'new_ingredients.*' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $menu = Menu::create([
                'name' => $request->name,
                'description' => $request->description,
                'nutrition_fact' => $request->nutrition_fact,
                'price' => $request->price,
                'stock' => $request->stock,
                'categories_id' => $request->categories_id,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $fileName = uniqid() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('menus'), $fileName);

                    MenuImage::create([
                        'menus_id' => $menu->id,
                        'image_path' => 'menus/' . $fileName, // ini path yang akan kamu panggil pakai asset()
                    ]);
                }
            }


            if ($request->has('ingredients')) {
                foreach ($request->ingredients as $ingredientId) {
                    MenusHasIngredient::create([
                        'menus_id' => $menu->id,
                        'ingredients_id' => $ingredientId,
                    ]);
                }
            }

            if ($request->new_ingredients !== null) {
                foreach ($request->new_ingredients as $newIngredient) {
                    if (empty($newIngredient)) {
                        continue;
                    } else {
                        $newIngredient = Ingredient::create(['name' => $newIngredient]);

                        MenusHasIngredient::create([
                            'menus_id' => $menu->id,
                            'ingredients_id' => $newIngredient->id,
                        ]);
                    }

                }
            }

            DB::commit();

            return redirect()->route('admin.food.index')->with('success', 'Menu created successfully with images and ingredients.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create menu: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = auth()->user();
        if (!$user || !$user->role || $user->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
        $food = Menu::findOrFail($id);
        if (!$food) {
            return redirect()->route('food.index')->with('error', 'Menu not found.');
        }
        $kategories = Category::all();
        $allIngredients = Ingredient::all();
        return view('admin.food.edit', compact('food', 'kategories', 'allIngredients'));
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
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
            'new_ingredients' => 'nullable|array',
            'new_ingredients.*' => 'nullable|string|max:255',
        ]);

        $food = Menu::findOrFail($id);

        DB::beginTransaction();

        try {
            // Update menu utama
            $food->update($request->only([
                'name',
                'description',
                'nutrition_fact',
                'price',
                'stock',
                'categories_id'
            ]));

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $fileName = uniqid() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('menus'), $fileName);

                    MenuImage::create([
                        'menus_id' => $food->id,
                        'image_path' => 'menus/' . $fileName,
                    ]);
                }
            }


            $ingredientIds = $request->input('ingredients', []);
            $food->ingredients()->sync($ingredientIds);

            if ($request->filled('new_ingredients')) {
                foreach ($request->input('new_ingredients') as $name) {
                    $name = trim($name);
                    if ($name !== '') {
                        $ingredient = Ingredient::firstOrCreate(['name' => $name]);
                        $food->ingredients()->attach($ingredient->id);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.food.index')->with('success', 'Menu updated successfully.');
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
                return redirect()->route('admin.food.index')->with('error', 'Menu not found.');
            }

            if ($food->images) {
                foreach ($food->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            $food->delete();

            DB::commit();
            return redirect()->route('admin.food.index')->with('success', 'Menu deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('admin.food.index')
                ->with('error', 'Failed to delete menu: ' . $e->getMessage());
        }
    }

    public function trashed()
    {
        $menus = Menu::onlyTrashed()->with('images', 'category')->get();
        return view('admin.food.trashed', compact('menus'));
    }
    public function restore($id)
    {
        try {
            $menu = Menu::onlyTrashed()->findOrFail($id);
            $menu->restore();

            return redirect()->route('admin.food.trashed')->with('success', 'Menu restored successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.food.trashed')
                ->with('error', 'Failed to restore menu: ' . $e->getMessage());
        }
    }
    public function detail($id)
    {
        $user = auth()->user();
        if (!$user || !$user->role || $user->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
        $menu = Menu::with(['ingredients'])->findOrFail($id);

        return response()->json([
            'ingredients' => $menu->ingredients,
        ]);
    }




}
