@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>Trashed Categories</h1>

        <div class="mb-3">
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Back to Category List</a>
        </div>

        @if ($categories->isEmpty())
            <div class="alert alert-info">No deleted categories found.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $kategori)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kategori->name }}</td>
                            <td>{{ $kategori->deleted_at->format('d M Y H:i') }}</td>
                            <td>
                                <!-- Restore -->
                                <form action="{{ route('admin.category.restore', $kategori->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Restore this category?')">Restore</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
