<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>{{ App\Setting::select('title')->first()->title }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet">

    
	<style> 
        #map { 
            height: 615px; 
            width: 100%; 
        } 
	</style> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('menu')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <?php
                // $tab_requete[] = array();
                // $tab_requete = getRequeteAmount();
                // $requestCanceledAmount[] = array();
                // $requestCanceledAmount = getRequeteCanceledAmount();
                // $requestConfirmedAmount[] = array();
                // $requestConfirmedAmount = getRequeteConfirmedAmount();
                // $requestOnRideAmount[] = array();
                // $requestOnRideAmount = getRequeteOnRideAmount();
                // $requestCompletedAmount[] = array();
                // $requestCompletedAmount = getRequeteCompletedAmount();
                // $requeteAllSaleTodayAmount[] = array();
                // $requeteAllSaleTodayAmount = getRequeteAllSaleTodayAmount();
                // $requeteMonthEarnAmount[] = array();
                // $requeteMonthEarnAmount = getRequeteMonthEarnAmount();
                // $requeteTodayEarnAmount[] = array();
                // $requeteTodayEarnAmount = getRequeteTodayEarnAmount();
                // $requeteWeekEarnAmount[] = array();
                // $requeteWeekEarnAmount = getRequeteWeekEarnAmount();
                // $requeteNewAmount[] = array();
                // $requeteNewAmount = getRequeteNewAmount();
                // $currency[] = array(); 
                // $currency = getEnabledCurrency();
                // $conducteurs[] = array(); 
                // $conducteurs = getConducteur();
                // $userapps[] = array(); 
                // $userapps = getUserApp();
            ?>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <!-- <h3 class="text-themecolor">Ganador: <?php if(count($requestCompletedAmount)>0){echo $currency['symbole'] .' '.$requestCompletedAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3> -->
                    <h2 class="text-themecolor">@lang('custom.dashboard')</h2>
                </div>
                <!-- <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div> -->
                <div>
                    <!-- <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button> -->
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- <h3 class="text-themecolor">Ganador: <?php if(count($requestCompletedAmount)>0){echo $currency['symbole'] .' '.$requestCompletedAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3> -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.revenue') <img class="float-right" src="{{ asset('assets/images/Grupo 1587.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requestCompletedAmount)>0){echo $currency['symbole'] .' '.$requestCompletedAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.today_commission') <img class="float-right" src="{{ asset('assets/images/Grupo 1587 2.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requeteTodayEarnAmount)>0){echo $currency['symbole'] .' '.$requeteTodayEarnAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.commission_of_the_week') <img class="float-right" src="{{ asset('assets/images/Grupo 1590.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requeteWeekEarnAmount)>0){echo $currency['symbole'] .' '.$requeteWeekEarnAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.commission_of_the_month') <img class="float-right" src="{{ asset('assets/images/Grupo 1592.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requeteMonthEarnAmount)>0){echo $currency['symbole'] .' '.$requeteMonthEarnAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.income_on_confirmed_walks') <img class="float-right" src="{{ asset('assets/images/Grupo 1587.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requestConfirmedAmount)>0){echo $currency['symbole'] .' '.$requestConfirmedAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.income_on_completed_walks') <img class="float-right" src="{{ asset('assets/images/Grupo 1587 2.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requestCompletedAmount)>0){echo $currency['symbole'] .' '.$requestCompletedAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.income_on_current_walks') <img class="float-right" src="{{ asset('assets/images/Grupo 1590.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requestOnRideAmount)>0){echo $currency['symbole'] .' '.$requestOnRideAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.revenue_from_canceled_rides') <img class="float-right" src="{{ asset('assets/images/Grupo 1592.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requestCanceledAmount)>0){echo $currency['symbole'] .' '.$requestCanceledAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h5 class="text-muted m-b-0 m-b-20">@lang('custom.today_income') <img class="float-right" src="{{ asset('assets/images/Grupo 1592.png') }}" alt=""></h5>
                                    <h3 class="m-b-0 text-dark m-b-20 font-30"><?php if(count($requeteAllSaleTodayAmount)>0){echo $requeteAllSaleTodayAmount['nb_sales'].' ventas';}else{ echo '0 ventas';}  ?></h3>
                                    <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <!-- <h4 class="text-dark m-b-0 m-b-10">Rides <img class="float-right" src="{{ asset('assets/images/Grupo 1634.png') }}" alt=""></h4> -->
                                    <div class="m-b-20">
                                        <img src="{{ asset('assets/images/Grupo 1532.png') }}" alt=""><span class="m-l-10 text-dark">@lang('custom.driver')</span><span class="float-right m-t-0"><?php echo count($conducteurs) ?></span>
                                    </div>
                                    <div class="m-b-0">
                                        <img src="{{ asset('assets/images/Grupo 1532.png') }}" alt=""><span class="m-l-10 text-dark">@lang('custom.rider')</span><span class="float-right m-t-0"><?php echo count($userapps) ?></span>
                                    </div>
                                    <!-- <p class="font-14 text-muted">Coordinate all the actors involved in taxi services.</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card p-20" style="border-radius:10px;">
                            <h4 class="text-dark m-b-0 m-b-10">@lang('custom.taxi_booking')</h4>
                            <p class="font-14 text-muted">@lang('custom.taxi_booking_msg')</p>
                            <a href="{{ route('requestorders.byStatus', ['new']) }}" class="btn btn-green m-b-15">@lang('custom.new')</a>
                            <a href="{{ route('requestorders.byStatus', ['confirmed']) }}" class="btn btn-green m-b-15">@lang('custom.confirmed')</a>
                            <a href="{{ route('requestorders.byStatus', ['on ride']) }}" class="btn btn-green m-b-15">@lang('custom.on_ride')</a>
                            <a href="{{ route('requestorders.byStatus', ['completed']) }}" class="btn btn-green m-b-15">@lang('custom.completed')</a>
                            <a href="{{ route('requestorders.byStatus', ['canceled']) }}" class="btn btn-green">@lang('custom.canceled_and_rejected')</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h4 class="text-dark m-b-0 m-b-10">@lang('custom.revenue_statistics') <span class="border m-b-0 p-l-10 p-r-10 font-14 dash-custom-text">12.5%</span> <img class="float-right" src="{{ asset('assets/images/movimientos.png') }}" alt=""></h4>
                                    <!-- <p class="font-14 text-muted">Coordinate all the actors involved in taxi services.</p> -->
                                    <input type="hidden" value="{{ route('requestorders.stats.earning') }}" id="stat_url"/>
                                    <div class="row m-b-10 m-t-20">
                                        <div class="col-md-6">
                                            <select name="year" id="year" class="form-control" onchange="getStatDatas(stat_url.value)">
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="month" id="month" class="form-control" onchange="getStatDatas(stat_url.value)">
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <canvas id="earning_stats"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="card" style="border-radius:10px;">
                            <div class="d-flex flex-row p-20">
                                <div class="align-self-center m-l-0" style="width:100%;">
                                    <h4 class="text-dark m-b-0 m-b-10">@lang('custom.ride') <img class="float-right" src="{{ asset('assets/images/Grupo 1634.png') }}" alt=""></h4>
                                    <div class="m-b-15">
                                        <img src="{{ asset('assets/images/Grupo 1635.png') }}" alt=""><span class="m-l-10 text-dark">@lang('custom.new_ride')</span><span class="float-right m-t-10"><?php if(count($requeteNewAmount)>0){echo $currency['symbole'] .' '.$requeteNewAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></span>
                                    </div>
                                    <div class="m-b-15">
                                        <img src="{{ asset('assets/images/Grupo 1636.png') }}" alt=""><span class="m-l-10 text-dark">@lang('custom.confirmed_ride')</span><span class="float-right m-t-10"><?php if(count($requestConfirmedAmount)>0){echo $currency['symbole'] .' '.$requestConfirmedAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></span>
                                    </div>
                                    <div class="m-b-15">
                                        <img src="{{ asset('assets/images/Grupo 1637.png') }}" alt=""><span class="m-l-10 text-dark">@lang('custom.onride_ride')</span><span class="float-right m-t-10"><?php if(count($requestOnRideAmount)>0){echo $currency['symbole'] .' '.$requestOnRideAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></span>
                                    </div>
                                    <div class="m-b-15">
                                        <img src="{{ asset('assets/images/Grupo 1638.png') }}" alt=""><span class="m-l-10 text-dark">@lang('custom.completed_ride')</span><span class="float-right m-t-10"><?php if(count($requestCompletedAmount)>0){echo $currency['symbole'] .' '.$requestCompletedAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></span>
                                    </div>
                                    <div class="m-b-15">
                                        <img src="{{ asset('assets/images/Grupo 1639.png') }}" alt=""><span class="m-l-10 text-dark">@lang('custom.canceled_ride')</span><span class="float-right m-t-10"><?php if(count($requestCanceledAmount)>0){echo $currency['symbole'] .' '.$requestCanceledAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></span>
                                    </div>
                                    <!-- <p class="font-14 text-muted">Coordinate all the actors involved in taxi services.</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">@lang('custom.driver_activation_request')</h4>
                                <p class="font-14 text-muted">@lang('custom.driver_activation_request_msg')</p>
                                <div class="table-responsive m-t-10" style="height:500px;">
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" height="100%;">
                                        <thead class="custom-table-head">
                                            <tr>
                                                <th width="5%">N°</th>
                                                <th width="10%">@lang('custom.photo')</th>
                                                <th width="20%">@lang('custom.firstname')</th>
                                                <th width="20%">@lang('custom.lastname')</th>
                                                <th width="10%">@lang('custom.phone')</th>
                                                <th width="10%">@lang('custom.national_identification_document')</th>
                                                <th width="5%">@lang('custom.status')</th>
                                                <th width="5%">@lang('custom.created')</th>
                                                <th width="5%">@lang('custom.edited')</th>
                                                <th width="10%">@lang('custom.actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0; $i<count($conducteurs); $i++){
                                                    echo'
                                                        <tr style="background:#ffffff;">
                                                            <td>'.($i+1).'</td>
                                                            <td>
                                                                <div class="user-profile" style="width:100%;">
                                                                    <div class="profile-img" style="width:100%;">';
                                                                        if($conducteurs[$i]['photo_path'] == ""){
                                                                            echo '<img src="images/app_user/user_profile.jpeg" alt="" width="100%" style="width:70px;height:70px;">';
                                                                        }else{
                                                                            echo '<img src="images/app_user/'.$conducteurs[$i]['photo_path'].'" alt="" width="100%" style="width:70px;height:70px;">';
                                                                        }
                                                                        
                                                                    echo '</div>
                                                                </div>
                                                            </td>
                                                            <td>'.$conducteurs[$i]['prenom'].'</td>
                                                            <td>'.$conducteurs[$i]['nom'].'</td>
                                                            <td>'.$conducteurs[$i]['phone'].'</td>
                                                            <td>'.$conducteurs[$i]['cnib'].'</td>
                                                            <td><span class="'; if($conducteurs[$i]['statut'] == "yes"){echo "badge badge-success-custom";}else{echo "badge badge-danger";} echo '">'.(($conducteurs[$i]['statut'] == "yes")? 'Activated' : 'Disabled').'</span></td>
                                                            <td>'.$conducteurs[$i]['creer'].'</td>
                                                            <td>'.$conducteurs[$i]['modifier'].'</td>
                                                            <td>'; ?>
                                                                <a href="{{ route('conducteurs.activate', [$conducteurs[$i]['id']]) }}" class="btn btn-info-custom m-r-10"><i class="fa fa-check text-warning"></i></a>
                                                                <form method="POST" action="{{ route('conducteurs.single') }}">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('GET') }}
                                                                    <input type="hidden" id="" name="status" value="0">
                                                                    <input type="hidden" id="" name="conducteur_id" value="{{ $conducteurs[$i]['id'] }}">
                                                                    <button class="btn btn-violet">@lang('custom.details')</button>
                                                                </form>
                                                                <!-- <a href="query/action.php?id_conducteur_activer='.$conducteurs[$i]['id'].'" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Activate"> <i class="fa fa-check"></i> </a>
                                                                <a href="conducteur-detail.php?id_conducteur='.$conducteurs[$i]['id'].'" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="View détails"> <i class="fa fa-ellipsis-h"></i> </a> -->
                                                            <?php echo '</td>
                                                        </tr>
                                                    ';
                                                }
                                            ?>
                                            <!-- <input type="hidden" value="'.$conducteurs[$i]['id'].'" name="" id="id_conducteur_'.$i.'">
                                            <button type="button" onclick="modConducteur(id_conducteur_'.$i.'.value);" class="btn btn-warning btn-sm" data-original-title="Modify" data-toggle="modal" data-target="#conducteur-mod"><i class="fa fa-pencil"></i></button>
                                            <a href="query/action.php?id_conducteur='.$conducteurs[$i]['id'].'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash"></i> </a>
                                            <a href="query/action.php?id_conducteur_desactiver='.$conducteurs[$i]['id'].'" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="Deactivate"> <i class="fa fa-close"></i> </a> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card p-20" style="border-radius:10px;">
                                    <h4 class="text-dark m-b-0 m-b-10">@lang('custom.application_users')</h4>
                                    <p class="font-14 text-muted">@lang('custom.monitoring_of_user_activities')</p>
                                    <a href="{{ route('userapps') }}" class="btn btn-blue m-b-15">@lang('custom.rider')</a>
                                    <a href="{{ route('conducteurs') }}" class="btn btn-blue m-b-15">@lang('custom.driver')</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card p-20" style="border-radius:10px;">
                                    <h4 class="text-dark m-b-0 m-b-10">@lang('custom.administration_tools')</h4>
                                    <p class="font-14 text-muted">@lang('custom.administration_tools_msg')</p>
                                    <a href="{{ route('countries') }}" class="btn btn-violet m-b-15">@lang('custom.country')</a>
                                    <a href="{{ route('currencies') }}" class="btn btn-violet m-b-15">@lang('custom.currency')</a>
                                    <a href="{{ route('commissions') }}" class="btn btn-violet m-b-15">@lang('custom.commission')</a>
                                    <a href="{{ route('paymentmethods') }}" class="btn btn-violet m-b-15">@lang('custom.payment_method')</a>
                                    <a href="{{ route('settings') }}" class="btn btn-violet m-b-15">@lang('custom.settings')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <div class="row m-t-0">
                            <div class="col-md-12">
                                <div class="card p-20" style="border-radius:10px;">
                                    <input type="hidden" value="{{ route('conducteurs.all') }}" id="map_datas_url">
                                    <!-- <h3>Live Tracking</h3>  -->
                                    <div id="map"></div> 
                                    <script> 
                                        // function initMap() { 
                                        //     // var uluru = {lat: 28.501859, lng: 77.410320}; 
                                        //     var map = new google.maps.Map(document.getElementById('map'), { 
                                        //     zoom: 4, 
                                        //     center: uluru 
                                        //     }); 
                                        //     // var marker = new google.maps.Marker({ 
                                        //     // position: uluru, 
                                        //     // map: map 
                                        //     // }); 
                                        // } 
                                    </script> 
                                    <script async defer 
                                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbqviITZc3Y5_bE0BdUWL7YIOyq75O99k&callback=initMap"> 
                                    </script> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php echo count($conducteurs) ?></h3>
                                    <h5 class="text-muted m-b-0">Drivers</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php echo count($userapps) ?></h3>
                                    <h5 class="text-muted m-b-0">Customers </h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php echo $requestAmount[0]['symbole'].' '.$requestAmount[0]['montant'] ?></h3>
                                    <h5 class="text-muted m-b-0">Customers All ride</h5>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requeteNewAmount)>0){echo $currency['symbole'] .' '.$requeteNewAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">New ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestConfirmedAmount)>0){echo $currency['symbole'] .' '.$requestConfirmedAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Confirmed ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestOnRideAmount)>0){echo $currency['symbole'] .' '.$requestOnRideAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">On ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestCompletedAmount)>0){echo $currency['symbole'] .' '.$requestCompletedAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Completed ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestCanceledAmount)>0){echo $currency['symbole'] .' '.$requestCanceledAmount[0]['montant'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Canceled ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                </div>
                <!-- <h4>Earnings</h4> -->
                <div class="row">
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestConfirmedAmount)>0){echo $currency['symbole'] .' '.$requestConfirmedAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Confirmed ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestOnRideAmount)>0){echo $currency['symbole'] .' '.$requestOnRideAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">On ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestCompletedAmount)>0){echo $currency['symbole'] .' '.$requestCompletedAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Completed ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requestCanceledAmount)>0){echo $currency['symbole'] .' '.$requestCanceledAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Canceled ride</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requeteAllSaleTodayAmount)>0){echo $requeteAllSaleTodayAmount['nb_sales'].' ventas';}else{ echo '0 ventas';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Driver today sale</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requeteTodayEarnAmount)>0){echo $currency['symbole'] .' '.$requeteTodayEarnAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Comisión de hoy</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requeteWeekEarnAmount)>0){echo $currency['symbole'] .' '.$requeteWeekEarnAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Comisión de la semana</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info"><?php if(count($requeteMonthEarnAmount)>0){echo $currency['symbole'] .' '.$requeteMonthEarnAmount[0]['earning'];}else{ echo $currency['symbole'] .' 0';}  ?></h3>
                                    <h5 class="text-muted m-b-0">Comisión del mes</h5></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- column -->
                    <!-- <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ganador stats (<?php echo $currency['symbole'] ; ?>)</h4>
                                <div id="chart">
                                    <canvas id="chart2" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-briefcase m-r-5 color-success"></i>Taxi booking</h4>
                                <h6 class="card-subtitle">Coordinate all actors involved in the Taxi services.</h6>
                                <div class="button-group">
                                    <a href="{{ route('requestorders.byStatus', ['new']) }}" class="btn waves-effect waves-light btn-lg btn-success">New</a>
                                    <a href="{{ route('requestorders.byStatus', ['confirmed']) }}" class="btn waves-effect waves-light btn-lg btn-success">Confirmed</a>
                                    <a href="{{ route('requestorders.byStatus', ['on ride']) }}" class="btn waves-effect waves-light btn-lg btn-success">On ride</a>
                                    <a href="{{ route('requestorders.byStatus', ['completed']) }}" class="btn waves-effect waves-light btn-lg btn-success">Completed</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-settings m-r-5 color-info"></i>Administration tools</h4>
                                <h6 class="card-subtitle">User and User Category Management Tool.</h6>
                                <div class="button-group">
                                    <a href="categorie-user.php" class="btn waves-effect waves-light btn-lg btn-info">User category</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-3 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-account m-r-5 color-warning"></i>Customers</h4>
                                <h6 class="card-subtitle">Track the activities of users.</h6>
                                <div class="button-group">
                                    <a href="list-user.php" class="btn waves-effect waves-light btn-lg btn-warning">User List </a>
                                    <a href="conducteur.php" class="btn waves-effect waves-light btn-lg btn-warning">Driver List </a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-3 col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-chart-areaspline m-r-5 color-primary"></i>Reporting &amp; Stats</h4>
                                <h6 class="card-subtitle">Reporting activities using reporting tools.</h6>
                                <div class="button-group">
                                    <a href="" class="btn waves-effect waves-light btn-lg btn-primary">Statistics</a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>
                <!-- Row -->
                
                
                <!-- Row -->
                
                <!-- Row -->
                <!-- Row -->
                
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            @include('footer')
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--morris JavaScript -->
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/plugins/morrisjs/morris.min.js"></script>
    <!-- Chart JS -->
    <script src="js/dashboard1.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->

    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <!-- Chart JS -->
    <script src="assets/plugins/Chart.js/chartjs.init.js"></script>
    <script src="assets/plugins/Chart.js/Chart.min.js"></script>
    <!-- ============================================================== -->

    
    <!--Custom JavaScript -->
    <!-- <script src="js/custom.min.js"></script> -->
    <script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
    <script src="js/toastr.js"></script>
    <!-- This is data table -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        // $('#example24').DataTable();
    </script>
    <!-- Chart JS -->
    <!-- <script src="{{ asset('assets/plugins/Chart.js/chartjs.init.js') }}"></script> -->
    <script src="{{ asset('assets/plugins/Chart.js/chart.min.js') }}"></script>
    <script>
        var mixedChart;
        var ctx = document.getElementById('earning_stats').getContext('2d');
        function setBarChart(dataValues,dataLabels){
            if(mixedChart!=null){
                addData(mixedChart,dataLabels,dataValues);
            }else{
                var datasets = [
                        {
                            type: 'bar',
                            label: 'Ganador',
                            data: dataValues,
                            yAxisID: 'y',
                            backgroundColor: '#57aa82',
                            order: 3
                        },
                ];
                mixedChart = new Chart(ctx, {
                    data: {
                        datasets: datasets,
                        labels: dataLabels
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
        getStatDatas(stat_url.value);
        
        function addData(chart, label, data){
            chart.data.datasets[0].data = data;
            chart.update();
        }

        function getStatDatas(url){
            var idYear = $('#year').val();
            var idMonth = $('#month').val();
            $.ajax({
                url: url,
                type: 'GET',
                data: {'year':idYear, 'month':idMonth},
                success: function (data) {

                    // Chart JS
                    var dataValues = data['dataValues'];
                    var dataLabels = data['dataLabels'];
                    
                    setBarChart(dataValues,dataLabels);
                }
            });
        }
    </script>

    <script>
        initMap();
        var gmarkers = [];
        var map;
        function initMap(){
            // alert($('#map_datas_url').val())
            $.ajax({
                url: $('#map_datas_url').val(),
                type: "GET",
                data: {},
                success: function (data) {
                    if(data.length != 0){
                        data.forEach(function(element,index) {
                            if(element.latitude){
                                var lat = element.latitude;
                                var lng = element.longitude;
                                var prenom = element.prenom;
                                var phone = element.phone;
                                var nom = element.nom;
                                var online = element.online;
                                var nom_prenom = prenom+" "+nom;
                                var uluru = {lat: parseFloat(lat), lng: parseFloat(lng)}; 
                                if(index==0){
                                    map = new google.maps.Map(document.getElementById('map'), { 
                                    zoom: 15,
                                    center: uluru 
                                    }); 
                                }
                                if(online == "yes")
                                    var image = 'http://projets.hevenbf.com/on_demand_taxi/assets/images/marker.png';
                                else
                                    var image = 'http://projets.hevenbf.com/on_demand_taxi/assets/images/marker_red.png';
                                var marker = new google.maps.Marker({ 
                                    position: uluru, 
                                    map: map, 
                                    icon: image, 
                                    title: nom_prenom 
                                }); 
                                showInfo(map,marker,phone);
                                // Push your newly created marker into the array:
                                gmarkers.push(marker);
                            }
                        });
                    }else{
                        var uluru = {lat: parseFloat("11.111111"), lng: "-1.133344"}; 
                        map = new google.maps.Map(document.getElementById('map'), { 
                        zoom: 15,
                        center: uluru 
                        }); 
                    }
                    addYourLocationButton(map, marker);
                }
            });
        }
        function showInfo(map,marker,phone){
            var infoWindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', function () {
                var markerContent = "<h4>Name : "+marker.getTitle()+"</h4> <h6>Phone : "+phone+"</h6>";
                infoWindow.setContent(markerContent);
                infoWindow.open(map, this);
            });
            new google.maps.event.trigger( marker, 'click' );
        }
        function addYourLocationButton(map, marker) {
            var controlDiv = document.createElement('div');

            var firstChild = document.createElement('button');
            firstChild.style.backgroundColor = '#fff';
            firstChild.style.border = 'none';
            firstChild.style.outline = 'none';
            firstChild.style.width = '40px';
            firstChild.style.height = '40px';
            firstChild.style.borderRadius = '2px';
            firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
            firstChild.style.cursor = 'pointer';
            firstChild.style.marginRight = '10px';
            firstChild.style.padding = '0px';
            firstChild.title = 'Your Location';
            controlDiv.appendChild(firstChild);

            var secondChild = document.createElement('div');
            secondChild.style.margin = '10px';
            secondChild.style.width = '18px';
            secondChild.style.height = '18px';
            secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
            secondChild.style.backgroundSize = '180px 18px';
            secondChild.style.backgroundPosition = '0px 0px';
            secondChild.style.backgroundRepeat = 'no-repeat';
            secondChild.id = 'you_location_img';
            firstChild.appendChild(secondChild);

            google.maps.event.addListener(map, 'dragend', function() {
                $('#you_location_img').css('background-position', '0px 0px');
            });

            firstChild.addEventListener('click', function() {
                var imgX = '0';
                var animationInterval = setInterval(function(){
                    if(imgX == '-18') imgX = '0';
                    else imgX = '-18';
                    $('#you_location_img').css('background-position', imgX+'px 0px');
                }, 500);
                if(navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        marker.setPosition(latlng);
                        map.setCenter(latlng);
                        clearInterval(animationInterval);
                        $('#you_location_img').css('background-position', '-144px 0px');
                    });
                }
                else{
                    clearInterval(animationInterval);
                    $('#you_location_img').css('background-position', '0px 0px');
                }
            });

            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
        }
        
        function removeMarkers(){
            for (i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setMap(null);
            }
        }
        function getVehicleAll2(){
            $.ajax({
                url: "query/ajax/getAllVehicle.php",
                type: "POST",
                data: {"id":"ok"},
                success: function (data) {
                    var data_parse = JSON.parse(data);
                    removeMarkers();
                    for(var i=0; i<data_parse.length; i++){
                        var lat = data_parse[i].latitude;
                        var lng = data_parse[i].longitude;
                        var prenom = data_parse[i].prenom;
                        var phone = data_parse[i].phone;
                        var nom = data_parse[i].nom;
                        var online = data_parse[i].online;
                        var nom_prenom = prenom+" "+nom;
                        var uluru = {lat: parseFloat(lat), lng: parseFloat(lng)}; 
                        if(online == "yes")
                            var image = 'http://projets.hevenbf.com/on_demand_taxi/assets/images/marker.png';
                        else
                            var image = 'http://projets.hevenbf.com/on_demand_taxi/assets/images/marker_red.png';
                        var marker = new google.maps.Marker({ 
                            position: uluru, 
                            map: map, 
                            icon: image, 
                            title: nom_prenom 
                        }); 
                        showInfo(map,marker,phone);
                        // Push your newly created marker into the array:
                        gmarkers.push(marker);
                    }
                }
            });
        }
        function foo() {
            var day = new Date().getDay();
            var hours = new Date().getHours();

            // alert('day: ' + day + '  Hours : ' + hours );
            getVehicleAll2();

            if (day === 0 && hours > 12 && hours < 13){}
            // Do what you want here:
        }

        setInterval(foo, 7000);

        apply(new Date().getFullYear());
        function apply(year){
            $("#loader").css("display", "block");
            $.ajax({
                url: "query/ajax/getEarningStatsDashboard.php",
                type: "POST",
                data: {"year":year},
                success: function (data) {
                    $("#chart2").remove();
                    $("#chart").append('<canvas id="chart2" height="50"></canvas>');

                    var data_parse = JSON.parse(data);

                    var ctx2 = document.getElementById("chart2").getContext("2d");
                    var v01 = 0;var v02 = 0;var v03 = 0;var v04 = 0;var v05 = 0;var v06 = 0;var v07 = 0;var v08 = 0;var v09 = 0;var v10 = 0;var v11 = 0;var v12 = 0;
                    for (let i = 0; i < data_parse.length; i++) {
                        date = data_parse[i].creer;
                        tab_tab = date.split('-');
                        var expr = tab_tab[1];
                        var nb = expr;
                        switch(nb){
                            case '01': v01 = parseInt(v01)+parseInt(data_parse[i].montant); break;
                            case '02': v02 = parseInt(v02)+parseInt(data_parse[i].montant); break;
                            case '03': v03 = parseInt(v03)+parseInt(data_parse[i].montant); break;
                            case '04': v04 = parseInt(v04)+parseInt(data_parse[i].montant); break;
                            case '05': v05 = parseInt(v05)+parseInt(data_parse[i].montant); break;
                            case '06': v06 = parseInt(v06)+parseInt(data_parse[i].montant); break;
                            case '07': v07 = parseInt(v07)+parseInt(data_parse[i].montant); break;
                            case '08': v08 = parseInt(v08)+parseInt(data_parse[i].montant); break;
                            case '09': v09 = parseInt(v09)+parseInt(data_parse[i].montant); break;
                            case '10': v10 = parseInt(v10)+parseInt(data_parse[i].montant); break;
                            case '11': v11 = parseInt(v11)+parseInt(data_parse[i].montant); break;
                            default: v12 = parseInt(v12)+parseInt(data_parse[i].montant); break;
                        }
                    }

                    var data_tab = [];
                    for (let i = 0; i < 12; i++) {
                        switch(i){
                            case 0: data_tab[i] = v01; break;
                            case 1: data_tab[i] = v02; break;
                            case 2: data_tab[i] = v03; break;
                            case 3: data_tab[i] = v04; break;
                            case 4: data_tab[i] = v05; break;
                            case 5: data_tab[i] = v06; break;
                            case 6: data_tab[i] = v07; break;
                            case 7: data_tab[i] = v08; break;
                            case 8: data_tab[i] = v09; break;
                            case 9: data_tab[i] = v10; break;
                            case 10: data_tab[i] = v11; break;
                            case 11: data_tab[i] = v12; break;
                            case 12: data_tab[i] = v13; break;
                            default: data_tab[i] = '0'; break;
                        }
                    }
                    var data2 = {
                        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        datasets: [
                            {
                                label: "Ganador stats",
                                fillColor: "#ffb22b",
                                strokeColor: "#ffb22b",
                                highlightFill: "#eba327",
                                highlightStroke: "#eba327",
                                data: data_tab
                            }
                        ]
                    };
                    
                    var chart2 = new Chart(ctx2).Bar(data2, {
                        scaleBeginAtZero : true,
                        scaleShowGridLines : true,
                        scaleGridLineColor : "rgba(0,0,0,.005)",
                        scaleGridLineWidth : 0,
                        scaleShowHorizontalLines: true,
                        scaleShowVerticalLines: true,
                        barShowStroke : true,
                        barStrokeWidth : 0,
                        tooltipCornerRadius: 2,
                        barDatasetSpacing : 3,
                        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                        responsive: true
                    });
                }
            });
        }
    </script>
    <!-- Custom Theme JavaScript -->

    @if(session('status') != null && session('status') == "successfuly")
        <script>
            showSuccess($('#response_msg').val());
        </script>
        {{ session()->forget('status') }}
    @elseif(session('status') != null && session('status') == "failed")
        <script>
            showFailed($('#response_msg').val());
        </script>
        {{ session()->forget('status') }}
    @elseif(session('status') != null && session('status') == "error")
        <script>
            showWarningIncorrect($('#response_msg').val());
        </script>
        {{ session()->forget('status') }}
    @endif
</body>

</html>