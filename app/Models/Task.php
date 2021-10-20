<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'calendar_id', 'start', 'is_done', 'color', 'name', 'description'];

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function calendars()
    {
        return $this->hasOne(Calendar::class);
    }
}
