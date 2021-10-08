<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'color', 'name', 'description', 'visible'];

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function arrangements()
    {
        return $this->hasMany(Arrangement::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
