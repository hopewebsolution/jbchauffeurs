<div class="innerPagesection col-md-12">
    <div id="banform">
        <div class="formblock">
            <h2 class="bannerTitle" style="">Instant Quote & Online Booking</h2>
                {!! Form::open(['route' =>['admin.getVehicles'],'class'=>'listVehicles','id'=>'frm1','name'=>'frm1']) !!} 
                    <div class="form-border">
                        <div class="row">
                            <div class="col-lg-12  col-md-12" style="padding-left: 0px;">
                                <!-- <i class="fa fa-map-marker" aria-hidden="true"></i> -->
                                <input data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter your loacation" type="text" name="start" id="start" class="form-control inputst1 red-tooltip required" placeholder="Pickup - Airport/Hotel/Address/Cruise Port"/>
                            </div>
                       
                            <div class="col-lg-12  col-md-12" style="padding-left: 0px;">
                                <input data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter your loacation" type="text" name="end" id="end" class="form-control getmore inputst1 red-tooltip required pac-target-input" placeholder="Drop Off - Airport/Hotel/Address/Cruise Port " />
                                <a class="btn btn-plus" data-type="sidebar">+</a>
                                
                                <div id="additional-stops-form">
                                    
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 ">
                                <input type="submit" class="getQuoteBtn" value="Get Quote" />
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
<style type="text/css">
    .btn-plus, .btn-minus {
        margin-top: 5px;
    }
    .getQuoteBtn{
        margin-top: 20px; 
    }
</style>