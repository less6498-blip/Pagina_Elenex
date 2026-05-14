<?php

use App\Models\Department;
use App\Models\Province;
use App\Models\District;
use Illuminate\Support\Facades\Route;

Route::get('/departments', function () {
    return Department::all();
});

Route::get('/provinces/{id}', function ($id) {
    return Province::where('department_id', $id)->get();
});

Route::get('/districts/{id}', function ($id) {
    return District::where('province_id', $id)->get();
});