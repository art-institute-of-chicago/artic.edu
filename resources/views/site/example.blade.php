<p>Custom tour view</p>

<form method="POST" action="{{ url('/example') }}">
    @csrf
    <input type="submit" value="Submit">
</form>

@foreach ($tours as $tour)
    <p>ID: {{ $tour->id }}</p>
@endforeach
