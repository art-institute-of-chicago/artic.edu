<h1>Custom tour builder</h1>

<form method="POST" action="{{ url('/api/tour') }}">
    @csrf
    <input type="text" name="id" placeholder="Tour ID">
    <input type="submit" value="Submit">
</form>
