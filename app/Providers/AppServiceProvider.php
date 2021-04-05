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

        // Validate item quantity
        Validator::extend('quantity', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true;
            }

            if (substr_count($value, " ") == 1) {

                $qty_arr = explode(" ", $value);

                if (is_numeric($qty_arr[0]) && ctype_alpha($qty_arr[1])) {
                    // dd("Okay", $value);
                    return true;
                } else {
                    // dd("Not Okay", $value);
                    return false;
                }
            } else {
                // dd("Not Okay", $value);
                return false;
            }
        });

        // Validate item price
        Validator::extend('plug_numeric', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true;
            }

            if (is_numeric($value)) {
                return true;
            } else {
                return false;
            }
        });
    }

}
