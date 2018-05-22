@php
if (isset($itemprops) and !empty($itemprops)) {
    foreach($itemprops as $key => $value){
        if (!empty($value)) {
            echo '<meta itemprop="'.$key.'" content="'.$value.'"/>';
        }
    }
}
@endphp

