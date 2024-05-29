<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <style>
        aside{
            float: left;
            width: 30%;
        }
        .content {
            float: left;
            width: 70%;
        }
        footer{
            clear: both;
        }
    </style>
</head>
<body>
    @include('blocks.header')
    <main>
        <aside> 
            Sidebar
        </aside>
        <div class="content">
            @yield('content')
        </div>
    </main>
    @include('blocks.footer')
</body>
</html>