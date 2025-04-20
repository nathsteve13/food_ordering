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
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
