<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>L4 Site</title>
 
    <link href="http://netdna.bootstrapcdn.com/flatstrap/css/bootstrap.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/flatstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/styles/css/global.css') }}" rel="stylesheet">
 
    <script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
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
<script src="{{ URL::asset('public/assets/js/src/scripts.js') }}">
</body>
</html>