<?php
namespace App\Models;
use auth;
use Illuminate\Database\Eloquent\Model;


class Page extends Model{
    protected $guarded=[];
    public $path= "/public/assets/front_assets/uploads/pages/";
    public function getImageAttribute($value){
        if($value){
            return asset($this->path.$value);    
        }else{
            return $value;
        }
    }
    public function getSideAppImageAttribute($value){
        if($value){
            return asset($this->path.$value);    
        }else{
            return $value;
        }
    }
}
