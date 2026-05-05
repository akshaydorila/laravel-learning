@extends('layouts.app')
@section('title')
    Page 1
@endsection
@section('content')
    <h1 class="text-primary">Welcome to Page 1</h1>
    <p>This is the main content for Page 1.</p>
    @guest
        <h1>User is not authenticated</h1>
    @endguest

    @auth
        <h1>User is authenticated</h1>
    @endauth
@endsection
@section('page-no')
    1
@endsection

@section('showFooter')
    footer content for page 1
@endsection
