<div class="row">
    <div class="col-md-12">
    </div>
    @include('masters.'.$formType)
    <div class="clearfix"></div>
</div>
<div class="clear"></div>

@push('footer-scripts')
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ config('services.google_map_key') }}&libraries=places,geometry"></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.4/jquery.geocomplete.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script>
    $(document).ready(function () {
        $("input").tooltip();
    });
    
    /*(function($,W,D){
        var JQUERY4U = {};
        JQUERY4U.UTIL = {       
            setupFormValidation: function() {
                $("#frm1").validate({
                    rules: {
                        'stops[]' : {
                            required: true,
                        },                                 
                    },
                    submitHandler: function(form) {
                        //form.submit();
                    }
                });
            }
        }
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });
    })(jQuery, window, document);*/ 

    $(function () {
        $("#frm1").validate(); 
        var wrapper         = $("#additional-stops-form");
        var add_button      = $(".btn-plus"); 
        var index=1;
        $(add_button).click(function(e){ 
            e.preventDefault();
            var data_type=$(this).attr('data-type');
            var classname="";
            if(data_type=="sidebar"){
                classname="getmore";
            }
            $(wrapper).append('<div class="getgap inner-addon left-addon"><input data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter your loacation" type="text" class="customw form-control inputst1 red-tooltip required '+classname+'" name="stops['+index+']" id="stop_' + index +'" placeholder="Additional Stop - Airport/Hotel/Address/Cruise Port" required> <a href="#" class="btn btn-minus remove_field">-</a></div></div>');
            google.maps.event.addDomListener(window, 'load', locationInputInit(index)); 
            $("input").tooltip();
            index++;
                      
        }); 

        $(wrapper).on("click",".remove_field", function(e){
            e.preventDefault(); 
            $(this).parent().remove(); 
        });
    });
    function locationInputInit(index){
        console.log(index);
        var input = document.getElementById('stop_'+index);
        var autocomplete = new google.maps.places.Autocomplete(input);
    }

    var placeSearch, autocomplete;
    var componentForm = {
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: "aus"}
        };

        autocomplete = new google.maps.places.Autocomplete((document.getElementById('start')),options);
        autocomplete = new google.maps.places.Autocomplete((document.getElementById('end')),options);
        @php 
        for ($j=2; $j<=11; $j++){ @endphp
        autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('stop_<?php echo $j; ?>')),options);

        <?php }  ?>
    }

    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }

    function initialize() {
        var input = document.getElementById('start');
        var autocomplete = new google.maps.places.Autocomplete(input);
        var input = document.getElementById('end');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
@endpush

<style>
    .getmore {
        float: left;
        width: auto;
        min-width: 243px;
    }
    .getQuoteBtn{
        height: 40px;
        background: #edc20b;
        border-radius: 5px !important;
        font-size: 18px;
        color: #FFFFFF;
        text-align: center;
        line-height: 32px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        width: 100%;
    }
    .p0{
        padding: 0px;
    }
    .inner-addon {
        margin-bottom: 8px;
    }
    .bootstrap-datetimepicker-widget {
    top: 0;
    left: 0;
    width: 250px;
    padding: 4px;
    margin-top: 1px;
    z-index: 99999;
    border-radius: 4px;
    }
    /* RQI: Arrow for Bottom */
    .bootstrap-datetimepicker-widget.bottom:before {
    content:'';
    display: inline-block;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-bottom: 7px solid #ccc;
    border-bottom-color: rgba(0, 0, 0, 0.2);
    position: absolute;
    top: -7px;
    left: 7px;
    }
    .bootstrap-datetimepicker-widget.bottom:after {
    content:'';
    display: inline-block;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid white;
    position: absolute;
    top: -6px;
    left: 8px;
    }
    /* RQI: Arrow for Top */
    .bootstrap-datetimepicker-widget.top:before {
    content:'';
    display: inline-block;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-top: 7px solid #ccc;
    border-top-color: rgba(0, 0, 0, 0.2);
    position: absolute;
    bottom: -7px;
    left: 6px;
    }
    .bootstrap-datetimepicker-widget.top:after {
    content:'';
    display: inline-block;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid white;
    position: absolute;
    bottom: -6px;
    left: 7px;
    }
    /* Days Column Width */
    .bootstrap-datetimepicker-widget .dow {
    width: 14.2857%;
    }
    .bootstrap-datetimepicker-widget.pull-right:before {
    left: auto;
    right: 6px;
    }
    .bootstrap-datetimepicker-widget.pull-right:after {
    left: auto;
    right: 7px;
    }
    .bootstrap-datetimepicker-widget > ul {
    list-style-type: none;
    margin: 0;
    }
    .bootstrap-datetimepicker-widget .timepicker-hour, .bootstrap-datetimepicker-widget .timepicker-minute, .bootstrap-datetimepicker-widget .timepicker-second {
    width: 100%;
    font-size: 20px;
    }
    .bootstrap-datetimepicker-widget table[data-hour-format="12"] .separator {
    width: 4px;
    padding: 0;
    margin: 0;
    }
    .bootstrap-datetimepicker-widget .datepicker > div {
    display: none;
    }
    .bootstrap-datetimepicker-widget .picker-switch {
    text-align: center;
    }
    .bootstrap-datetimepicker-widget table {
    width: 100%;
    margin: 0;
    }
    .bootstrap-datetimepicker-widget td, .bootstrap-datetimepicker-widget th {
    text-align: center;
    border-radius: 4px;
    }
    .bootstrap-datetimepicker-widget td.day:hover, .bootstrap-datetimepicker-widget td.hour:hover, .bootstrap-datetimepicker-widget td.minute:hover, .bootstrap-datetimepicker-widget td.second:hover {
    background: #eeeeee;
    cursor: pointer;
    }
    .bootstrap-datetimepicker-widget td.old, .bootstrap-datetimepicker-widget td.new {
    color: #c7c7c7;
    }
    /* Today */
    .bootstrap-datetimepicker-widget td.today {
    position: relative;
    }
    .bootstrap-datetimepicker-widget td.today:before {
    content:'';
    display: inline-block;
    border-left: 7px solid transparent;
    border-bottom: 7px solid #389b98;
    border-top-color: rgba(0, 0, 0, 0.2);
    position: absolute;
    bottom: 4px;
    right: 4px;
    }
    .bootstrap-datetimepicker-widget td.active.today:before {
    border-bottom-color: #fff;
    }
    .bootstrap-datetimepicker-widget td.active, .bootstrap-datetimepicker-widget td.active:hover {
    background-color: #389b98;
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .bootstrap-datetimepicker-widget td.disabled, .bootstrap-datetimepicker-widget td.disabled:hover {
    background: none;
    color: #999999;
    cursor: not-allowed;
    }
    .bootstrap-datetimepicker-widget td span {
    display: block;
    width: 47px;
    float: left;
    margin: 2px;
    cursor: pointer;
    border-radius: 4px;
    padding: 5px 0 5px 0;
    }
    .bootstrap-datetimepicker-widget td span:hover {
    background: #eeeeee;
    }
    .bootstrap-datetimepicker-widget td span.active {
    background-color: #428bca;
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .bootstrap-datetimepicker-widget td span.old {
    color: #999999;
    }
    .bootstrap-datetimepicker-widget td span.disabled, .bootstrap-datetimepicker-widget td span.disabled:hover {
    background: none;
    color: #999999;
    cursor: not-allowed;
    }
    .bootstrap-datetimepicker-widget th.switch {
    width: 145px;
    }
    .bootstrap-datetimepicker-widget th.next, .bootstrap-datetimepicker-widget th.prev {
    font-size: 21px;
    }
    .bootstrap-datetimepicker-widget th.disabled, .bootstrap-datetimepicker-widget th.disabled:hover {
    background: none;
    color: #999999;
    cursor: not-allowed;
    }
    .bootstrap-datetimepicker-widget thead tr:first-child th {
    cursor: pointer;
    }
    .bootstrap-datetimepicker-widget thead tr:first-child th:hover {
    background: #eeeeee;
    }
    .input-group.date .input-group-addon span {
    display: block;
    cursor: pointer;
    width: 16px;
    height: 16px;
    }
    .bootstrap-datetimepicker-widget.left-oriented:before {
    left: auto;
    right: 6px;
    }
    .bootstrap-datetimepicker-widget.left-oriented:after {
    left: auto;
    right: 7px;
    }
    .bootstrap-datetimepicker-widget ul.list-unstyled li.in div.timepicker div.timepicker-picker table.table-condensed tbody > tr > td {
    padding: 0;
    }
    /* Customized Button */
    .btn-time, .btn-time:focus {
    color: #389b98;
    text-decoration: none;
    background-color: transparent;
    }
    .btn-time i {
    padding: 0 7px 0 7px;
    }
    .btn-time:hover {
    color: #12615F;
    text-decoration: none;
    background-color: #eee;
    }

    .left-addon i {
    left: 0px;
    }


    .left-addon input {
    padding-left: 30px;
    font-size: 14px;
    padding-top: 6px;

    height: 46px;
    /* border: 1px solid #ddd !important; */
    }



    .form-border {
    border-bottom: none !important;

    }

    .row.row-flex-mobile {
    margin-top: 12px;
    margin-left: -9px;
    }
    #banform .submit {
    font-size: 18px;
    }
    .control-label{float:left;}

</style>
