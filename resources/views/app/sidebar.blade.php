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
        @if(Auth::guard('weboperator')->check())

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('newbooking')}}">
            <i class="bi bi-layout-text-window-reverse"></i><span>New Booking</span></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('booking')}}">
            <i class="bi bi-layout-text-window-reverse"></i><span>Booking</span></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('profile.edit')}}">
            <i class="bi bi-person"></i><span>Profile</span></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('operator.fares')}}">
            <i class="bi bi-cash-coin"></i><span>Fares</span></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('operator.vehicles')}}">
            <i class="bi bi-car-front"></i><span>Vehicles</span></i>
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
        @endif
    </ul>

</aside><!-- End Sidebar-->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('#sidebar-nav .nav-link');
    function setActiveClass(link) {
      navLinks.forEach(nav => nav.classList.remove('active'));
      link.classList.add('active');
    }
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        setActiveClass(this);
      });
      if (window.location.href === link.href) {
        setActiveClass(link);
      }
    });
  });
</script>
