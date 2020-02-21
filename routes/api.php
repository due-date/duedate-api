<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation;

Route::get('/', function () {
    return Response::json('wellcome due date api', HttpFoundation\Response::HTTP_OK);
});

require base_path('routes/api/auth.php');
require base_path('routes/api/user.php');

