@extends('templates.login-template')
@section('page-title')
    @lang('custom.email_verify') | TOOGOON ADMIN PANEL
@stop
@section('login')
    <div class="row">
        <div class="col-md-12">
            <!-- <div class=""> -->
                <div class="row width100 wizard-circle custom-step center text-left custom-left-side">
                    <div class="col-sm-12 col-md-12 col-12 m-b-30">
                        <!-- <h1 class="login-title">{{ __('Vérifiez votre adresse e-mail') }}</h1> -->
                        <div class="form-horizontal form-material m-t-150 custom-verified" id="loginform">
                            @csrf
                            <a href="javascript:void(0)" class="text-center db m-b-40"><img src="{{ asset('assets/images/logo.png') }}" width="50%" alt="Home" /><br/>
                            <!-- <img src="{{ asset('assets/images/logo-text.png') }}" alt="Home" /> -->
                            </a>
                            <h3 class="box-title m-b-0">{{ __('Votre adresse email a été vérifiée avec succès') }}</h3>
                            <p class="m-t-20 text-center">{{ __('Vous serez rediriger sur la page de connexion dans 10s') }} </p>
                            <!-- {{ __('Si vous n\'avez pas reçu l\'e-mail') }}, -->
                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-success btn-block text-uppercase waves-effect waves-light">{{ __('Se connecter maintenant') }}</a>
                                </div>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <!-- <div class="col-sm-12 col-md-12 col-12 text-center">
                        <img src="{{ asset('assets/images/password-verify.svg') }}" alt="" width="60%">
                    </div> -->
                    <div class="col-md-12">
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
@stop