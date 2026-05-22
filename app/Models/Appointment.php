<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'appointment_date',
        'status', 'notes', 'reason',
    ];

    protected $casts = ['appointment_date' => 'datetime'];

    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
    public function patient() { return $this->belongsTo(User::class, 'patient_id'); }

    public function isPending(): bool { return $this->status === 'pending'; }
    public function isAccepted(): bool { return $this->status === 'accepted'; }
    public function isCompleted(): bool { return $this->status === 'completed'; }
    public function isCancelled(): bool { return $this->status === 'cancelled'; }
    public function review(){ return $this->hasOne(Review::class); }
}

