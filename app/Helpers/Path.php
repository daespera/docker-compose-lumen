<?php 
namespace App\Helpers;

class Path {

    public static function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}