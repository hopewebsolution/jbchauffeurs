
<style>
    /* new Ashok CSS */
.inner-addon{
    display: flex;
    gap:3px;
}
.inner-addon .btn-plus{
    background: #edc20b;
    color: #fff;
    padding: 10px 12px;
    margin: 0;
}
.form-border .form-control {
   
    border-radius: 5px;
}
.getQuoteBtn {
    height: 46px !important;
       border: 0;
}

</style>
<div class="col-md-12">
    <div id="banform">
        <h2 class="bannerTitle" style="">Instant Quote & Online Booking</h2>
        <div id="bannerform" class="formblock">
            <div id="distance" style="display: none"></div>
            {!! Form::open(['route' =>['admin.getVehicles'],'class'=>'listVehicles','id'=>'frm1','name'=>'frm1']) !!}
                <div class="form-border">
                    <div class="row">
                        <div class="col-lg-5  col-md-5 pickup_box">
                            <div class="inner-addon left-addon">
                                <!-- <i class="fa fa-map-marker" aria-hidden="true"></i> -->
                                <!-- <input data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter your loacation" type="text" name="start" id="start" class="form-control inputst1 red-tooltip required" placeholder="Pickup - Airport/Hotel/Address/Cruise Port"/> -->
                                {!! Form::text('start','',['data-toggle'=>"tooltip",'data-placement'=>"top", 'title'=>"",'data-original-title'=>"Enter your loacation",'id'=>"start", 'class'=>"form-control inputst1 red-tooltip required",'placeholder'=>"Pickup - Airport/Hotel/Address/Cruise Port"]) !!}
                            </div>
                        </div>
                   
                        <div class="col-lg-5  col-md-5">
                            <div class="inner-addon left-addon">
                                <!-- <i class="fa fa-flag" aria-hidden="true"></i> -->
                                <!-- <input data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter your loacation" type="text" name="end" id="end" class="customw form-control inputst1 red-tooltip required" placeholder="Drop Off - Airport/Hotel/Address/Cruise Port " /> -->
                                {!! Form::text('end','',['data-toggle'=>"tooltip",'data-placement'=>"top", 'title'=>"",'data-original-title'=>"Enter your loacation",'id'=>"end", 'class'=>"customw form-control inputst1 red-tooltip required",'placeholder'=>"Drop Off - Airport/Hotel/Address/Cruise Port"]) !!}
                                <!-- <a class="btn btn-plus" data-type="home">+</a> -->
                            </div>
                            <div id="additional-stops-form">
                                
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 ">
                            <input type="submit" class="getQuoteBtn" value="Get Quote" />
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            @if ($errors->any())
                <div class="alert alert-danger" style="font-size: 15px;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach   
                </div>
            @endif
        </div>

    </div>
</div>