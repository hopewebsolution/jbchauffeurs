<?php
namespace App\Models;
use auth;
use Illuminate\Database\Eloquent\Model;


class PageSection extends Model{

    protected $table = 'page_sections';

    protected $fillable = [
        'id',
        'page_id',
        'section_type',
        'section_heading',
        'section_image',
        'section_content',
        'section_btn_text',
        'section_btn_link'
    ];

    public $path= "/assets/front_assets/uploads/pages/";

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getImageAttribute($value){
        return isset($this->section_image) ? asset($this->path.$this->section_image):'';
    }

}
