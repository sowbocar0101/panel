
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
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>{{ App\Setting::select('title')->first()->title }}</title>
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{ asset('assets/plugins/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <!--alerts CSS -->
    <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <!-- toast CSS -->
    <link href="{{ asset('assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
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
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">@lang('custom.rent')</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">@lang('custom.home')</a></li>
                        <li class="breadcrumb-item">@lang('custom.rent_a_car')</li>
                        <li class="breadcrumb-item active">@lang('custom.rent')</li>
                    </ol>
                </div>
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
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">@lang('custom.vehicle_rent_list')</h4>
                                <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                                <!-- <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#add-vehicule"><i class="fa fa-plus m-r-10"></i>@lang('custom.add')</button> -->
                                <div id="add-vehicule" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-gris">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Añadir vehículo</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form class="form-horizontal m-t-0" method="POST" action="{{ route('vehiclerentals.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Tipo de vehiculo</label>
                                                                    <select id=""vehicle_type class="form-control " placeholder="" name="vehicle_type" required>
                                                                        @foreach($vehicletypes as $vehicletype)
                                                                            <option value="{{ $vehicletype->id }}">{{ $vehicletype->libelle }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Precio del alquiler</label>
                                                                    <input type="number" class="form-control " placeholder="" name="prix" required> 
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Número de plazas</label>
                                                                    <input type="number" class="form-control " placeholder="" name="nb_place" id="nb_place" required> 
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Número de vehículo</label>
                                                                    <input type="number" class="form-control " placeholder="" name="nombre" id="nombre" required> 
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Estado</label>
                                                                    <select id=""vehicle_type class="form-control " placeholder="" name="statut" required>
                                                                        <option value="yes" selected>@lang('custom.yes')</option>
                                                                        <option value="no">@lang('custom.no')</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark waves-effect">@lang('custom.save')</button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('custom.cancel')</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="vehicule-mod" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-gris">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Editar vehículo</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form class="form-horizontal m-t-0" id="formEditVehicle" method="POST" action="@if(session('vehicle_type__url') != null) {{ session('vehicle_type__url') }} {{ session()->forget('vehicle_type__url') }} @endif" enctype="multipart/form-data">
                                                @csrf
                                                {{ method_field('PUT') }}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Tipo de vehiculo</label>
                                                                    <select id="vehicle_type_mod" class="form-control " placeholder="" name="vehicle_type_mod" required>
                                                                        @foreach($vehicletypes as $vehicletype)
                                                                            <option value="{{ $vehicletype->id }}">{{ $vehicletype->libelle }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Precio del alquiler</label>
                                                                    <input type="number" class="form-control " placeholder="" name="prix_mod" id="prix_mod" required> 
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Número de plazas</label>
                                                                    <input type="number" class="form-control " placeholder="" name="nb_place_mod" id="nb_place_mod" required> 
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Número de vehículo</label>
                                                                    <input type="number" class="form-control " placeholder="" name="nombre_mod" id="nombre_mod" required> 
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation">Estado</label>
                                                                    <select id="statut_mod" class="form-control " placeholder="" name="statut_mod" required>
                                                                        <option value="yes" selected>@lang('custom.yes')</option>
                                                                        <option value="no">@lang('custom.no')</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Error message
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark waves-effect">@lang('custom.save')</button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('custom.cancel')</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="table-responsive m-t-10">
                                    <table id="example1" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead class="custom-table-head">
                                            <tr>
                                                <th>N°</th>
                                                <th>@lang('custom.vehicle')</th>
                                                <th>@lang('custom.customer')</th>
                                                <th>@lang('custom.number_of_days')</th>
                                                <th>@lang('custom.start_date')</th>
                                                <th>@lang('custom.end_date')</th>
                                                <th>@lang('custom.contact')</th>
                                                <th>@lang('custom.status')</th>
                                                <!-- <th>@lang('custom.actions')</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vehicles as $key => $vehicle)
                                                <tr style="background:#ffffff;">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $vehicle->vehicletype }}</td>
                                                    <!-- <td width="10%"><img width="100%" src="{{ $vehicle->image }}" alt=""></td> -->
                                                    <td>{{ $vehicle->customer }}</td>
                                                    <td>{{ $vehicle->nb_jour }}</td>
                                                    <td>{{ $vehicle->date_debut }}</td>
                                                    <td>{{ $vehicle->date_fin }}</td>
                                                    <td>{{ $vehicle->contact }}</td>
                                                    <td>
                                                        @if($vehicle->statut == 'yes')
                                                        <label for="" class="label label-success">@lang('custom.yes')</label>
                                                        @else
                                                        <label for="" class="label label-danger">@lang('custom.no')</label>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
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
                </div>
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
    <!-- ============================================================== -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--morris JavaScript -->
    <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/plugins/morrisjs/morris.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('js/dashboard1.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>

    <!-- This is data table -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
    <!-- end - This is for export functionality only -->
    <!-- Sweet-Alert  -->
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/wizard/steps.js') }}"></script>
    <script src="{{ asset('assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <!-- Sweet-Alert  -->
    <script>
        $('#example0').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example1').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example2').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example3').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example4').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example5').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example6').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example7').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example8').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example9').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example10').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#example11').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            lengthMenu: [ 10, 25, 50 ],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
    <script>
        //Warning Message
        function showDelAlert(id,msg,yes,no,conf){
            // alert(id)
            swal({   
                title: conf,   
                text: msg+' ?',   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: yes, 
                cancelButtonText: no,
                closeOnConfirm: false 
            }, function(){   
                // showModal();
                $('#'+id).click();
                swal.close();
            });
        };
        
        function editVehicle(url){
            // alert(url)
            // showModal();
            $.ajax({
                url: url,
                type: 'GET',
                data: {'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    $("#prix_mod").empty();
                    $("#nb_place_mod").empty();
                    $("#nombre_mod").empty();

                    var resultData = data.data;

                    $("#formEditVehicle").attr("action", url);
                    $("#prix_mod").val(resultData.prix);
                    $("#nb_place_mod").val(resultData.nb_place);
                    $("#nombre_mod").val(resultData.nombre);
                    $("#statut_mod").val(resultData.statut).change();
                    $("#vehicle_type_mod").val(resultData.id_type_vehicule_rental).change();

                    $('#vehicule-mod').modal();
                }
            });
        }
    </script>

    
    <!--Custom JavaScript -->
    <!-- <script src="js/custom.min.js"></script> -->
    <script src="{{ asset('assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src="js/toastr.js"></script>
    <!-- Custom Theme JavaScript -->
    <input type="hidden" name="response_msg" id="response_msg" value="{{ session('msg') }}">
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
