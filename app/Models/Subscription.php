<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        // Add other fillable fields here, if any
        'status',
    ];
    public function app()
    {
        return $this->belongsTo(App::class);
    }
    
}