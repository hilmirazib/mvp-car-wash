<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function partners() { return $this->belongsToMany(Partner::class, 'partner_services')->withPivot(['price_cents','duration_min'])->withTimestamps(); }
}
