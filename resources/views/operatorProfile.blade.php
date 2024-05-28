@extends('app.master')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ asset('public/assets/operator_dashboard_asset/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <h2>Kevin Anderson</h2>

                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h3 class="profile-title">Profile Details
                                </h3>
                                <h5 class="card-title">Account Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company</div>
                                    <div class="col-lg-9 col-md-8">Lueilwitz, Wisoky and Leuschke</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Job</div>
                                    <div class="col-lg-9 col-md-8">Web Designer</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">USA</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                                </div>
                                <h5 class="card-title">Licence & insurance</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company</div>
                                    <div class="col-lg-9 col-md-8">Lueilwitz, Wisoky and Leuschke</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Job</div>
                                    <div class="col-lg-9 col-md-8">Web Designer</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">USA</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                                </div>
                                <h5 class="card-title">Fleet</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company</div>
                                    <div class="col-lg-9 col-md-8">Lueilwitz, Wisoky and Leuschke</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Job</div>
                                    <div class="col-lg-9 col-md-8">Web Designer</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">USA</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <div id="midwrap1">
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
                                                <div class="member-login-center">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-12">
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
                                                            <form id="form" method="POST"
                                                                action="{{ route('user.makeOperatorRegisters') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <fieldset>
                                                                    <div class="form-heading">
                                                                        <h3> Become part of the Australla cab
                                                                            network</h3>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="office_email"
                                                                                class="mt-2">Office Email Address
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="email" name="office_email"
                                                                                class="form-control required"
                                                                                placeholder="Office email address"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="first_name" class="mt-2">First
                                                                                Name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="first_name"
                                                                                class="form-control required"
                                                                                placeholder="First Name" required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="sur_name" class="mt-2">Your
                                                                                Surname <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="sur_name"
                                                                                class="form-control required"
                                                                                placeholder="Your Surname" required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="cab_operator_name"
                                                                                class="mt-2">Operator Name<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="cab_operator_name"
                                                                                class="form-control required"
                                                                                placeholder="Operator Name" required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="legal_company_name"
                                                                                class="mt-2">Legal Company
                                                                                Name<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="legal_company_name"
                                                                                class="form-control required"
                                                                                placeholder="Legal Company Name"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="office_phone_number"
                                                                                class="mt-2">Office phone
                                                                                number<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="number"
                                                                                name="office_phone_number"
                                                                                class="form-control required"
                                                                                placeholder="Office phone number"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="postcode"
                                                                                class="mt-2">Postcode<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="postcode"
                                                                                class="form-control required"
                                                                                placeholder="Postcode" required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="website"
                                                                                class="mt-2">Website<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="website"
                                                                                class="form-control required"
                                                                                placeholder="Website" required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>
                                                                    <input type="button" name="next-step"
                                                                        class="next-step" value="Next Step" />

                                                                </fieldset>






                                                                <fieldset>
                                                                    <div class="form-heading">
                                                                        <h3>We just need a few more details from you
                                                                        </h3>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="licensing_local_authority"
                                                                                class="mt-2">Licensing
                                                                                Local
                                                                                Authority  <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text"
                                                                                name="licensing_local_authority"
                                                                                class="form-control required"
                                                                                placeholder="Licensing Local Authority"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label
                                                                                for="private_hire_operator_licence_number"
                                                                                class="mt-2">Operator Licence Number
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="number"
                                                                                name="private_hire_operator_licence_number"
                                                                                class="form-control required"
                                                                                placeholder="Operator Licence Number "
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="licence_expiry_date"
                                                                                class="mt-2">Licence Expiry
                                                                                Date 
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="date"
                                                                                name="licence_expiry_date"
                                                                                class="form-control required"
                                                                                placeholder="Licence Expiry Date"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="upload_operator_licence"
                                                                                class="mt-2">Upload
                                                                                Operator
                                                                                Licence   <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="file"
                                                                                name="upload_operator_licence"
                                                                                class="form-control required"
                                                                                placeholder="Upload Operator Licence "
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label
                                                                                for="upload_public_liability_Insurance"
                                                                                class="mt-2">Upload
                                                                                Public Liability Insurance  <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="file"
                                                                                name="upload_public_liability_Insurance"
                                                                                class="form-control required"
                                                                                placeholder="Upload Public Liability Insurance"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-left">
                                                                            <label for="Fleettype" class="mt-2">Fleet
                                                                                type<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="fleet">
                                                                                <h4 class="my-0">Petrol, Diesel &
                                                                                    Hybrid</h4>
                                                                                <div class="box-all">

                                                                                    <div class="check-box"
                                                                                        data-checkbox="1">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="petrol_standard">
                                                                                        <label
                                                                                            for="petrol_standard">Standard</label>
                                                                                    </div>
                                                                                    <div class="check-box"
                                                                                        data-checkbox="2">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="petrol_executive">
                                                                                        <label
                                                                                            for="petrol_executive">Executive</label>
                                                                                    </div>
                                                                                    <div class="check-box"
                                                                                        data-checkbox="3">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="petrol_luxury">
                                                                                        <label
                                                                                            for="petrol_luxury">Luxury</label>
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
                                                                                    <div class="check-box"
                                                                                        data-checkbox="1">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="electric_standard">
                                                                                        <label
                                                                                            for="petrol_standard">Standard</label>
                                                                                    </div>
                                                                                    <div class="check-box"
                                                                                        data-checkbox="2">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="electric_executive">
                                                                                        <label
                                                                                            for="petrol_executive">Executive</label>
                                                                                    </div>
                                                                                    <div class="check-box"
                                                                                        data-checkbox="3">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="electric_luxury">
                                                                                        <label
                                                                                            for="petrol_luxury">Luxury</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-left">
                                                                            <div class="fleet">
                                                                                <h4 class="my-0">Wheelchair
                                                                                    Accessible (WAV)</h4>
                                                                                <div class="box-all">
                                                                                    <div class="check-box"
                                                                                        data-checkbox="1">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="wheelchair_standard">
                                                                                        <label
                                                                                            for="petrol_standard">Standard</label>
                                                                                    </div>
                                                                                    <div class="check-box"
                                                                                        data-checkbox="2">
                                                                                        <input type="checkbox"
                                                                                            class="colorToggle"
                                                                                            name="fleet_type[]"
                                                                                            value="wheelchair_executive">
                                                                                        <label
                                                                                            for="petrol_executive">Executive</label>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <!-- <div class="row">
                                                    <div class="form-group col-md-6 text-left">
                                                        <label for="email" class="mt-2">Email<span
                                                                class="text-danger">*</span></label>
                                                        <input type="email" name="email" class="form-control required"
                                                            placeholder="Email" required>
                                                        <span class="invalid-feedback">This field is required.</span>
                                                    </div>
                                                </div> -->

                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="fleet_size" class="mt-2">Fleet
                                                                                size    <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="fleet_size"
                                                                                class="form-control required"
                                                                                placeholder="Fleet size " required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="dispatch_system"
                                                                                class="mt-2">Dispatch system <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="dispatch_system"
                                                                                class="form-control required"
                                                                                placeholder="Dispatch system" required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="password" class="mt-2">Password
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="password" id="password"
                                                                                name="password"
                                                                                class="form-control required"
                                                                                placeholder="Password" required>
                                                                            @error('password')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="confirm_password"
                                                                                class="mt-2">Confirm Password
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="password" id="confirm_password"
                                                                                name="password_confirmation"
                                                                                class="form-control required"
                                                                                placeholder="Confirm Password" required>
                                                                            @error('password_confirmation')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>





                                                                    <div class="backbutton">
                                                                        <input type="button" name="previous-step"
                                                                            class="previous-step"
                                                                            value="Previous Step" />
                                                                        <input type="button" name="next-step"
                                                                            class="next-step" value="Next Step" />
                                                                    </div>
                                                                </fieldset>







                                                                <fieldset>





                                                                    <div class="form-heading">
                                                                        <h3> Let’s set up your account</h3>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="authorised_contact_person"
                                                                                class="mt-2">Authorised
                                                                                contact person <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="number"
                                                                                name="authorised_contact_person"
                                                                                class="form-control required"
                                                                                placeholder="Authorised contact person"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label
                                                                                for="authorised_contact_email_address"
                                                                                class="mt-2">Authorised contact’s
                                                                                email address <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="email"
                                                                                name="authorised_contact_email_address"
                                                                                class="form-control required"
                                                                                placeholder="Authorised contact’s email address"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label
                                                                                for="authorised_contact_mobile_number"
                                                                                class="mt-2">Authorised contact’s
                                                                                mobile number  <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="number"
                                                                                name="authorised_contact_mobile_number"
                                                                                class="form-control required"
                                                                                placeholder="Authorised contact’s mobile number "
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="about_us" class="mt-2">How
                                                                                did you hear about us?
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="about_us"
                                                                                class="form-control required"
                                                                                placeholder="How did you hear about us? "
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="form-group col-md-6 text-left">
                                                                            <label for="revenue" class="mt-2">How
                                                                                much £ revenue each week
                                                                                would
                                                                                you like to earn from
                                                                                minicabit?<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="revenue"
                                                                                class="form-control required"
                                                                                placeholder="How much £ revenue each week would you like to earn from minicabit?"
                                                                                required>
                                                                            <span class="invalid-feedback">This
                                                                                field is required.</span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="backbutton">
                                                                        <input type="button" name="previous-step"
                                                                            class="previous-step"
                                                                            value="Previous Step" />
                                                                        <input type="submit" name="next-step"
                                                                            class="next-step" value="Final Step" />
                                                                    </div>
                                                                </fieldset>

                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="clear"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>




                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

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
    var current_fs, next_fs, previous_fs; //fieldsets
    var animating; //flag to prevent quick multi-click glitches

    $(".next-step").click(function() {
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
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                var scale = 1 - (1 - now) * 0.2;
                var left = (now * 50) + "%";
                var opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'position': 'absolute'
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
@endsection