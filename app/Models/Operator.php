<?php

// app/Models/FormData.php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $table = 'operators'; // Define the table name explicitly
    
    protected $fillable = [
        'email',
        'password', 
        'office_email',
        'first_name',
        'postcode',
        'website',
        'sur_name',
        'cab_operator_name',
        'legal_company_name',
        'authorised_contact_person',
        'authorised_contact_email_address',
        'authorised_contact_mobile_number',
        'about_us',
        'revenue',
        'office_phone_number'
    ]; 

   
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

}