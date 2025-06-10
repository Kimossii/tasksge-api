<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

 /**
  * @OA\Schema(
  *     schema="Authentication",
  *     type="object",
  *     title="Authentication",
  *     required={"name", "email", "password", "password_confirmation"},
  *     @OA\Property(property="name", type="string", example="Eluki Júnior"),
  *     @OA\Property(property="email", type="string", example="eluckimossi@gmail.com"),
  *     @OA\Property(property="password", type="string", example="12345678"),
  *     @OA\Property(property="password_confirmation", type="string", example="12345678"),
  *
  * )
  */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
