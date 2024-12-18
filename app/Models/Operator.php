<?php

// app/Models/FormData.php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'operators';
    protected $fillable = [
        'country',
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
        'office_phone_number',
        'status',
        'is_approved',
    ];

    public function fleetDetail()
    {
        return $this->hasOne(FleetDetails::class);
    }
}
