<html>
    <body>
        <h1>Laravel Quickstart</h1>
        @if (Session::has('users'))
		    <div class="message">
		    {{ Session::get('message')}}
		    </div>
		@endif
        @yield('content')
    </body>
</html>