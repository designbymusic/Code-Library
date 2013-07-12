@include('site::_partials/header')

<h2>{{ $entry->title }}</h2>
<h4>Published at {{ $entry->created_at }} &bull; by {{ $entry->author->first_name }}</h4>
{{ $entry->body }}
<hr />
<p><a href="{{ URL::route('article.list') }}">&laquo; Back to articles</a></p>
@include('site::_partials/footer')