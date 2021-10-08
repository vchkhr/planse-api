<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'calendar_id', 'start', 'all_day', 'color', 'name', 'description'];

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function calendars()
    {
        return $this->hasOne(Calendar::class);
    }
}
