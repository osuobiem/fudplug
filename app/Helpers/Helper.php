<?php

if (!function_exists('enc')) {
    // Encode data using base64_encode
    function enc($data)
    {
        return base64_encode($data);
    }
}

if (!function_exists('dec')) {
    // Decode base64_encoded data
    function dec($data)
    {
        return base64_decode($data);
    }
}
