[@foreach ($location as $key => $value) '{{ $key }}'=>'{{ addslashes($value) }}', @endforeach]
