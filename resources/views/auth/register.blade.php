@extends('layouts.app')

@section('content')
    <div class="container w-50">
        <!-- Pills content -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="text-center mb-3">
                        <p>Sign up with:</p>
                        <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                            <i class="fab fa-facebook-f"></i>
                        </button>

                        <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                            <i class="fab fa-google"></i>
                        </button>

                        <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                            <i class="fab fa-twitter"></i>
                        </button>

                        <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                            <i class="fab fa-github"></i>
                        </button>
                    </div>

                    <p class="text-center">or:</p>

                    <!-- Name input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="registerName" class="form-control" name="name" />
                        <label class="form-label" for="registerName">Name</label>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="registerEmail" class="form-control" name="email" />
                        <label class="form-label" for="registerEmail">Email</label>
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="registerPassword" class="form-control" name="password" />
                        <label class="form-label" for="registerPassword">Password</label>
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Repeat Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="registerRepeatPassword" class="form-control"
                            name="password_confirmation" />
                        <label class="form-label" for="registerRepeatPassword">Repeat password</label>
                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-4">
                        <input class="form-check-input me-2" type="checkbox" value="" id="registerCheck" checked
                            aria-describedby="registerCheckHelpText" />
                        <label class="form-check-label" for="registerCheck">
                            I have read and agree to the terms
                        </label>
                    </div>

                    <!-- Submit button -->
                    <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-3">Sign UP</button>
                </form>
                <a href="{{ route('login') }}" data-mdb-ripple-init class="btn btn-primary btn-block mb-3">Already have an account? Login</a>

            </div>
        </div>
        <!-- Pills content -->
    </div>
@endsection
@push('styles')
    <style>
        main {
            padding: 0 !important;
        }
    </style>
@endpush
