<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Get the trip of each client
     */
    public function travels()
    {
        return $this->hasMany(Travel::class);
    }

}
