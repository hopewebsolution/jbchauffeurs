@extends('masters/master')
@section('title', 'Login')
@section('content')
<style>
    * { 
    margin: 0; 
    padding: 0
} 
  
html { 
    height: 100%
} 
  
h2{ 
    color: #008000
; 
} 
#form { 
    text-align: center; 
    position: relative; 
    margin-top: 20px
} 
  
#form fieldset { 
    background: white; 
    border: 0 none; 
    border-radius: 0.5rem; 
    box-sizing: border-box; 
    width: 100%; 
    margin: 0; 
    padding-bottom: 20px; 
    position: relative
} 
  
.finish { 
    text-align: center
} 
  
#form fieldset:not(:first-of-type) { 
    display: none
} 
  
#form .previous-step, .next-step { 
    width: 100px; 
    font-weight: bold; 
    color: white; 
    border: 0 none; 
    border-radius: 0px; 
    cursor: pointer; 
    padding: 10px 5px; 
    margin: 10px 5px 10px 0px; 
    float: right
} 
  
.form, .previous-step { 
    background: #616161; 
} 
  
.form, .next-step { 
    background: #EDC20B
; 
} 
  
#form .previous-step:hover, 
#form .previous-step:focus { 
    background-color: #000000
} 
  
#form .next-step:hover, 
#form .next-step:focus { 
    background-color: #008000

} 
  
.text { 
    color: #008000
; 
    font-weight: normal
} 
  
#progressbar { 
    margin-bottom: 30px; 
    overflow: hidden; 
    color: lightgrey 
} 
  
#progressbar .active { 
    color: #008000

} 
  
#progressbar li { 
    list-style-type: none; 
    font-size: 15px; 
    width: 25%; 
    float: left; 
    position: relative; 
    font-weight: 400
} 
  
#progressbar #step1:before { 
    content: "1"
} 
  
#progressbar #step2:before { 
    content: "2"
} 
  
#progressbar #step3:before { 
    content: "3"
} 
  

  
#progressbar li:before { 
    width: 45px;
    left: 43px;
    height: 46px;
    line-height: 27px;
    display: block;
    font-size: 31px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0px auto 15px auto;
    padding: 11px;
} 
  
#progressbar li:after { 
    content: ''; 
    width: 100%; 
    height: 2px; 
    background: lightgray; 
    position: absolute; 
    left: 0; 
    top: 25px; 
    z-index: -1
} 
  
#progressbar li.active:before, 
#progressbar li.active:after { 
    background: #008000

} 
  
.progress { 
    height: 2px
} 
  
.progress-bar { 
    background-color: #008000

}
#progressbar{
    position: relative;
    margin-top: -86px;
    margin-left: 61px;
    margin-right: 62px;
}
.invalid-feedback {
    color: red;
    display: none;
}

.is-invalid + .invalid-feedback {
    display: block;
}
.progresss {
    overflow: hidden;
    background-color: #f5f5f5;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
}
.fleet{
    background: #fdf8f8;
    padding: 20px;
    border: 1px solid #c3c3c3;
    border-radius: 10px;
    margin-bottom: 20px;

}
.fleet h4{
    text-align: left;
    margin: 0 auto 10px;
    font-size:16px;
}
.check-box {
    border: 1px solid #c3c3c3;
    padding: 7px 30px;
    border-radius: 10px;
    align-items: center;
    display: flex;
}
.check-box input{
    width: 23px;
    margin-top: 0;
}
.check-box label {
    font-weight: normal;
    font-size: 14px;
    margin-bottom: 0;
}
.box-all{
    display: flex;
    align-items: center;
    gap: 30px;
}
.colorToggle input:checked ~ .checkmark {
  background-color: #000;
}
</style>
<div id="midwrap1">
    <div class="container">
        <div class="member-loginsss" style="border-radius: 8px; margin: 10% 0 10% 0; position: relative; background-color: #ffffff;border: 1px solid #c4c4c4;">
          <ul id="progressbar"style="margin: 10px;display: flex;justify-content: center;">
            <li class="active" id="step1">
                <strong style="display: block; text-align: center;">Account details</strong> 
            </li> 
            <li id="step2" style="display: block; text-align: center;"><strong>Licence & insurance</strong></li> 
            <li id="step3" style="display: block; text-align: center;"><strong>About your fleet</strong></li> 
        </ul> 
        <div class="progresss">
            <div class="progress-bar"></div> 
        </div>
    </div>
    <div class="cntblock">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="member-login-center"style="position: relative;background-color: #ffffff;padding: 20px;border: 1px solid #c4c4c4;">
                    <div class="container">
                        <div class="row justify-content-center"> 
                            <div class="col-11 col-sm-9 col-md-7 col-lg-10 col-xl-5 text-center p-0 mt-3 mb-2"> 
                                <div class="px-0 pt-4 pb-0 mt-3 mb-3"> 
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                    <form id="form" method="POST" action="{{ route('user.makeOperatorRegisters') }}" enctype="multipart/form-data"> 
                                    @csrf
                                        <fieldset>
                                        <div class="text-center fw-bold">
                                          <h3> Become part of the Australla cab network</h3>
                                         </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="office_email" class="mt-2">Office Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" name="office_email" class="form-control required" placeholder="office email address" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="first_name" class="mt-2">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" class="form-control required" placeholder="First Name" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                            </div>
                                        
                                
                                            <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="sur_name" class="mt-2">Your Surname <span class="text-danger">*</span></label>
                                                        <input type="text" name="sur_name" class="form-control required" placeholder="Your Surname" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="cab_operator_name" class="mt-2">Operator Name<span class="text-danger">*</span></label>
                                                        <input type="text" name="cab_operator_name" class="form-control required" placeholder="Operator Name" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                            </div>


                                            <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="legal_company_name" class="mt-2">Legal Company Name<span class="text-danger">*</span></label>
                                                        <input type="text" name="legal_company_name" class="form-control required" placeholder="Legal Company Name" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="office_phone_number" class="mt-2">Office phone number<span class="text-danger">*</span></label>
                                                        <input type="number" name="office_phone_number" class="form-control required" placeholder="Office phone number" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                            </div>

                                         
                                            <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="postcode" class="mt-2">Postcode<span class="text-danger">*</span></label>
                                                        <input type="text" name="postcode" class="form-control required" placeholder="Postcode" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="website" class="mt-2">Website<span class="text-danger">*</span></label>
                                                        <input type="text" name="website" class="form-control required" placeholder="Website" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                            </div>
                                            <input type="button" name="next-step"class="next-step" value="Next Step"/>

                                        </fieldset>






                                         <fieldset>
                                         <div class="text-center fw-bold">
                                          <h3>We just need a few more details from you</h3>
                                         </div>
                                         <div class="row">
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="licensing_local_authority" class="mt-2">Licensing Local Authority  <span class="text-danger">*</span></label>
                                                    <input type="text" name="licensing_local_authority" class="form-control required" placeholder="Licensing Local Authority" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="private_hire_operator_licence_number" class="mt-2">Operator Licence Number <span class="text-danger">*</span></label>
                                                    <input type="number" name="private_hire_operator_licence_number" class="form-control required" placeholder="Operator Licence Number " required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="licence_expiry_date" class="mt-2">Licence Expiry Date  <span class="text-danger">*</span></label>
                                                    <input type="date" name="licence_expiry_date" class="form-control required" placeholder="Licence Expiry Date" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="upload_operator_licence" class="mt-2">Upload Operator Licence   <span class="text-danger">*</span></label>
                                                    <input type="file" name="upload_operator_licence" class="form-control required" placeholder="Upload Operator Licence " required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="upload_public_liability_Insurance" class="mt-2">Upload Public Liability Insurance  <span class="text-danger">*</span></label>
                                                    <input type="file" name="upload_public_liability_Insurance" class="form-control required" placeholder="Upload Public Liability Insurance" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="fleet_size" class="mt-2">Fleet size    <span class="text-danger">*</span></label>
                                                    <input type="text" name="fleet_size" class="form-control required" placeholder="Fleet size " required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="dispatch_system" class="mt-2">Dispatch system <span class="text-danger">*</span></label>
                                                    <input type="text" name="dispatch_system" class="form-control required" placeholder="Dispatch system" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-lg-12 text-left">
                                                <label for="Fleettype" class="mt-2">Fleet type<span class="text-danger">*</span></label>
                                                <div class="fleet" >
                                                    <h4 class="my-0">Petrol, Diesel & Hybrid</h4>
                                                    <div class="box-all">

                                                        <div class="check-box" data-checkbox="1">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="petrol_standard">
                                                            <label for="petrol_standard">Standard</label>
                                                        </div>
                                                        <div class="check-box" data-checkbox="2">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="petrol_executive">
                                                            <label for="petrol_executive">Executive</label>
                                                        </div>
                                                        <div class="check-box" data-checkbox="3">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="petrol_luxury">
                                                            <label for="petrol_luxury">Luxury</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 text-left">
                                                <div class="fleet">
                                                    <h4 class="my-0">Electric (EV)</h4>
                                                    <div class="box-all">
                                                        <div class="check-box" data-checkbox="1">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="electric_standard">
                                                            <label for="petrol_standard">Standard</label>
                                                        </div>
                                                        <div class="check-box" data-checkbox="2">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="electric_executive">
                                                            <label for="petrol_executive">Executive</label>
                                                        </div>
                                                        <div class="check-box" data-checkbox="3">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="electric_luxury">
                                                            <label for="petrol_luxury">Luxury</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                           
                                            <div class="row">
                                                <div class="col-lg-12 text-left">
                                                    <div class="fleet">
                                                        <h4 class="my-0">Wheelchair Accessible (WAV)</h4>
                                                        <div class="box-all">
                                                        <div class="check-box" data-checkbox="1">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="wheelchair_standard">
                                                            <label for="petrol_standard">Standard</label>
                                                        </div>
                                                        <div class="check-box" data-checkbox="2">
                                                            <input type="checkbox" class="colorToggle" name="fleet_type[]" value="wheelchair_executive">
                                                            <label for="petrol_executive">Executive</label>
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="email" class="mt-2">Email<span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control required" placeholder="Email" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                            </div>



                                            <div class="row">
                                            <div class="form-group col-md-6 text-left">
                                            <label for="password" class="mt-2">Password <span class="text-danger">*</span></label>
                                            <input type="password" id="password" name="password" class="form-control required" placeholder="Password" required>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 text-left">
                                            <label for="confirm_password" class="mt-2">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" id="confirm_password" name="password_confirmation" class="form-control required" placeholder="Confirm Password" required>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                            </div>






                                            <input type="button" name="next-step"class="next-step" value="Next Step" />
                                            <input type="button" name="previous-step"class="previous-step"value="Previous Step" />
                                        </fieldset>







                                         <fieldset>





                                       <div class="text-center fw-bold">
                                          <h3> Let’s set up your account</h3>
                                         </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="authorised_contact_person" class="mt-2">Authorised contact person <span class="text-danger">*</span></label>
                                                    <input type="number" name="authorised_contact_person" class="form-control required" placeholder="Authorised contact person" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                                <div class="form-group col-md-6 text-left">
                                                    <label for="authorised_contact_email_address" class="mt-2">Authorised contact’s email address <span class="text-danger">*</span></label>
                                                    <input type="email" name="authorised_contact_email_address" class="form-control required" placeholder="Authorised contact’s email address" required>
                                                    <span class="invalid-feedback">This field is required.</span>
                                                </div>
                                            </div>
                                        
                                
                                            <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="authorised_contact_mobile_number" class="mt-2">Authorised contact’s mobile number  <span class="text-danger">*</span></label>
                                                        <input type="number" name="authorised_contact_mobile_number" class="form-control required" placeholder="Authorised contact’s mobile number " required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="about_us" class="mt-2">How did you hear about us? <span class="text-danger">*</span></label>
                                                        <input type="text" name="about_us" class="form-control required" placeholder="How did you hear about us? " required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                            </div>


                                            <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="revenue" class="mt-2">How much £ revenue each week would you like to earn from minicabit?<span class="text-danger">*</span></label>
                                                        <input type="text" name="revenue" class="form-control required" placeholder="How much £ revenue each week would you like to earn from minicabit?" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    
                                            </div>

                            
                                         <input type="submit" name="next-step"class="next-step" value="Final Step" />
                                         <input type="button" name="previous-step"class="previous-step"value="Previous Step" />
                                        </fieldset>
                                        
                                    </form> 
                                </div> 
                             </div>
                            </div> 
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src= 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script> 
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.colorToggle');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const colorBox = checkbox.closest('.check-box');
            if (checkbox.checked) {
                colorBox.style.backgroundColor = '#99cbb4';
            } else {
                colorBox.style.backgroundColor = 'white';
            }
        });
    });
});
</script>
<script>
    $(document).ready(function () {
        var current_fs, next_fs, previous_fs; //fieldsets
        var animating; //flag to prevent quick multi-click glitches

        $(".next-step").click(function () {
            current_fs = $(this).closest("fieldset");
            
            // Validation check for required fields
            var valid = true;
            current_fs.find('input:required').each(function() {
                if ($(this).val() === '') {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!valid) {
                //  alert('Please fill all required fields.');
                return false;
            }

            if (animating) return false;
            animating = true;

            next_fs = $(this).closest("fieldset").next();

            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            next_fs.show();
            current_fs.animate({ opacity: 0 }, {
                step: function (now, mx) {
                    var scale = 1 - (1 - now) * 0.2;
                    var left = (now * 50) + "%";
                    var opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'absolute'
                    });
                    next_fs.css({ 'left': left, 'opacity': opacity });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });
        });

        $(".previous-step").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).closest("fieldset");
            previous_fs = $(this).closest("fieldset").prev();

            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            previous_fs.show();
            current_fs.animate({ opacity: 0 }, {
                step: function (now, mx) {
                    var scale = 0.8 + (1 - now) * 0.2;
                    var left = ((1 - now) * 50) + "%";
                    var opacity = 1 - now;
                    current_fs.css({ 'left': left });
                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });
        });
    });
</script>
@endsection
@push('footer-scripts')
    
@endpush