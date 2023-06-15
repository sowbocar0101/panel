
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
                    <h3 class="text-themecolor">@lang('custom.rider')</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">@lang('custom.home')</a></li>
                        <li class="breadcrumb-item">@lang('custom.application_users')</li>
                        <li class="breadcrumb-item active">@lang('custom.rider')</li>
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
                                <h4 class="card-title">@lang('custom.client_list')</h4>
                                <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                                <!-- <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#add-vehicule"><i class="fa fa-plus m-r-10"></i>@lang('custom.add')</button> -->
                                
                                <div class="table-responsive m-t-10">
                                    <table id="example1" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead class="custom-table-head">
                                            <tr>
                                                <th>N°</th>
                                                <th>@lang('custom.photo')</th>
                                                <th>@lang('custom.full_name')</th>
                                                <th>@lang('custom.email')</th>
                                                <th>@lang('custom.phone')</th>
                                                <th>@lang('custom.status')</th>
                                                <th>@lang('custom.actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customers as $key => $customer)
                                                <tr style="background:#ffffff;">
                                                    <td>{{ $key+1 }}</td>
                                                    <td width="10%"><img width="100%" src="@if(strlen($customer->photo_path)>0) {{ $customer->photo_path }} @else images/app_user/user_profile.jpeg @endif" alt=""></td>
                                                    <td>{{ $customer->nom }} {{ $customer->prenom }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->phone }}</td>
                                                    <td>
                                                        @if($customer->statut == 'yes')
                                                        <label for="" class="label label-success">@lang('custom.yes')</label>
                                                        @else
                                                        <label for="" class="label label-danger">@lang('custom.no')</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                @lang('custom.actions')
                                                            </button>
                                                            <div class="dropdown-menu animated flipInX">
                                                                <!-- <button class="dropdown-item font-12" onclick="editCustomer(edit_customer_type_{{ $customer->id }}.value)">@lang('custom.edit')</button> -->
                                                                <input type="hidden" id="customer_type_del_msg_{{ $customer->id }}" value="@lang('custom.are_you_sure_you_want_to_delete_it') " />
                                                                <input type="hidden" id="customer_type_del_yes_{{ $customer->id }}" value="@lang('custom.yes')" />
                                                                <input type="hidden" id="customer_type_del_no_{{ $customer->id }}" value="@lang('custom.no')" />
                                                                <input type="hidden" id="customer_type_del_object_{{ $customer->id }}" value="@lang('custom.this_line')" />
                                                                <input type="hidden" id="customer_type_del_conf_{{ $customer->id }}" value="@lang('custom.confirmation')" />
                                                                <button class="dropdown-item font-12" onclick="showDelAlert(delete_customer_type_{{ $customer->id }}.id,customer_type_del_msg_{{ $customer->id }}.value+' '+customer_type_del_object_{{ $customer->id }}.value.toLowerCase(),customer_type_del_yes_{{ $customer->id }}.value,customer_type_del_no_{{ $customer->id }}.value,customer_type_del_conf_{{ $customer->id }}.value)">@lang('custom.delete')</button>
                                                                <form method="POST" action="{{ route('userapps.destroy') }}">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('GET') }}
                                                                    <input type="hidden" id="" name="status" value="0">
                                                                    <input type="hidden" id="" name="customer_type_id" value="{{ $customer->id }}">
                                                                    <button type="submit" style="display:none;" id="delete_customer_type_{{ $customer->id }}">@lang('custom.delete')</button>
                                                                </form>
                                                                <input type="hidden" id="edit_customer_type_{{ $customer->id }}" name="" value="{{ route('userapps.show', [$customer->id]) }}">
                                                            </div>
                                                        </div>
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
        
        function editCustomer(url){
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

                    $("#formEditCustomer").attr("action", url);
                    $("#prix_mod").val(resultData.prix);
                    $("#nb_place_mod").val(resultData.nb_place);
                    $("#nombre_mod").val(resultData.nombre);
                    $("#statut_mod").val(resultData.statut).change();
                    $("#customer_type_mod").val(resultData.id_type_vehicule_rental).change();

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
