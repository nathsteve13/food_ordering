@extends('admin_layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Kategori</h2>
    <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama" name="name" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
