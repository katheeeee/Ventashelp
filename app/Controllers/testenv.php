<?php
namespace App\Controllers;

class Testenv extends BaseController
{
    public function index()
    {
        dd([
            'hostname' => env('database.default.hostname'),
            'database' => env('database.default.database'),
            'username' => env('database.default.username'),
            'password' => env('database.default.password'),
            'port'     => env('database.default.port'),
        ]);
    }
}
