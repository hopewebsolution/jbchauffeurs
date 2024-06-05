<div class="rightholder">
    @include('Admin.masters.locationForm',['formType'=>'sidebarForm'])   
    @if(!Auth::guard('web')->check())
    <!-- <div class="serviceslist1">
        <div class="tabholder1">Already Registered?</div>
        <div class="cnt"><a href="{{route('user.loginForm')}}">Login or Sign up</a></div>
    </div>
    @endif
    @if($sTextBlocks)
        @foreach($sTextBlocks as $stextBlock) 
            <div class="serviceslist1">
                <div class="tabholder1">{{$stextBlock->title}}</div>
                <div class="cnt">
                   {!!$stextBlock->descriptions!!}
                </div>
            </div>
        @endforeach
    @endif
    @if($sAppBlocks)
        @foreach($sAppBlocks as $sappBlock)
            <div style="margin-bottom:25px;">
                <a href="{{$sappBlock->link}}" target="_blank"><img src="{{$sappBlock->image}}" alt="" width="100%" /></a>
            </div>
        @endforeach
    @endif -->
</div>
<div class="clear"></div>

