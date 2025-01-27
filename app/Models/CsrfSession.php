<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsrfSession extends Model
{
    use HasFactory;

    protected $primaryKey = 'ip_address';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['ip_address', 'csrf_token', 'usage'];
}
