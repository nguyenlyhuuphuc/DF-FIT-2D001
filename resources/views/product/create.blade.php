<h1>Form Create Product</h1>

@php 
    $name = 'Nguyen Van A';
    $string = '<h1>H1</h1>';


@endphp

{{ $name }}
{{ $string }}
{!! $string !!}

@{{ '$name' }}

<?php 
    echo '$name';
    echo htmlspecialchars($string);
?>