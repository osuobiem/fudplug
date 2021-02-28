<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        Validator::extend('bulk_required', function ($attribute, $value, $parameters, $validator) {
            $validate_data = $validator->getData();
            $index = explode('.', $attribute)[0];

            if (empty(array_filter($validate_data[$index]))) {
                // All inputs are empty (passes)
                return true;
            } else {
                if (in_array('', $validate_data[$index])) {
                    return false;
                } else {
                    return true;
                }
            }
        });
    }
}
