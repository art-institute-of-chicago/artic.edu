<h1>Custom tour builder</h1>

<form method="POST" action="{{ url('/api/tour') }}">
    @csrf
{{--    <textarea name="tour_json" row="8"></textarea>--}}
    <input type="submit" value="Submit">
</form>
