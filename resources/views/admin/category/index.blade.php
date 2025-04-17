@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>Category List</h1>
        <div class="mb-3">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Add Categories</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($categories as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <a href="{{ route('admin.category.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.category.destroy', $kategori->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection