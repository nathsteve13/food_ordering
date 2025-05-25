@extends('admin_layouts.admin')

@section('content')
<div class="container">
    <h1>Trashed Food List</h1>

    <a href="{{ route('admin.food.index') }}" class="btn btn-secondary mb-3">Back to Food List</a>

    @if ($menus->isEmpty())
        <div class="alert alert-info">No trashed food found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Nutrition Fact</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $food)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $food->name }}</td>
                        <td>{{ $food->nutrition_fact }}</td>
                        <td>{{ $food->description }}</td>
                        <td>{{ $food->price }}</td>
                        <td>{{ $food->stock }}</td>
                        <td>{{ $food->category->name ?? '-' }}</td>
                        <td>{{ $food->deleted_at->format('d M Y H:i') }}</td>
                        <td>
                            <!-- Restore -->
                            <form action="{{ route('admin.food.restore', $food->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm" onclick="return confirm('Restore this menu?')">Restore</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
