<?php
namespace App\Models;
use auth;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model{
    protected $guarded=[];
    protected $casts = [
    ];
    public $path= "/public/assets/front_assets/uploads/sliders/";
    public function getSlideImgAttribute($value){
        if($value){
            return asset($this->path.$value);    
        }else{
            return $value;
        }
    }
}
