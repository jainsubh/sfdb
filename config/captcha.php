<?php
return [
    'default'   => [
        'length'    => 4,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => false,  //Enable Math Captcha
        'expire'    => 60,    //Stateless/API captcha expiration
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
    ]
];
?>