<?php
namespace App\Models;
use auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model{
    protected $guarded=[];
    protected $casts = [
    ];
    public $path= "/public/assets/front_assets/uploads/services/";
    public function getImageAttribute($value){
        if($value){
            return asset($this->path.$value);    
        }else{
            return $value;
        }
    }

    /*public function getShortDescAttribute(){
        return Str::limit($this->descriptions, 150, '...');
    }*/
}
