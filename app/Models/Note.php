<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'title', 'note', 'password'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function decrypt($data)
    {
        return Crypt::decryptString($data);
    }
}
