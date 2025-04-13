@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Daftar Customer</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->nama }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->telepon }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
