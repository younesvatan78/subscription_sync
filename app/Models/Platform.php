<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    public function apps()
    {
        return $this->hasMany(App::class);
    }
}
