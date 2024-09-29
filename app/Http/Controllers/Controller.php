<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $mapKey  = 'AIzaSyAUyoYHMKgjoMLJ35qSgMnGD9uGYPHWyj4';
    public $sliderPath = "/assets/front_assets/uploads/sliders";
    public $OperatorLicencePath = "/assets/front_assets/uploads/OperatorLicence";
    public $servicePath = "/assets/front_assets/uploads/services";
    public $vehiclePath = "/assets/front_assets/uploads/vehicles";
    public $airportPath = "/assets/front_assets/uploads/airports";
    public $pagePath = "/assets/front_assets/uploads/pages";
    public $blocksPath = "/assets/front_assets/uploads/sidebar";
    public $bookWithUs = "/assets/front_assets/uploads/bookWithUs";
    public $adminEmail = "jbc24hrs@gmail.com";
    public $adminEmail1 = "jbc_London@aol.co.uk";
    public $perpage = 12;
    public $adminEmails = [
        'aus' => ['silver_connect@aol.com', 'jbchauffeurss@gmail.com'],
        'uk' => ['jbc_London@aol.co.uk', 'jbc24hrs@gmail.com'],
        'nz' => ['silver_connect@aol.com', 'jbchauffeurss@gmail.com'],
        'us' => ['silver_connect@aol.com', 'jbchauffeurss@gmail.com']
    ];
    public $countries = [
        ['short' => 'uk', 'name' => 'United Kingdom', 'flag' => 'uk.png', 'currency' => '£', 'logo' => 'uklogo.png', "currency_code" => "GBP"],
        ['short' => 'aus', 'name' => 'Australia', 'flag' => 'au.png', 'currency' => '$', 'logo' => 'aulogo.png', "currency_code" => "AUD"],
        ['short' => 'nz', 'name' => 'New Zealand', 'flag' => 'nz.png', 'currency' => '$', 'logo' => 'nzlogo.jpg', "currency_code" => "NZD"],
        ['short' => 'us', 'name' => 'United States', 'flag' => 'us.png', 'currency' => '$', 'logo' => 'uslogo.jpg', "currency_code" => "USD"],
    ];
    public $babySeats = [
        'no' => 'No',
        'baby_seat' => 'Baby Seat',
        'booster_seat' => 'Booster Seat',
        '2_baby_seat' => '2 Baby Seat',
        '2_booster_seat' => '2 Booster Seat',
        'booster_baby' => 'Baby & Booster Seat'
    ];
    public $infoTypes = [
        'book-without-register' => 'Book without Registering.',
        'book-with-register' => 'Register and Continue Your Booking.',
        'book-with-login' => 'Already Registered? Login and Continue Your Booking.',
    ];
    public $infoTypesAdmin = [
        'book-with-register' => 'Book without Registering.',
    ];
    public $page_types = [
        "home" => "Home",
        "customer" => "Customer Login",
        "operator" => "Operators Login",
        "about-us" => "About Us",
        "airports" => "Airport Transfers",
        "how-it-works" => "How It Works",
        "contact-us" => "Contact Us",
        "operator-registers" => "Operator Registers",
        "terms-conditions" => "Terms & Conditions",
        "customer-terms" => "Customer Registration T&C",
        "privacy" => "Privacy Policy",
    ];
    public $bookingStatus = [
        "pending" => "pending",
        "intransit" => "In-Transit",
        "cancelled" => "Cancelled",
        "completed" => "Completed",
    ];
    public $userbookingStatus = [
        "pending" => "pending",
        "intransit" => "In-Transit",
        "completed" => "Completed",
    ];


    public $settings = [
        "logo",
        "header_img",
        "twitter",
        "insta",
        "linkedin",
        "facebook",
    ];
    public function fileUpload(Request $request, $image_key, $upload_path = "")
    {
        $fileName = "";
        if ($upload_path == "") {
            $upload_path = "/assets/images";
        }
        if ($request->hasFile($image_key)) {
            $image = $request->file($image_key);
            $fileName = $name = time() . '_' . $image_key . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path($upload_path);

            $image->move($destinationPath, $name);
            // dd($image);
        }
        return $fileName;
    }
    public function getDropArray($arrays, $key_ = 'id', $value_ = 'name')
    {
        $assoArray = array();
        foreach ($arrays as $arr) {
            $assoArray[$arr->$key_] = $arr->$value_;
        }
        return $assoArray;
    }
    public function getAssociate($array)
    {
        $assoArray = array();
        foreach ($array as $key => $value) {
            $rowArr = array();
            $rowArr['key'] = $key;
            $rowArr['value'] = $value;
            $assoArray[] = $rowArr;
        }
        return $assoArray;
    }
    function distance_k($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
    public function getDistance($origin, $destination, $unit = "M")
    {
        $from = urlencode($origin);
        $to = urlencode($destination);
        $distance = 0;
        $time = 0;
        if ($from != "" && $to != "") {
            $apiKey = config('services.google_map_key');
            $data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&key=$apiKey&language=en-EN&sensor=false");
            $data = json_decode($data);

            if ($data != "") {
                $status = $data->rows[0]->elements[0]->status;
                if ($status == "OK") {
                    foreach ($data->rows[0]->elements as $road) {
                        $time += $road->duration->value;
                        $distance += $road->distance->value;
                    }
                    $unit = strtoupper($unit);
                    if ($unit == "K") {
                        $distance = round(($distance / 1000), 2);
                    } elseif ($unit == "M") {
                        $distance = round(($distance / 1609.344), 2);
                    } else {
                        $distance = round($distance, 2);
                    }
                }
            }
        }
        return $distance;
    }

    public function sendVerificationEmail($user)
    {
        $temporarySignedURL = URL::temporarySignedRoute(
            'operator.verify-email',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        Mail::to($user->email)->send(new WelcomeEmail($user, $temporarySignedURL));
    }
}
