<?php
namespace App\Models;
use auth;
use Illuminate\Database\Eloquent\Model;


class BookWithUs extends Model{
    protected $guarded=[];
    public $path= "/public/assets/front_assets/uploads/bookWithUs/";
    public function getImageAttribute($value){
        if($value){
            return asset($this->path.$value);    
        }else{
            return $value;
        }
    }
}
