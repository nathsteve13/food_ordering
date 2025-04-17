@extends('admin_layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Makanan</h2>
    <form action="{{ route('admin.food.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="categories_id" class="form-control">
                @foreach($kategories as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Fakta Gizi</label>
            <textarea name="nutrition_fact" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Bahan</label>
            <select name="ingredients[]" class="form-control" multiple>
                @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                @endforeach
            </select>

            <label class="form-label mt-3">Atau Masukkan Bahan Baru (Bisa lebih dari satu)</label>
            <input type="text" name="new_ingredients[]" class="form-control mb-2" placeholder="Nama bahan baru">
            <button type="button" class="btn btn-secondary btn-sm add-ingredient">Tambah Bahan Baru</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Menu</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tambahkan input bahan baru tambahan ketika tombol "Tambah Bahan Baru" ditekan
        document.querySelector('.add-ingredient').addEventListener('click', function () {
            const ingredientInput = document.createElement('input');
            ingredientInput.type = 'text';
            ingredientInput.name = 'new_ingredients[]';
            ingredientInput.className = 'form-control mb-2';
            ingredientInput.placeholder = 'Nama bahan baru';
            document.querySelector('.add-ingredient').before(ingredientInput);
        });
    });
</script>

@endsection
