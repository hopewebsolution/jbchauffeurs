<?php

namespace App\Models;

use auth;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = [];
    protected $casts = [];
    public $path = "/public/assets/front_assets/uploads/vehicles/";
    public function getImageAttribute($value)
    {
        if ($value) {
            return asset($this->path . $value);
        } else {
            return $value;
        }
    }
    public function fixedRate()
    {
        return $this->hasOne('App\Models\FixedRate', 'vehicle_id', 'id');
    }
    public function fares()
    {
        return $this->hasMany('App\Models\Fare', 'vehicle_id', 'id');
    }
    public function bookings()
    {
        return $this->hasMany('App\Models\Booking', 'vehicle_id', 'id');
    }
    public function cost($distance, $fares, $fixedAmount = null, $way = 1)
    {
        $cost = 0;
        if ($fixedAmount) {
            $cost = $fixedAmount;
            if ($this->fixed_rate > 0) {
                $cost = $cost + ($cost * ($this->fixed_rate) / 100);
            }
        } else {
            if ($fares) {
                foreach ($fares as $fare) {
                    $fare = (object) $fare;
                    $start = $fare->start;
                    $end = $fare->end;
                    if ($start <= $distance) {
                        $calc_d = $end - ($start - 1);
                        if ($end >= $distance) {
                            $calc_d = $distance - ($start - 1);
                        }
                        $cost += $calc_d * $fare->rate;
                    }
                }
            }
        }
        return $cost * $way;
    }
}
