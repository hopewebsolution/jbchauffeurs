@extends('Admin/masters/master')
@section('title', $title)
@push('page-scripts')
@endpush
@section('content')


<div class="container">
    <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ url('public/assets/operator_dashboard_asset/img/avatar1.avif') }}" alt="Admin" class="rounded-circle" width="150">
                                <a href="{{ route('admin.operator.edit', $operator->id) }}" class="edit-button btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                                <div class="mt-3 pt-1">
                                    <table class="table text-left mt-3 profile-details">
                                        <tr>
                                            <th><p>Full Name</p></th>
                                            <td><p>{{ $operator->first_name ?? ''}} {{ $operator->sur_name ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Operator Name</p></th>
                                            <td><p>{{ $operator->cab_operator_name ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Email</p></th>
                                            <td><p>{{ $operator->email ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Office Email</p></th>
                                            <td><p>{{ $operator->office_email ?? '' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Office Phone Number</p></th>
                                            <td><p>{{ $operator->office_phone_number ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p class="text-muted font-size-sm">Status: </p></th>
                                            <td><p>{!! $operator->status ?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-Active</span>' !!}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p class="text-muted font-size-sm">Is Approved: </p></th>
                                            <td><p>{!! $operator->is_approved ?'<span class="badge badge-success">Approved</span>':'<span class="badge badge-danger">Un-Approved</span>' !!}</p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title">Profile Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table text-left mt-3 other-details">
                                        <tr>
                                            <th><p>Legal Company Name</p></th>
                                            <td><p>{{ $operator->legal_company_name ?? ''}}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Postcode</p></th>
                                            <td><p>{{ $operator->postcode ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Licensing Local Authority</p></th>
                                            <td><p>{{ $operator->fleetDetail->licensing_local_authority ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Licence Expiry Date</p></th>
                                            <td><p>{{ $operator->fleetDetail->licence_expiry_date ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Dispatch system</p></th>
                                            <td><p>{{ $operator->fleetDetail->dispatch_system ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Authorised Contact Person</p></th>
                                            <td><p>{{ $operator->authorised_contact_person ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Authorised Contact Mobile Number</p></th>
                                            <td><p>{{ $operator->authorised_contact_mobile_number ??'' }}</p></td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table text-left mt-3 profile-details">
                                        <tr>
                                            <th><p>Website</p></th>
                                            <td><p>{{ $operator->website ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Operator Licence Number</p></th>
                                            <td><p>{{ $operator->fleetDetail->private_hire_operator_licence_number ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Fleet size</p></th>
                                            <td><p>{{ $operator->fleetDetail->fleet_size ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Authorised Contact Email Address</p></th>
                                            <td><p>{{ $operator->authorised_contact_email_address ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>How Did You Hear About Us</p></th>
                                            <td><p>{{ $operator->about_us ??'' }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>How Much £ Revenue Each Week Would You Like To Earn</p></th>
                                            <td><p>{{ $operator->revenue ??'' }}</p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mb-3 mt-3">
                        <div class="card-body">
                            <h4 class="card-title">Booking Details</h4>
                            <div class="x_panel">
                                {{-- <div class="x_title">
                                <h2>All Bookings</h2>
                                <div class="navbar-right">
                                    <a href="{{ route('admin.bookings.add') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add New</a>
                                </div>
                                <div class="clearfix"></div>
                                </div> --}}

                                {{-- <div class="title_right">
                                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                        <div class="input-group">
                                            <input type="text" id="search_key" class="form-control searchInput" placeholder="Search for...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Go!</button>
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="x_content hws_table_responsive" id="ajax_data">
                                @include('Admin.bookingsTable')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .edit-button {
        position: absolute !important;
        right: 0;
        top: 5px;
    }
    .profile-details tr th {
        width: 150px;
        padding: 10px 0 !important;
    }
    .profile-details tr th p, .profile-details tr td p {
        margin: 0;
    }
    .other-details tr th {
        width: 175px;
        padding: 10px 0 !important;
    }
    .main-body {
        padding: 15px;
    }
    .card {
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col, .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }
    .mb-3, .my-3 {
        margin-bottom: 1rem!important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }
    .h-100 {
        height: 100%!important;
    }
    .shadow-none {
        box-shadow: none!important;
    }
    .badge-danger {
        color: #fff;
        background-color: #dc3545;
    }
    .badge-success {
        color: #fff;
        background-color: #28a745;
    }
</style>
@endsection
@push('footer-scripts')
  <script>
    $(document).ready(function(){

    });
  </script>
@endpush
