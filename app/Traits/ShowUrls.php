<?php

namespace App\Traits;

trait HasUrls
{
    public function getUrlsAttribute()
    {
        return collect($this->routes)->map(function($route){
            return route($route, $this);
        });
    }
}