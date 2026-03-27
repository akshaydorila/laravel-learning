@extends('layouts.app')
@section('title')
    Form View
@endsection
@section('content')
<div class="container my-5">

    <!-- Show all errors -->
    <!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif -->

    <form action="{{ url('submit-form') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="text" @class(["form-control", "is-invalid"=> $errors->has('email')]) id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email">
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" @class(["form-control", "is-invalid"=> $errors->has('password')]) id="password" placeholder="Password" name="password">
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="profile">Profile</label>
            <input type="file" @class(["form-control", "is-invalid"=> $errors->has('profile')]) id="profile" placeholder="Profile" name="profile">
            @error('profile')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>

    @if (isset($data))
        <div>
            <h1>Form Data</h1>
            <p>Email: {{ $data['email'] }}</p>
            <p>Password: {{ $data['password'] }}</p>
        </div>
    @endif
</div>
@endsection