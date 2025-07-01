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
                            <button type="button" class="btn btn-info btn-sm"
                                onclick="showFoodDetailModal({{ $food->id }})">Bahan</button>
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
            <div class="d-flex justify-content-center mt-4">
                {{ $menus->onEachSide(2)->links() }}
            </div>
        </table>
    </div>
    <!-- Food Detail Modal -->
    <div class="modal fade" id="foodDetailModal" tabindex="-1" aria-labelledby="foodDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Ingredients</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="foodDetailModalBody">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showFoodDetailModal(menuId) {
            fetch(`/admin/food/detail/${menuId}`)
                .then(response => response.json())
                .then(data => {
                    let html = `<h5 class="mb-3">Ingredients</h5>`;

                    if (data.ingredients.length > 0) {
                        html += `<ul>`;
                        data.ingredients.forEach(ingredient => {
                            html += `<li>${ingredient.name}</li>`;
                        });
                        html += `</ul>`;
                    } else {
                        html += `<p class="text-muted">No ingredients listed for this menu.</p>`;
                    }

                    document.getElementById('foodDetailModalBody').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('foodDetailModal')).show();
                })
                .catch(error => {
                    console.error('Error fetching food detail:', error);
                    document.getElementById('foodDetailModalBody').innerHTML = '<p>Failed to load data.</p>';
                    new bootstrap.Modal(document.getElementById('foodDetailModal')).show();
                });
        }
    </script>
@endpush