<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'division', 'status', 'assigned_to',
        'order_id', 'file_attachment', 'note',
    ];

    protected $casts = [
        'file_attachment' => 'array', // Cast as array (JSON)
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}