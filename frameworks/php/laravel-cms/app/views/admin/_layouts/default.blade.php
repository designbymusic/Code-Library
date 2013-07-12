<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>L4 Site</title>

    <link href="{{ URL::asset('/_admin/assets/styles/css/bootstrap.css') }}" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href="{{ URL::asset('/_admin/assets/styles/css/global.css') }}" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
</head>
<body>
<div>
    <div id="main">
        <div>
            <div>
                <a href="{{ URL::route('admin.pages.index') }}">L4 Site</a>

                @if (Sentry::check())
                    <ul>
                        <li><a href="{{ URL::route('admin.pages.index') }}"><i></i> Pages</a></li>
                        <li><a href="{{ URL::route('admin.pages.index') }}"><i></i> Articles</a></li>
                        <li><a href="{{ URL::route('admin.logout') }}"><i></i> Logout</a></li>
                    </ul>
                @endif
            </div>
        </div>

    <hr>

    @yield('main')
    </div>
</div>
<script src="{{ URL::asset('/_admin/assets/js/src/scripts.js') }}"></script>
</body>
</html>