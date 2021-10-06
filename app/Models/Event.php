<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function calendars()
    {
        return $this->hasOne(Calendar::class);
    }
}
