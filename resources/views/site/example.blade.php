<p>Custom tour view</p>

<form method="POST" action="{{ url('/example') }}">
    @csrf
    <input type="text" name="id" placeholder="Tour ID">
    <input type="submit" value="Submit">
</form>

