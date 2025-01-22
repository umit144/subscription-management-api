<?php

namespace App\Models;

use Database\Factories\CallbackFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
    /** @use HasFactory<CallbackFactory> */
    use HasFactory;

    protected $fillable = [
        'endpoint_url',
    ];
}
