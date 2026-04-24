@extends('layouts.app')
@section('content')
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- 2 column grid layout with text inputs for the first and last names -->
        <div class="row mb-4">
            <div class="col">
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}"/>
                    <label class="form-label" for="name">Name</label>
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="email" class="form-control" name="email" value="{{ $user->email }}"/>
            <label class="form-label" for="email">Email</label>
        </div>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-primary mb-4">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-primary mb-4">Back</a>

    </form>
@endsection
