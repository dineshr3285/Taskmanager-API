<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Returns Requested Strategy Details by UUID
         *
         * @param string $data
         * @return JsonResponse
         */
        Response::macro('default', function ($data = [], $message = [], $errors = [], $code = HttpFoundationResponse::HTTP_OK) {
            return response()->json([
                'message' => $message,
                'data'    => $data,
                'errors' => $errors,
            ], $code);
        });
    }
}
