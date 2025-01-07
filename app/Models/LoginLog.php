<?php

namespace App\Models;

use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ObjectId\ObjectId;

class LoginLog extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];
    protected $hidden = ['token_name', 'ip_address'];

    protected static function booted(): void
    {
        static::creating(function (Model $model) {
            $model->id = ObjectId::generate();
        });
    }

    public function token()
    {
        return $this->belongsTo(PersonalAccessToken::class, 'token_name', 'name');
    }
}
