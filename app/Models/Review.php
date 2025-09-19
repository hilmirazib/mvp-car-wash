<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function order() { return $this->belongsTo(Order::class); }
    public function partner() { return $this->belongsTo(Partner::class); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
}
