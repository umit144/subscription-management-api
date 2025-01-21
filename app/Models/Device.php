<?php

namespace App\Models;

use App\Enums\Platform;
use Database\Factories\DeviceFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

class Device extends Model
{
    /** @use HasFactory<DeviceFactory> */
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'uid',
        'platform',
        'language',
        'status',
    ];

    protected $casts = [
        'platform' => Platform::class,
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('status', true)
            ->where('expire_date', '>', now())
            ->latest();
    }

    public function createClientToken(string $name, Subscription $subscription, array $abilities = ['*'], ?DateTimeInterface $expiresAt = null): NewAccessToken
    {
        $plainTextToken = $this->generateTokenString();

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
            'subscription_id' => $subscription->id,
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }
}
