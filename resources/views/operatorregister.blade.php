@extends('masters/master')
@section('title', 'Login')
@section('content')
    <style>
        .spinner-border {
            display: none;
            width: 3rem;
            height: 3rem;
            border: 0.25rem solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }

        .next-step1,
        .next-step2 {
            font-weight: bold;
            color: white;
            border: 0 none;
            cursor: pointer;
            padding: 14px 30px;
            margin: auto 0 0 auto;
            background-color: #ffcc00;
            font-size: 18px;
            border-radius: 10px;
            transition: all .3s ease-in;
            text-align: end;
            display: flex;
        }

        .next-step1:hover,
        .next-step2:hover,
        .member-login-center #form .next-step:focus {
            background-color: #008000;

        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <div id="midwrap1">
        <div class="container">
            <div class="member-loginsss">
                <ul id="progressbar" class="progressbar">
                    <li class="active" id="step1">
                        <div class="round">

                        </div>
                        <h5 style="display: block; text-align: center;">Account details</h5>
                    </li>
                    <li id="step2" style="display: block; text-align: center;">
                        <div class="round">

                        </div>
                        <h5>Licence & insurance</h5>
                    </li>
                    <li id="step3" style="display: block; text-align: center;">
                        <div class="round">

                        </div>
                        <h5>About your fleet</h5>
                    </li>
                </ul>
                <div class="progresss">
                    <div class="progress-bar"></div>
                </div>
            </div>
            <div class="cntblock">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="container">
                            <div class="member-login-center">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        @if (session('success'))
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
                                        <form id="form" method="POST"
                                            action="{{ route('user.makeOperatorRegisters') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="country" value="{{ $currCountry }}">
                                            <fieldset>
                                                <div class="form-heading">
                                                    <h3> Become part of the {{ $currCountry }} cab network</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="office_email" class="mt-2">Office Email Address
                                                            <span class="text-danger">*</span></label>
                                                        <input type="email" name="office_email"
                                                            class="form-control required" placeholder="office email address"
                                                            required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                        @error('office_email')
                                                            <strong class="text-danger"
                                                                style="font-size: 15px;">{{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="first_name" class="mt-2">First Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="first_name"
                                                            class="form-control required" placeholder="First Name" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="sur_name" class="mt-2">Your Surname <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="sur_name" class="form-control required"
                                                            placeholder="Your Surname" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="cab_operator_name" class="mt-2">Operator Name<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="cab_operator_name"
                                                            class="form-control required" placeholder="Operator Name"
                                                            required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="legal_company_name" class="mt-2">Legal Company
                                                            Name<span class="text-danger">*</span></label>
                                                        <input type="text" name="legal_company_name"
                                                            class="form-control required" placeholder="Legal Company Name"
                                                            required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="office_phone_number" class="mt-2">Office phone
                                                            number<span class="text-danger">*</span></label>

                                                        <input type="number" placeholder="Office phone number"
                                                            class="form-control required" required
                                                            name="office_phone_number" value="" minlength="10"
                                                            maxlength="10" pattern="[1-9]{1}[0-9]{9}" class="ys-field">

                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="postcode" class="mt-2">Postcode<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="postcode"
                                                            class="form-control required" placeholder="Postcode" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="website" class="mt-2">Website<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="website"
                                                            class="form-control required" placeholder="Website" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>
                                                <input type="button" name="next-step" class="next-step1"
                                                    value="Next Step" />

                                            </fieldset>

                                            <fieldset>
                                                <div class="form-heading">
                                                    <h3>We just need a few more details from you</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="licensing_local_authority" class="mt-2">Licensing
                                                            Local
                                                            Authority  <span class="text-danger">*</span></label>
                                                        <input type="text" name="licensing_local_authority"
                                                            class="form-control required"
                                                            placeholder="Licensing Local Authority" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="private_hire_operator_licence_number"
                                                            class="mt-2">Operator Licence Number <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="private_hire_operator_licence_number"
                                                            class="form-control required"
                                                            placeholder="Operator Licence Number " required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="licence_expiry_date" class="mt-2">Licence Expiry
                                                            Date
                                                            <span class="text-danger">*</span></label>
                                                        <input type="date" name="licence_expiry_date"
                                                            class="form-control required"
                                                            placeholder="Licence Expiry Date" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="upload_operator_licence" class="mt-2">Upload
                                                            Operator
                                                            Licence   <span class="text-danger">*</span></label>
                                                        <input type="file" name="upload_operator_licence"
                                                            class="form-control required"
                                                            placeholder="Upload Operator Licence " required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="upload_public_liability_Insurance"
                                                            class="mt-2">Upload
                                                            Public Liability Insurance  <span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" name="upload_public_liability_Insurance"
                                                            class="form-control required"
                                                            placeholder="Upload Public Liability Insurance" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 text-left">
                                                        <label for="Fleettype" class="mt-2">Fleet type<span
                                                                class="text-danger">*</span></label>
                                                        <div class="fleet">
                                                            <h4 class="my-0">Petrol, Diesel & Hybrid</h4>
                                                            <div class="box-all">

                                                                <div class="check-box" data-checkbox="1">
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="petrol_standard">
                                                                    <label for="petrol_standard">Standard</label>
                                                                </div>
                                                                <div class="check-box" data-checkbox="2">
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="petrol_executive">
                                                                    <label for="petrol_executive">Executive</label>
                                                                </div>
                                                                <div class="check-box" data-checkbox="3">
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="petrol_luxury">
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
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="electric_standard">
                                                                    <label for="petrol_standard">Standard</label>
                                                                </div>
                                                                <div class="check-box" data-checkbox="2">
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="electric_executive">
                                                                    <label for="petrol_executive">Executive</label>
                                                                </div>
                                                                <div class="check-box" data-checkbox="3">
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="electric_luxury">
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
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="wheelchair_standard">
                                                                    <label for="petrol_standard">Standard</label>
                                                                </div>
                                                                <div class="check-box" data-checkbox="2">
                                                                    <input type="checkbox" class="colorToggle"
                                                                        name="fleet_type[]" value="wheelchair_executive">
                                                                    <label for="petrol_executive">Executive</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="fleet_size" class="mt-2">Fleet size    <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="fleet_size"
                                                            class="form-control required" placeholder="Fleet size "
                                                            required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="dispatch_system" class="mt-2">Dispatch system <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="dispatch_system"
                                                            class="form-control required" placeholder="Dispatch system"
                                                            required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="email" class="mt-2">Email<span
                                                                class="text-danger">*</span></label>
                                                        <input type="email" name="email"
                                                            class="form-control required" placeholder="Email" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="password" class="mt-2">Password <span
                                                                class="text-danger">*</span></label>
                                                        <input type="password" id="password" name="password"
                                                            class="form-control required" placeholder="Password" required>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong></strong>
                                                        </span>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="confirm_password" class="mt-2">Confirm Password
                                                            <span class="text-danger">*</span></label>
                                                        <input type="password" id="confirm_password"
                                                            name="password_confirmation" class="form-control required"
                                                            placeholder="Confirm Password" required>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong></strong>
                                                        </span>
                                                        @error('password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="backbutton">
                                                    <input type="button" name="previous-step" class="previous-step"
                                                        value="Previous Step" />
                                                    <input type="button" name="next-step" class="next-step2"
                                                        value="Next Step" />
                                                </div>
                                            </fieldset>



                                            <fieldset>
                                                <div class="form-heading">
                                                    <h3> Let’s set up your account</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="authorised_contact_person" class="mt-2">Authorised
                                                            contact person <span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Authorised contact person"
                                                            class="form-control required" required
                                                            name="authorised_contact_person" value=""
                                                            minlength="10" maxlength="10" pattern="[1-9]{1}[0-9]{9}"
                                                            class="ys-field">
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="authorised_contact_email_address"
                                                            class="mt-2">Authorised contact’s email address <span
                                                                class="text-danger">*</span></label>
                                                        <input type="email" name="authorised_contact_email_address"
                                                            class="form-control required"
                                                            placeholder="Authorised contact’s email address" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="authorised_contact_mobile_number"
                                                            class="mt-2">Authorised contact’s mobile number  <span
                                                                class="text-danger">*</span></label>

                                                        <input type="text"
                                                            placeholder="Authorised contact’s mobile number "
                                                            class="form-control required" required
                                                            name="authorised_contact_mobile_number" value=""
                                                            minlength="10" maxlength="10" pattern="[1-9]{1}[0-9]{9}"
                                                            class="ys-field">


                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="about_us" class="mt-2">How did you hear about us?
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" name="about_us"
                                                            class="form-control required"
                                                            placeholder="How did you hear about us? " required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <!-- <div class="form-group col-md-6 text-left">
                                                                    <label for="revenue" class="mt-2">How much £ revenue each week
                                                                        would
                                                                        you like to earn <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" name="revenue" class="form-control required"
                                                                        placeholder="How much £ revenue each week would you like to earn "
                                                                        required>
                                                                    <span class="invalid-feedback">This field is required.</span>
                                                                </div> -->
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="revenue" class="mt-2">How much £ revenue each week
                                                            would you like to earn <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" name="revenue"
                                                            class="form-control required"
                                                            placeholder="How much £ revenue each week would you like to earn "
                                                            required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>

                                                </div>

                                                <div class="backbutton">
                                                    <input type="button" name="previous-step" class="previous-step"
                                                        value="Previous Step" />
                                                    <input type="submit" name="next-step" class="next-step"
                                                        value="Final Step" />
                                                </div>
                                            </fieldset>

                                        </form>
                                        <div class="spinner-border" id="spinner"></div>
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
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
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
        

            $(document).ready(function() {
                var current_fs, next_fs, previous_fs;
                var animating = false;

                // Set the minimum date to today for the licence expiry date input
                var today = new Date().toISOString().split('T')[0];
                $("input[name='licence_expiry_date']").attr('min', today);

                // Click handler for first step button (next-step1)
                $(".next-step1").click(function() {
                    current_fs = $(this).closest("fieldset");
                    var valid = true;

                    // Validate required fields for the first step and display error messages
                    current_fs.find('input:required').each(function() {
                        if ($(this).val().trim() === '') {
                            $(this).addClass('is-invalid');
                            $(this).next('.invalid-feedback').text(
                                'This field is required.').show();
                            valid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                            $(this).next('.invalid-feedback').hide();
                        }
                    });

                    // Validate email format
                    var email = $("input[name='office_email']").val();
                    if (email.trim() === '') {
                        $("input[name='office_email']").addClass('is-invalid');
                        $("input[name='office_email']").next('.invalid-feedback').text(
                            'This field is required.').show();
                        valid = false;
                    } else if (!isValidEmail(email)) {
                        $("input[name='office_email']").addClass('is-invalid');
                        $("input[name='office_email']").next('.invalid-feedback').text(
                            'Please enter a valid email address.').show();
                        valid = false;
                    } else {
                        $("input[name='office_email']").removeClass('is-invalid');
                        $("input[name='office_email']").next('.invalid-feedback').hide();
                    }

                    // Validate website format
                    var website = $("input[name='website']").val();
                    if (website.trim() === '') {
                        $("input[name='website']").addClass('is-invalid');
                        $("input[name='website']").next('.invalid-feedback').text(
                            'This field is required.').show();
                        valid = false;
                    } else if (!isValidUrl(website)) {
                        $("input[name='website']").addClass('is-invalid');
                        $("input[name='website']").next('.invalid-feedback').text(
                            'Please enter a valid URL.').show();
                        valid = false;
                    } else {
                        $("input[name='website']").removeClass('is-invalid');
                        $("input[name='website']").next('.invalid-feedback').hide();
                    }

                    // Validate phone number format
                    var phoneNumber = $("input[name='office_phone_number']").val();
                    if (phoneNumber.trim() === '') {
                        $("input[name='office_phone_number']").addClass('is-invalid');
                        $("input[name='office_phone_number']").next('.invalid-feedback').text(
                            'This field is required.').show();
                        valid = false;
                    } else if (!isValidPhoneNumber(phoneNumber)) {
                        $("input[name='office_phone_number']").addClass('is-invalid');
                        $("input[name='office_phone_number']").next('.invalid-feedback').text(
                            'Please enter a valid 10-digit phone number.').show();
                        valid = false;
                    } else {
                        $("input[name='office_phone_number']").removeClass('is-invalid');
                        $("input[name='office_phone_number']").next('.invalid-feedback').hide();
                    }

                    if (!valid) {
                        return false; // Prevents moving to the next page if validation fails
                    }

                    // Animation to transition to the next step (second page)
                    if (animating) return false;
                    animating = true;

                    next_fs = current_fs.next();

                    // Update progress bar if needed
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    // Perform animation to show next step
                    next_fs.show();
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now, mx) {
                            var scale = 1 - (1 - now) * 0.2;
                            var left = (now * 50) + "%";
                            var opacity = 1 - now;
                            current_fs.css({
                                'transform': 'scale(' + scale + ')',
                            });
                            next_fs.css({
                                'left': left,
                                'opacity': opacity
                            });
                        },
                        duration: 800,
                        complete: function() {
                            current_fs.hide();
                            animating = false;
                        },
                        easing: 'easeInOutBack'
                    });
                });

                // Click handler for second step button (next-step)
                $(".next-step2").click(function() {
                    current_fs = $(this).closest("fieldset");
                    var valid = true;

                    // Validate required fields for the second step and display error messages
                    current_fs.find('input:required').each(function() {
                        if ($(this).val().trim() === '') {
                            $(this).addClass('is-invalid');
                            $(this).next('.invalid-feedback').text(
                                'This field is required.').show();
                            valid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                            $(this).next('.invalid-feedback').hide();
                        }
                    });

                    // Validate licence expiry date
                    var licenceExpiryDate = $("input[name='licence_expiry_date']").val();
                    if (licenceExpiryDate.trim() === '') {
                        $("input[name='licence_expiry_date']").addClass('is-invalid');
                        $("input[name='licence_expiry_date']").next('.invalid-feedback').text(
                            'This field is required.').show();
                        valid = false;
                    } else if (!isValidDate(licenceExpiryDate)) {
                        $("input[name='licence_expiry_date']").addClass('is-invalid');
                        $("input[name='licence_expiry_date']").next('.invalid-feedback').text(
                            'Please enter a valid date.').show();
                        valid = false;
                    } else {
                        $("input[name='licence_expiry_date']").removeClass('is-invalid');
                        $("input[name='licence_expiry_date']").next('.invalid-feedback').hide();
                    }

                    var email = $("input[name='email']").val();
                    if (email.trim() === '') {
                        $("input[name='email']").addClass('is-invalid');
                        $("input[name='email']").next('.invalid-feedback').text(
                            'This field is required.').show();
                        valid = false;
                    } else if (!isValidEmail(email)) {
                        $("input[name='email']").addClass('is-invalid');
                        $("input[name='email']").next('.invalid-feedback').text(
                            'Please enter a valid email address.').show();
                        valid = false;
                    } else {
                        $("input[name='email']").removeClass('is-invalid');
                        $("input[name='email']").next('.invalid-feedback').hide();
                    }

                    // Validate password and confirm password match
                    var password = $("#password").val();
                    var confirmPassword = $("#confirm_password").val();
                    if (password.trim() === '') {
                        $("#password").addClass('is-invalid');
                        $("#password").siblings('.invalid-feedback').text('This field is required.')
                            .show();
                        valid = false;
                    } else {
                        $("#password").removeClass('is-invalid');
                        $("#password").siblings('.invalid-feedback').hide();
                    }

                    if (confirmPassword.trim() === '') {
                        $("#confirm_password").addClass('is-invalid');
                        $("#confirm_password").siblings('.invalid-feedback').text(
                            'This field is required.').show();
                        valid = false;
                    } else if (password !== confirmPassword) {
                        $("#confirm_password").addClass('is-invalid');
                        $("#confirm_password").siblings('.invalid-feedback').text(
                            'Passwords do not match.').show();
                        valid = false;
                    } else {
                        $("#confirm_password").removeClass('is-invalid');
                        $("#confirm_password").siblings('.invalid-feedback').hide();
                    }

                    if (!valid) {
                        return false; // Prevents moving to the next page if validation fails
                    }

                    // Animation to transition to the next step (third page or submission)
                    if (animating) return false;
                    animating = true;

                    next_fs = current_fs.next();

                    // Update progress bar if needed
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    // Perform animation to show next step
                    next_fs.show();
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now, mx) {
                            var scale = 1 - (1 - now) * 0.2;
                            var left = (now * 50) + "%";
                            var opacity = 1 - now;
                            current_fs.css({
                                'transform': 'scale(' + scale + ')',
                            });
                            next_fs.css({
                                'left': left,
                                'opacity': opacity
                            });
                        },
                        duration: 800,
                        complete: function() {
                            current_fs.hide();
                            animating = false;
                        },
                        easing: 'easeInOutBack'
                    });
                });


                $(".next-step").click(function() {
                    current_fs = $(this).closest("fieldset");
                    var valid = true;

                    // Validate required fields for the second step and display error messages
                    current_fs.find('input:required').each(function() {
                        if ($(this).val().trim() === '') {
                            $(this).addClass('is-invalid');
                            $(this).next('.invalid-feedback').text(
                                'This field is required.').show();
                            valid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                            $(this).next('.invalid-feedback').hide();
                        }
                    });
                

                    var email = $("input[name='authorised_contact_email_address']").val();
                    if (email.trim() === '') {
                        $("input[name='authorised_contact_email_address']").addClass('is-invalid');
                        $("input[name='authorised_contact_email_address']").next(
                            '.invalid-feedback').text('This field is required.').show();
                        valid = false;
                    } else if (!isValidEmail(email)) {
                        $("input[name='authorised_contact_email_address']").addClass('is-invalid');
                        $("input[name='authorised_contact_email_address']").next(
                                '.invalid-feedback').text('Please enter a valid email address.')
                            .show();
                        valid = false;
                    } else {
                        $("input[name='authorised_contact_email_address']").removeClass(
                            'is-invalid');
                        $("input[name='authorised_contact_email_address']").next(
                            '.invalid-feedback').hide();
                    }

                    // Validate revenue field for positive values
                    var revenue = $("input[name='revenue']").val();
                    if (revenue.trim() === '' || parseFloat(revenue) <= 0) {
                        $("input[name='revenue']").addClass('is-invalid');
                        $("input[name='revenue']").siblings('.invalid-feedback').text(
                            'Please enter a positive revenue value.').show();
                        valid = false;
                    } else {
                        $("input[name='revenue']").removeClass('is-invalid');
                        $("input[name='revenue']").siblings('.invalid-feedback').hide();
                    }

                    if (!valid) {
                        return false; // Prevents moving to the next page if validation fails
                    }

                    // Animation to transition to the next step (third page or submission)
                    if (animating) return false;
                    animating = true;

                    next_fs = current_fs.next();

                    // Update progress bar if needed
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    // Perform animation to show next step
                    next_fs.show();
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now, mx) {
                            var scale = 1 - (1 - now) * 0.2;
                            var left = (now * 50) + "%";
                            var opacity = 1 - now;
                            current_fs.css({
                                'transform': 'scale(' + scale + ')',
                            });
                            next_fs.css({
                                'left': left,
                                'opacity': opacity
                            });
                        },
                        duration: 800,
                        complete: function() {
                            current_fs.hide();
                            animating = false;
                        },
                        easing: 'easeInOutBack'
                    });
                });


                // Function to validate email format
                function isValidEmail(email) {
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }

                // Function to validate URL format
                function isValidUrl(url) {
                    var urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
                    return urlRegex.test(url);
                }

                // Function to validate phone number format
                function isValidPhoneNumber(phoneNumber) {
                    var phoneRegex = /^[0-9]{10}$/; // Adjust regex as per your number validation rules
                    return phoneRegex.test(phoneNumber);
                }

                // Function to validate date format
                function isValidDate(date) {
                    var selectedDate = new Date(date);
                    var today = new Date();
                    today.setHours(0, 0, 0, 0); // Set to midnight to only compare dates
                    return selectedDate >= today;
                }
            



            $(".previous-step").click(function() {
                if (animating) return false;
                animating = true;

                current_fs = $(this).closest("fieldset");
                previous_fs = $(this).closest("fieldset").prev();

                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                previous_fs.show();
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        var scale = 0.8 + (1 - now) * 0.2;
                        var left = ((1 - now) * 50) + "%";
                        var opacity = 1 - now;
                        current_fs.css({
                            'left': left
                        });
                        previous_fs.css({
                            'transform': 'scale(' + scale + ')',
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_fs.hide();
                        animating = false;
                    },
                    easing: 'easeInOutBack'
                });
            });
        });
    </script>
    <script>
        document.getElementById('form').addEventListener('submit', function(event) {
            document.getElementById('spinner').style.display = 'inline-block';
            setTimeout(function() {
                document.getElementById('spinner').style.display = 'none';
            }, 15000);
        });
    </script>
@endsection
@push('footer-scripts')
@endpush
