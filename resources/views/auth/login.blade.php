@extends('templates.login-template')
@section('page-title')
    {{ App\Setting::select('title')->first()->title }}
@stop
@section('login')
    @if (!Auth::guest())
    <script>
        window.location.href = '{{ url("home") }}';
    </script>
    @endguest
    <div class="login-box card">
        <div class="card-body">
            <p class="text-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" width="40%">
            </p>
            <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('login') }}">
                @csrf
                <h3 class="box-title m-t-40 m-b-0">@lang('custom.enter_your_informations')</h3>
                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="@lang('custom.email')" type="email" value="@if(old('email')) {{ old('email') }} @else admin@admin.com @endif" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" value="admin@2020" placeholder="@lang('custom.password')" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!-- <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-blue-grey">
                                <label for="checkbox-signup" class="font-14"> @lang('custom.remember_me') </label>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-success btn-block text-uppercase waves-effect waves-light" type="submit">@lang('custom.login')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop