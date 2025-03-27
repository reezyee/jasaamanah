<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'order_date', 'status', 'progress_status', 'admin_notes',
        'attachment', 'client_id', 'estimated_completion', 'service_type',
        'service_id', 'division', 'assigned_to',
    ];

    protected $casts = [
        'attachment' => 'array',
        'order_date' => 'date',
        'estimated_completion' => 'date',
    ];
    
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function assignedWorker()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}