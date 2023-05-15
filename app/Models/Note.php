<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'title', 'note'];

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
