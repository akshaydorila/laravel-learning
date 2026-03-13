<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test View</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>

<body>
    <!-- <h1>Test View File</h1>
    <h3>Name: {{ $name }}</h3>
    <h3>Subject: {{ $subject }}</h3> -->
    <div>Grade: {{ $grade > 15 ? 'Pass' : 'Fail' }}</div>
    <!-- <div>{{ $tag }}</div> -->
    <div>{!! $tag !!}</div> <!-- if you want to remove tags -->

    <!-- IF Else statement -->
    @if ($count === 1)
    I have one record!
    @elseif ($count > 1)
    I have multiple records!
    @else
    I don't have any records!
    @endif

    <br>
    <!-- Switch case -->
    @switch($grade)
    @case(1)
    First case...
    @break

    @case(2)
    Second case...
    @break

    @default
    Default case...
    @endswitch

    <br> <br>
    <!-- foreach method -->
    @foreach ($users as $user)
    <!-- @if ($user['type'] == 1)
            @continue
        @endif -->
    @continue($user['type'] == 1)

    <li>{{ $user['name'] }}</li>

    @if($user['status'] == 1)
    <li style="color: green;">Active</li>
    @else
    <li style="color: red;">Inactive</li>
    @endif

    <!-- @if ($user['number'] == 20)
            @break
        @endif -->
    @break($user['number'] == 20)
    @endforeach

    <!-- CSS Class -->
    <h1 class="red-color">Text 1</h1>
    <h1 @class('cyan-color')>Text 2</h1>
    <h1 @class([ 
        'cyan-color'=> $grade > 10,
        'red-color' => $grade <= 10, 
        'green-color'=> $grade > 50
    ])>Result</h1>
</body>

</html>