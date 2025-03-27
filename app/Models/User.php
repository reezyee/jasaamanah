<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'division',
        'phone',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // A user (client) has many orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    // A user (worker) can be assigned to many orders
    public function assignedOrders()
    {
        return $this->hasMany(Order::class, 'assigned_to');
    }

    // A user (worker) can be assigned to many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    // Method to check if the user has a specific role
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}