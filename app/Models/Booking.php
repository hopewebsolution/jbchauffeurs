<?php
namespace App\Models;
use auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;

class Booking extends Model{
    protected $guarded=[];
    protected $casts = [
        'stops' => 'array',
        'fares' => 'array',
    ];
    public function vehicle(){
        return $this->hasOne('App\Models\Vehicle','id','vehicle_id');
    }
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function getBookedVehicleAttribute(){
        if($this->fares){
            //return Vehicle::hydrate($this->fares);
            return $vehicle = new Vehicle($this->fares);
        }else{
            return $vehicle = new Vehicle();
        }
    }
    public function getCurrencyAttribute(){
        $obj=new Controller();
        $countries=$obj->countries;
        $key = array_search($this->country, array_column($countries, 'short'));
        $currency=$countries[$key]['currency'];

        return $currency;
    }
}
