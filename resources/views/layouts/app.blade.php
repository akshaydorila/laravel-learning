<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <title>App | @yield('title')</title>
</head>

<body>
    @include('layouts.header')

    <main>
        @yield('content')
        <div>
            Title: {{ $title ?? 'Default Title' }} <br>
            Description: {{ $description ?? 'N/A' }}
        </div>
    </main>

    @sectionMissing('showFooter')
    <h1>Footer Is missing</h1>
    @endif

    @hasSection('showFooter')
    @include('layouts.footer')
    @endif

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>