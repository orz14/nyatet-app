<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'content', 'is_done', 'date'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function decrypt($data)
    {
        $decrypted = Crypt::decryptString($data);
        return $decrypted;
    }
}
