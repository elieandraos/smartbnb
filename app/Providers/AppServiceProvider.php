<?php

namespace App\Providers;

use Validator;
use App\Models\Transaction;
use App\Smartbnb\TransactionObserver;
use App\Smartbnb\AmountLimitValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // transaction model observer
        Transaction::observe(TransactionObserver::class);
        
        // custom validator for user amount
        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new AmountLimitValidator($translator, $data, $rules, $messages);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
