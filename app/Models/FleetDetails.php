<?php

// app/Models/FormData.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetDetails extends Model
{
    protected $table = 'fleet_details';
    
    protected $fillable = [
        'operator_id',
        'licensing_local_authority',
        'private_hire_operator_licence_number',
        'licence_expiry_date',
        'upload_public_liability_Insurance',
        'authorised_contact_email_address',
        'authorised_contact_mobile_number',
        'fleet_type',
        'fleet_size',
        'dispatch_system',
        'confirm_password',
        'upload_operator_licence'
    ]; 

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }
}