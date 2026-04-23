@extends('layouts.app')
@section('content')
    <h1>Create User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <!-- 2 column grid layout with text inputs for the first and last names -->
        <div class="row mb-4">
            <div class="col">
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="name" class="form-control" name="name"/>
                    <label class="form-label" for="name">Name</label>
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="email" class="form-control" name="email"/>
            <label class="form-label" for="email">Email</label>
        </div>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="password" class="form-control" name="password"/>
            <label class="form-label" for="password">Password</label>
        </div>
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-primary mb-4">Create User</button>
        <a href="{{ route('users.index') }}" class="btn btn-primary mb-4">Back</a>

    </form>
@endsection
