<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> 
                <!-- <img src="{{ asset('assets/images/users/profile.png') }}" alt="user" /> -->
                <!-- this is blinking heartbit-->
                <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
            </div>
            <!-- User profile text-->
            <div class="profile-text">
                <h5>{{Auth::user()->nom}} {{Auth::user()->prenom}}</h5>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="" data-toggle="tooltip" title="Deconnexion"><i class="mdi mdi-power"></i></a>
                <div class="dropdown-menu animated flipInY">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item"><i class="fa fa-power-off"></i>Deconnexion</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!-- text-->
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-small-cap">@lang('custom.monitoring_the_mobile')</li>
                <li> <a class="waves-effect waves-dark" href="{{ route('index') }}">
                        <!-- <i class="mdi mdi-home"></i> -->
                        <img src="{{ asset('assets/images/Category 1.png') }}" alt="" class="m-r-10">
                        <span class="hide-menu">@lang('custom.dashboard')</span>
                    </a>
                    <!-- <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('index') }}">Salpicadero</a></li>
                    </ul> -->
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <!-- <i class="mdi mdi-account-multiple"></i> -->
                        <img src="{{ asset('assets/images/Grupo 1532.png') }}" alt="" class="m-r-10">
                        <span class="hide-menu">@lang('custom.application_users')</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('userapps') }}">@lang('custom.rider')</a></li>
                        <li><a href="{{ route('conducteurs') }}">@lang('custom.driver')</a></li>
                        <li><a href="{{ route('notifications') }}">@lang('custom.notification')</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <img src="{{ asset('assets/images/Graph 1.png') }}" alt="" class="m-r-10">
                        <span class="hide-menu">@lang('custom.statistics')</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <!-- <li><a href="{{ route('statisticuserapps') }}">Cliente</a></li>
                        <li><a href="{{ route('statisticconducteurs') }}">Driver</a></li> -->
                        <li><a href="{{ route('statisticearnings') }}">@lang('custom.revenue')</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <img src="{{ asset('assets/images/Grupo 1603.png') }}" alt="" class="m-r-10">
                    <span class="hide-menu">@lang('custom.codification')</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('vehicletypes') }}">@lang('custom.vehicle_type')</a></li>
                        <!-- <li><a href="">User category</a></li> -->
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <!-- <i class="mdi mdi-pen"></i> -->
                    <img src="{{ asset('assets/images/Grupo 1598.png') }}" alt="" class="m-r-10">
                    <span class="hide-menu">@lang('custom.taxi_booking')</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('requestorders') }}">@lang('custom.all')</a></li>
                        <li><a href="{{ route('requestorders.byStatus', ['new']) }}">@lang('custom.new_ride')</a></li>
                        <li><a href="{{ route('requestorders.byStatus', ['confirmed']) }}">@lang('custom.confirmed_ride')</a></li>
                        <li><a href="{{ route('requestorders.byStatus', ['on ride']) }}">@lang('custom.onride_ride')</a></li>
                        <li><a href="{{ route('requestorders.byStatus', ['completed']) }}">@lang('custom.completed_ride')</a></li>
                        <li><a href="{{ route('requestorders.byStatus', ['canceled']) }}">@lang('custom.canceled_and_rejected')</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <!-- <i class="mdi mdi-pen"></i> -->
                    <img src="{{ asset('assets/images/Grupo 1600.png') }}" alt="" class="m-r-10">
                    <span class="hide-menu">@lang('custom.rent_a_car')</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('vehicletyperentals') }}">@lang('custom.vehicle_type')</a></li>
                        <li><a href="{{ route('vehiclerentals') }}">@lang('custom.vehicle')</a></li>
                        <li><a href="{{ route('vehiclerents') }}">@lang('custom.rent_vehicle')</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <!-- <i class="mdi mdi-settings"></i> -->
                    <img src="{{ asset('assets/images/Grupo 1602.png') }}" alt="" class="m-r-10">
                    <span class="hide-menu">@lang('custom.administration_tools')</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('countries') }}">@lang('custom.country')</a></li>
                        <li><a href="{{ route('currencies') }}">@lang('custom.currency')</a></li>
                        <li><a href="{{ route('commissions') }}">@lang('custom.commission')</a></li>
                        <li><a href="{{ route('paymentmethods') }}">@lang('custom.payment_method')</a></li>
                        <li><a href="{{ route('settings') }}">@lang('custom.settings')</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>