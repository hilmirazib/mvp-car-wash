<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'scheduled_at' => 'datetime',
        'placed_at'    => 'datetime',
    ];

    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function partner() { return $this->belongsTo(Partner::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function review() { return $this->hasOne(Review::class); }
}
