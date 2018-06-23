<?php

namespace App;

use App\Traits\HasUrls;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, HasUrls;

    protected $appends = [
        'urls'
    ];
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'state',
        'zip',
    ];

    protected $routes = [
        'show'   => 'contacts.show',
        'update' => 'contacts.update'
    ];
}
