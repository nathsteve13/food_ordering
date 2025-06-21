<!-- food/add.blade.php -->
@extends('admin_layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Makanan</h2>
    <form action="{{ route('admin.food.update', ['id' => $food->id]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $food->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $food->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Fakta Gizi</label>
            <textarea name="nutrition_fact" class="form-control" required>{{ $food->nutrition_fact }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ $food->price }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" value="{{ $food->stock }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="categories_id" class="form-control">
            <option value="">Pilih Kategori</option>
            @foreach($kategories as $kategori)
            <option value="{{ $kategori->id }}" {{ $food->categories_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->name }}</option>
            @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>
        <div class="mb-3">
    <label class="form-label">Bahan Makanan</label>
    <div class="row">
        @foreach ($allIngredients as $ingredient)
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="ingredients[]"
                           value="{{ $ingredient->id }}"
                           id="ingredient_{{ $ingredient->id }}"
                           {{ in_array($ingredient->id, $food->ingredients->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ingredient_{{ $ingredient->id }}">
                        {{ $ingredient->name }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Tambah Bahan Baru</label>
    <div id="new-ingredients-wrapper">
        <input type="text" name="new_ingredients[]" class="form-control mb-2" placeholder="Nama bahan baru">
    </div>
    <button type="button" class="btn btn-sm btn-secondary" id="add-new-ingredient">+ Tambah Bahan Baru</button>
</div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    document.getElementById('add-new-ingredient').addEventListener('click', function () {
        const wrapper = document.getElementById('new-ingredients-wrapper');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'new_ingredients[]';
        input.className = 'form-control mb-2';
        input.placeholder = 'Nama bahan baru';
        wrapper.appendChild(input);
    });
</script>
@endsection
