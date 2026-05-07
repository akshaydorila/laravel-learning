@extends('layouts.app')
@section('content')
    <h1>User Profile</h1>
    @session('success')
        <section class="d-flex justify-content-center my-4 w-100">
            <div class="container">
                <div class="alert alert-dismissible fade show alert-success" role="alert" data-mdb-color="success"
                    data-mdb-alert-init="" id="successAlert" data-mdb-alert-initialized="true">
                    <strong>Congrats!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </section>
    @endsession
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- 2 column grid layout with text inputs for the first and last names -->
        <div class="row mb-4">
            <div class="col">
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}" />
                    <label class="form-label" for="name">Name</label>
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="email" class="form-control" name="email" value="{{ $user->email }}" />
            <label class="form-label" for="email">Email</label>
        </div>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="profile">Profile Picture</label>
         <div data-mdb-input-init class="form-outline mb-4">
            <input type="file" id="profile" class="form-control" name="profile" />
        </div>

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-primary mb-4">Update Profile</button>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mb-4">Back</a>

    </form>
@endsection
