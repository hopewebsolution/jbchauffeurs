<?php
namespace App\Models;
use auth;
use Illuminate\Database\Eloquent\Model;

class FixedRate extends Model{
    protected $guarded=[];    
    public function vehicle(){
        return $this->hasOne('App\Models\Vehicle','id','vehicle_id');
    }
}
