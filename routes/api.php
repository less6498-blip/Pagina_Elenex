<?php

use App\Models\Department;
use App\Models\Province;
use App\Models\District;
use Illuminate\Support\Facades\Route;

Route::get('/departments', fn () => Department::all());
Route::get('/provinces/{id}', fn ($id) => Province::where('department_id', $id)->get());
Route::get('/districts/{id}', fn ($id) => District::where('province_id', $id)->get());