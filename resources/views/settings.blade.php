
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
                    <h3 class="text-themecolor">@lang('custom.settings')</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">@lang('custom.home')</a></li>
                        <li class="breadcrumb-item">@lang('custom.administration_tools')</li>
                        <li class="breadcrumb-item active">@lang('custom.settings')</li>
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
                <!-- Row -->
                <div class="modal fade" id="progress-dialog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;overflow: scroll;" data-backdrop="static">
                    <div class="modal-dialog modal-lg center">
                        <div class="row">
                            <div class="col-md-12">
                                <progress class="pure-material-progress-circular"/>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- LANGUE -->
                <div class="modal fade" id="add-langue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;overflow: scroll;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">@lang('custom.add_language')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form class="form-horizontal m-t-0" method="POST" action="{{ route('langues.store') }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('custom.name') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('libelle_langue') is-invalid @enderror" id="libelle_langue" name="libelle_langue" value="{{ old('libelle_langue') }}" required autocomplete="libelle_langue" autofocus>
                                                @error('libelle_langue')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('custom.abreviation') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('abreviation_langue') is-invalid @enderror" id="abreviation_langue" name="abreviation_langue" value="{{ old('abreviation_langue') }}" required autocomplete="abreviation_langue" autofocus>
                                                @error('abreviation_langue')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('custom.icon') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('icon_langue') is-invalid @enderror" id="icon_langue" name="icon_langue" value="{{ old('icon_langue') }}" required autocomplete="icon_langue" autofocus>
                                                @error('icon_langue')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">@lang('custom.save')</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-dark waves-effect waves-light" data-dismiss="modal">@lang('custom.cancel')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <div class="modal fade" id="mod-langue" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;overflow: scroll;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">@lang('custom.edit_language')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form class="form-horizontal m-t-0" id="formEditLangue" method="POST" action="@if(session('langue_url') != null) {{ session('langue_url') }} {{ session()->forget('langue_url') }} @endif">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('custom.name') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('libelle_langue_mod') is-invalid @enderror" id="libelle_langue_mod" name="libelle_langue_mod" value="{{ old('libelle_langue_mod') }}" required autocomplete="libelle_langue_mod" autofocus>
                                                @error('libelle_langue_mod')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('custom.abreviation') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('abreviation_langue_mod') is-invalid @enderror" id="abreviation_langue_mod" name="abreviation_langue_mod" value="{{ old('abreviation_langue_mod') }}" required autocomplete="abreviation_langue_mod" autofocus>
                                                @error('abreviation_langue_mod')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('custom.icon') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('icon_langue_mod') is-invalid @enderror" id="icon_langue_mod" name="icon_langue_mod" value="{{ old('icon_langue_mod') }}" required autocomplete="icon_langue_mod" autofocus>
                                                @error('icon_langue_mod')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">@lang('custom.save')</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-dark waves-effect waves-light" data-dismiss="modal">@lang('custom.cancel')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">@lang('custom.settings')</h4>
                                <form class="form-horizontal m-t-0" method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 m-b-0">
                                            <div class="form-group mb-3">
                                                <label class="mr-sm-2" for="designation">@lang('custom.admin_panel_title')</label>
                                                <input type="text" class="form-control " placeholder="" name="title" id="title" required value="@if($settings->count() > 0){{ $settings[0]->title }}@endif"> 
                                                <div class="invalid-feedback">
                                                    Error message
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 m-b-0">
                                            <div class="form-group mb-3">
                                                <label class="mr-sm-2" for="designation">@lang('custom.admin_panel_footer')</label>
                                                <input type="text" class="form-control " placeholder="" name="footer" id="footer" required value="@if($settings->count() > 0){{ $settings[0]->footer }}@endif"> 
                                                <div class="invalid-feedback">
                                                    Error message
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 m-b-0">
                                            <div class="form-group mb-3">
                                                <label class="mr-sm-2" for="designation">@lang('custom.receiving_email_address')</label>
                                                <input type="email" class="form-control " placeholder="" name="email" id="email" required value="@if($settings->count() > 0) {{ $settings[0]->email }} @endif"> 
                                                <div class="invalid-feedback">
                                                    Error message
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer m-t-40">
                                        <button type="submit" class="btn btn-dark waves-effect">@lang('custom.save')</button>
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('custom.cancel')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="p-20">
                                <!-- <h4 class="card-title">Data Table</h4> -->
                                <!-- <h6 class="card-subtitle">Liste des catégories d'utilisateur de la plateforme admin</h6> -->
                                <!-- <a href="route('sendDatas')" class="btn btn-dark waves-effect waves-light btn-sm">Send data</a> -->
                                <button type="button" data-toggle="modal" data-target="#add-langue" class="btn btn-dark waves-effect waves-light btn-sm">@lang('custom.add_language')</button>
                                <!-- sample modal content -->
                                <div class="table-responsive m-t-0">
                                    <table id="example0" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('custom.name')</th>
                                                <th>@lang('custom.abreviation')</th>
                                                <th>@lang('custom.icon')</th>
                                                <!-- <th>@lang('custom.default')</th> -->
                                                <th>@lang('custom.actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($langues))
                                                @foreach($langues as $key => $langue)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $langue->libelle }}</td>
                                                        <td>{{ $langue->abreviation }}</td>
                                                        <td><i class="{{ $langue->icon }}"></i></td>
                                                        <!-- <td>@if($langue->default==1) <label class="label label-success">@lang('custom.enabled')</label> @else <label class="label label-danger">@lang('custom.disabled')</label> @endif</td> -->
                                                        <td>
                                                            <div class="btn-group">
                                                                <!-- <a href="{{ route('langues.update.status', [$langue->id]) }}" class="btn btn-primary m-r-10"><i class="fa fa-check"></i></a> -->
                                                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Actions
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    <button class="dropdown-item font-12" onclick="editLangue(edit_langue_{{ $langue->id }}.value)">@lang('custom.edit')</button>
                                                                    <input type="hidden" id="langue_del_msg_{{ $langue->id }}" value="@lang('custom.are_you_sure_you_want_to_delete_it') " />
                                                                    <input type="hidden" id="langue_del_yes_{{ $langue->id }}" value="@lang('custom.yes')" />
                                                                    <input type="hidden" id="langue_del_no_{{ $langue->id }}" value="@lang('custom.no')" />
                                                                    <input type="hidden" id="langue_del_object_{{ $langue->id }}" value="@lang('custom.this_line')" />
                                                                    <input type="hidden" id="langue_del_conf_{{ $langue->id }}" value="@lang('custom.confirmation')" />
                                                                    <button class="dropdown-item font-12" onclick="showDelAlert(delete_langue_{{ $langue->id }}.id,langue_del_msg_{{ $langue->id }}.value+' '+langue_del_object_{{ $langue->id }}.value.toLowerCase(),langue_del_yes_{{ $langue->id }}.value,langue_del_no_{{ $langue->id }}.value,langue_del_conf_{{ $langue->id }}.value)">@lang('custom.delete')</button>
                                                                    <form method="POST" action="{{ route('langues.destroy') }}">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('GET') }}
                                                                        <input type="hidden" id="" name="status" value="0">
                                                                        <input type="hidden" id="" name="langue_id" value="{{ $langue->id }}">
                                                                        <button type="submit" style="display:none;" id="delete_langue_{{ $langue->id }}">@lang('custom.delete')</button>
                                                                    </form>
                                                                    <input type="hidden" id="edit_langue_{{ $langue->id }}" name="" value="{{ route('langues.show', [$langue->id]) }}">
                                                                    <input type="hidden" id="details_langue_{{ $langue->id }}" name="" value="{{ route('langues.show', [$langue->id]) }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
        
        function editLangue(url){
            // alert(url)
            // showModal();
            $.ajax({
                url: url,
                type: 'GET',
                data: {'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    $("#libelle_langue_mod").empty();
                    $("#abreviation_langue_mod").empty();
                    $("#icon_langue_mod").empty();

                    var resultData = data.data;

                    $("#formEditLangue").attr("action", url);
                    $("#libelle_langue_mod").val(resultData.libelle);
                    $("#abreviation_langue_mod").val(resultData.abreviation);
                    $("#icon_langue_mod").val(resultData.icon);

                    $('#mod-langue').modal();
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
