@extends('layouts.app')
@section('content')
    <h1>Users List</h1>
    @session('success')
        <section class="d-flex justify-content-center my-4 w-100">
            <div class="container">
                <div class="alert alert-dismissible fade show alert-success" role="alert" data-mdb-color="success"
                    data-mdb-alert-init="" id="customxD" data-mdb-alert-initialized="true">
                    <strong>Congrats!</strong> User created successfully.
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </section>
    @endsession
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add User</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
