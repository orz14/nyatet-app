<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'content', 'is_done'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function decrypt($data)
    {
        $decrypted = Crypt::decryptString($data);

        return $decrypted;
    }
    public function childs() {
        return $this->hasMany(Todo::Class,'date','date');
    }

}
