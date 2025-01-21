<?php

namespace App\Models;

use App\Enums\Platform;
use Database\Factories\ApplicationCredentialsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationCredentials extends Model
{
    /** @use HasFactory<ApplicationCredentialsFactory> */
    use HasFactory;

    protected $fillable = [
        'platform',
        'username',
        'password',
    ];

    protected $casts = [
        'platform' => Platform::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
