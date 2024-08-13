<?php 
header('content-type:image/jpeg');
$font = realpath({{asset('fonts/Italianno-Regular.ttf')}});
$image = imagecreatefromjpeg({{asset('certificates/charactercert.jpeg')}});