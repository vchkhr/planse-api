<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrangement extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'calendar_id', 'start', 'end', 'all_day', 'color', 'name', 'description'];

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function calendars()
    {
        return $this->hasOne(Calendar::class);
    }
}
