<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
  </head>
  <body>
    <h2>My Museum Tours</h2>
    <p>Here is a link to share with friends.</p>
    <p>{{ route('custom-tours.show', ['id' => $museumTour->id]) }}</p>
  </body>
</html>
