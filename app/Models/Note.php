<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'title', 'note', 'password'];

    protected $hidden = ['id', 'user_id', 'password'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function encrypt($data)
    {
        return Crypt::encryptString($data);
    }

    public function decrypt($data)
    {
        return Crypt::decryptString($data);
    }
}
