<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;

    protected $fillable = [
        'refresh_token',
        'access_token',
        'app_token',
        'rf_token_valid_till',
        'access_token_valid_till',
        'environment'
    ];
}
