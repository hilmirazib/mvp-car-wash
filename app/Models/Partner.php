<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public function owner() { return $this->belongsTo(User::class, 'owner_user_id'); }
    public function services() { return $this->belongsToMany(Service::class, 'partner_services')->withPivot(['price_cents','duration_min'])->withTimestamps(); }
    public function orders() { return $this->hasMany(Order::class); }
    public function reviews() { return $this->hasMany(Review::class); }
}
