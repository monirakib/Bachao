<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Services\MembershipService;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'phone',
        'gender',
        'user_type',
        'reward_point',
        'membership_level'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function isAdmin()
    {
        return $this->user_type === 'Admin';
    }

    /**
     * Get all transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'user_id');
    }

    // Add constants for user types
    const TYPE_CUSTOMER = 'Customer';
    const TYPE_ADMIN = 'Admin';

    public function updateMembershipLevel()
    {
        $newLevel = MembershipService::calculateMembershipLevel($this->reward_point);
        if ($this->membership_level !== $newLevel) {
            $this->membership_level = $newLevel;
            $this->save();
        }
    }

    // Add this to automatically update membership when reward points change
    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->isDirty('reward_point')) {
                $user->membership_level = MembershipService::calculateMembershipLevel($user->reward_point);
            }
        });
    }
}
