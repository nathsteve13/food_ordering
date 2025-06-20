@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>Food List</h1>
        <a href="{{ route('admin.food.create') }}" class="btn btn-primary mb-3">Add New Food</a>
        <a href="{{ route('admin.food.trashed') }}" class="btn btn-outline-secondary mb-3">Deleted Food</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Nutrition Fact</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
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
                        <td>{{ $food->category->name ?? 0}}</td>
                        <td>
                            <a href="{{ route('admin.food.edit', $food->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.food.destroy', $food->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this menu?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
