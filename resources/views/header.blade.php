<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand m-t-30" href="index.html">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{ asset('assets/images/logo.png') }}" alt="homepage" class="dark-logo" width="70%"/>
                    <!-- Light Logo icon -->
                    <img src="{{ asset('assets/images/logo.png') }}" alt="homepage" class="light-logo" width="70%"/>
                </b>
        </div>
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0" style="margin-left:-50px;">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu text-dark"></i></a> </li>
                <li class="nav-item m-l-0"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu text-dark"></i></a> </li>
                
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- <select name="" id="" class="nav-item form-control m-t-10 text-dark font-14 m-r-30">
                    <option value="fr">English (US)</option>
                    <option value="en">Français (FR)</option>
                </select> -->
                <!-- <li class="nav-item dropdown">
                    @if(strtolower(App::getLocale()) == 'en')
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="flag-icon flag-icon-us"></i>
                        </a>
                    @else
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="flag-icon flag-icon-fr"></i>
                        </a>
                    @endif
                    <input type="hidden" id="lang_change_url" name="" value="{{ route('lang.change') }}">
                    <div class="dropdown-menu dropdown-menu-right scale-up"> 
                        <input type="hidden" id="lang_1" name="" value="EN">
                        <a class="dropdown-item" onclick="setLang(lang_change_url.value,lang_1.value)">
                            <i class="flag-icon flag-icon-us"></i> EN
                        </a>
                        <input type="hidden" id="lang_2" name="" value="FR">
                        <a class="dropdown-item" onclick="setLang(lang_change_url.value,lang_2.value)">
                            <i class="flag-icon flag-icon-fr"></i> FR
                        </a>
                    </div>
                </li> -->
                <li class="nav-item dropdown">
                    @foreach(App\Langue::getLangue() as $key => $lang)
                        @if(strtolower(App::getLocale()) == strtolower($lang->abreviation))
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="{{ $lang->icon }}"></i>
                            </a>
                        @endif
                    @endforeach
                    <input type="hidden" id="lang_change_url" name="" value="{{ route('lang.change') }}">
                    <div class="dropdown-menu dropdown-menu-right scale-up" style="overflow-x:scroll;height:500px;flex-shrink:0;"> 
                        @foreach(App\Langue::getLangue() as $key => $lang)
                        <input type="hidden" id="lang_{{ $key }}" name="" value="{{ $lang->abreviation }}">
                        <a class="dropdown-item" onclick="setLang(lang_change_url.value,lang_{{ $key }}.value)" style="cursor:pointer;">
                            <i class="{{ $lang->icon }}"></i> {{ $lang->abreviation }}
                        </a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('assets/images/Grupo 1525.png') }}" alt="">
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('assets/images/Grupo 1526.png') }}" alt="">
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('assets/images/Setting 1.png') }}" alt="">
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                </li>
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/users/12.jpg') }}" alt="user" class="profile-pic" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ asset('assets/images/users/12.jpg') }}" alt="user"></div>
                                    <div class="u-text">
                                        <h4>{{Auth::user()->nom}} {{Auth::user()->nom_prenom}}</h4>
                                        <!-- <p class="text-muted">{{Auth::user()->email}}</p> -->
                                        <p class="text-muted">Admin</p>
                                        <!-- <a href="pages-profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a> -->
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a class="font-14 text-dark" href="{{ route('users.chgpwd') }}"><i class="ti-user m-r-5 text-dark"></i>@lang('custom.change_password')</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a class="font-14 text-dark" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off m-r-5 text-dark"></i>@lang('custom.logout')</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script>
    function setLang(url,lang){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: url,
            data: {'locale': lang},
            success: function (data) {
                setTimeout(
                    function(){
                        location.reload();
                    }, 1000
                );
            }
        });
    }
</script>