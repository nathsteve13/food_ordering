@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>Food List</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Nutrition Fact</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category ID</th>
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
                        <td>{{ $food->category_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection