<ul {!! (isset($id)) ? 'id="'. $id .'"' : '' !!} class="o-row-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    {{ $slot }}
</ul>
