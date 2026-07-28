<?php
use Illuminate\Support\Facades\Route;

function reoute_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
