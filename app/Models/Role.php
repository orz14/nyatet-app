<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['role'];

    public function encrypt($data)
    {
        return Crypt::encryptString($data);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
