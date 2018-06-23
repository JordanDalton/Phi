<?php

namespace App\Providers;

use App\Contact;
use App\Observers\ContactObserver;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    protected $obervers = [
        Contact::class => ContactObserver::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->observerModels();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function observerModels()
    {
        foreach($this->obervers as $model => $observer)
        {
            $model::observe($observer);
        }
    }
}
