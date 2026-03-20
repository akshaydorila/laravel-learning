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

    <form action="{{ url('submit-form') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="text" @class(["form-control", "is-invalid"=> $errors->has('email')]) id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" @class(["form-control", "is-invalid"=> $errors->has('password')]) id="exampleInputPassword1" placeholder="Password" name="password">
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
</div>
@endsection