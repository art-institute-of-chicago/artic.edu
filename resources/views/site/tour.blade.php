<h1>Custom tour view - {{ $tour_json['title'] }} </h1>

<p>ID: {{ $tour->id }}</p>

<p>{{ $tour_json['description'] }}</p>

@foreach ($tour_json['artworks'] as $artwork)
    <a href="{{ $artwork['url'] }}">{{ $artwork['title'] }}</a>
@endforeach

