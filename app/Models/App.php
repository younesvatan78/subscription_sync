<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}

