<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'color', 'name', 'description'];

    public function users()
    {
        return $this->hasOne(User::class);
    }
}
