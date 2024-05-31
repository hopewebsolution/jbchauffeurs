 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="{{route('operator.dashboard')}}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>

    </a>
  </li>
  <!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('booking')}}">
      <i class="bi bi-layout-text-window-reverse"></i><span>Booking</span></i>
    </a>
  </li><!-- End Tables Nav -->


  @if(Auth::guard('weboperator')->check())
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('profile.edit')}}">
      <i class="bi bi-person"></i><span>Profile</span></i>
    </a>
  </li>
  
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Sign Out</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
@else
    
@endif

  <!-- End Profile Nav -->
 
  <!-- End Login Page Nav -->
</ul>

</aside><!-- End Sidebar-->

