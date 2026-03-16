<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</body>

</html>