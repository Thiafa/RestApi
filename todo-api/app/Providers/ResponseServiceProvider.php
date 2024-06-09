<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function (string  $message, $data = null,  int $status = 200) {
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ], $status);
        });
        Response::macro('fail', function (string  $message, int $status = 400) {
            return response()->json([
                'status' => false,
                'message' => $message,
            ], $status);
        });
        Response::macro('error', function (string  $message, int $status = 500) {
            return response()->json([
                'status' => false,
                'message' => 'An error ocurred : ' . $message,
            ], $status);
        });
    }
}
