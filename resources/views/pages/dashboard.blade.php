@extends('layouts.app')
@section('content')
    <h1>Dashboard</h1>
    <p>Welcome to the dashboard!</p>

    @php
        use Illuminate\Support\Facades\Crypt;

        $string = 'Hello, World!';
        $encrypted = Crypt::encryptString($string);
        $decrypted = Crypt::decryptString($encrypted);

    @endphp

    Encrypted: {{ $encrypted }}
    Decrypted: {{ $decrypted }}
@endsection
