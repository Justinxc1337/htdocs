<?php


function cg_config($key, $default)
{
    $fileName = __DIR__."/$key.php";
    if (!file_exists($fileName)){
        return $default;
    }
    require $fileName;
}

