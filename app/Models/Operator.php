<?php

// app/Models/FormData.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $table = 'operators'; // Define the table name explicitly
    
    protected $fillable = ['email', 'office_email','first_name','sur_name','cab_operator_name','legal_company_name','office_phone_number']; 
}