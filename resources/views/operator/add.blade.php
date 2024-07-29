@extends('app.master')
@section('content')
<main id="main" class="main">
    <div class="pagetitle" style="position: relative;">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('operator.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ $title ??'' }}</li>
            </ol>
        </nav>
        {{-- <a href="{{ route('operator.vehicles.create') }}" class="btn btn-primary add-new">Add New</a> --}}
    </div>
    {{-- {{ $errors }} --}}
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('operator.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="operator_id" value="{{ Auth::guard('weboperator')->user()->id }}">
                    <input type="hidden" name="id" value="{{ $vehicle->id??'' }}">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $title }}</h5>

                            <div class="row mb-3">
                                <div class="mt-3 col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                                        <input name="name" type="text" class="form-control" id="name" value="{{ isset($vehicle->name)?$vehicle->name:old('name') }}">
                                        @if($errors->has('name' ))
                                            <p class="help-block">
                                                {{ $errors->first('name') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="passengers" class="col-md-4 col-lg-3 col-form-label">Passengers</label>
                                        <input name="passengers" type="number" class="form-control" id="passengers" value="{{ isset($vehicle->passengers)?$vehicle->passengers:old('passengers') }}">
                                        @if($errors->has('passengers' ))
                                            <p class="help-block">
                                                {{ $errors->first('passengers') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="suitecases" class="col-md-4 col-lg-3 col-form-label">Hand Bags</label>
                                        <input name="suitecases" type="number" class="form-control" id="suitecases" value="{{ isset($vehicle->suitecases)?$vehicle->suitecases:old('suitecases') }}">
                                        @if($errors->has('suitecases' ))
                                            <p class="help-block">
                                                {{ $errors->first('suitecases') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="luggages" class="col-md-4 col-lg-3 col-form-label">Luggages</label>
                                        <input name="luggages" type="number" class="form-control" id="luggages" value="{{ isset($vehicle->luggages)?$vehicle->luggages:old('luggages') }}">
                                        @if($errors->has('luggages' ))
                                            <p class="help-block">
                                                {{ $errors->first('luggages') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="per_stop" class="col-md-4 col-lg-3 col-form-label">Additional Stop:</label>
                                        <input name="per_stop" type="number" class="form-control" id="per_stop" value="{{ isset($vehicle->per_stop)?$vehicle->per_stop:old('per_stop') }}">
                                        @if($errors->has('per_stop' ))
                                            <p class="help-block">
                                                {{ $errors->first('per_stop') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="baby_seat" class="col-md-4 col-lg-3 col-form-label">Baby Seat</label>
                                        <input name="baby_seat" type="number" class="form-control" id="baby_seat" value="{{ isset($vehicle->baby_seat)?$vehicle->baby_seat:old('baby_seat') }}">
                                        @if($errors->has('baby_seat' ))
                                            <p class="help-block">
                                                {{ $errors->first('baby_seat') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="parking_charge" class="col-md-4 col-lg-3 col-form-label">Parking</label>
                                        <input name="parking_charge" type="number" class="form-control" id="parking_charge" value="{{ isset($vehicle->parking_charge)?$vehicle->parking_charge:old('parking_charge') }}">
                                        @if($errors->has('parking_charge' ))
                                            <p class="help-block">
                                                {{ $errors->first('parking_charge') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="fixed_rate" class="col-md-4 col-lg-3 col-form-label">Fixed Rate(0-300%)</label>
                                        <input name="fixed_rate" type="number" class="form-control" id="fixed_rate" value="{{ isset($vehicle->fixed_rate)?$vehicle->fixed_rate:old('fixed_rate') }}">
                                        @if($errors->has('fixed_rate' ))
                                            <p class="help-block">
                                                {{ $errors->first('fixed_rate') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="position" class="col-md-4 col-lg-3 col-form-label">Order</label>
                                        <input name="position" type="number" class="form-control" id="position" value="{{ isset($vehicle->position)?$vehicle->position:old('position') }}">
                                        @if($errors->has('position' ))
                                            <p class="help-block">
                                                {{ $errors->first('position') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="col-md-4 col-lg-3 col-form-label">Image</label>
                                        <input name="image" type="file" class="form-control" id="image" >
                                        @if($errors->has('image' ))
                                            <p class="help-block">
                                                {{ $errors->first('image') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-left col-md-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

</main>

<style>
    .add-new {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>
@endsection
