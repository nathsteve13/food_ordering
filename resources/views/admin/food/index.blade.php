@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Makanan</h2>
    <a href="{{ route('admin.food.create') }}" class="btn btn-primary mb-3">Tambah Makanan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $food)
            <tr>
                <td>{{ $food->nama }}</td>
                <td>Rp {{ number_format($food->harga) }}</td>
                <td>{{ $food->kategori->nama }}</td>
                <td>
                    <a href="{{ route('food.edit', $food->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('food.destroy', $food->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
