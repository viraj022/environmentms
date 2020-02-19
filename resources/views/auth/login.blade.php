@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="container">
            <center>
                <div class="middle">
                    <div id="login">



                            <fieldset class="clearfix">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <p><span class="fa fa-user"></span>


                                        {{--                                    <input type="text" required>--}}

                                        <input Placeholder="Username" id="user_name" type="text"
                                               class="@error('user_name') is-invalid @enderror" name="user_name"
                                               value="{{ old('user_name') }}" required autocomplete="user_name" autofocus>

                                    </p>
                                    <!-- JS because of IE support; better: placeholder="Username" -->
                                    <p><span class="fa fa-lock"></span>
                                        <input Placeholder="Password" id="password" type="password"
                                               class=" @error('password') is-invalid @enderror" name="password"
                                               required autocomplete="current-password">

                                        @error('password')
                                        <h1>dasdsadsad</h1>
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                         @error('user_name')
                                             <B> <label class="text-danger" style="font-size: 16px;">Invalid User Name or Password</label></B>
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </p> <!-- JS because of IE support; better: placeholder="Password" -->

                                    <div>
                                <span style="width:48%; text-align:left;  display: inline-block;"><a class="small-text"
                                                                                                     href="#">Forgot
                                password?</a></span>
                                        {{--                                    <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

                                        {{--                                    <label class="form-check-label" for="remember">--}}
                                        {{--                                        {{ __('Remember Me') }}--}}
                                        {{--                                    </label>--}}
                                        <span style="width:50%; text-align:right;  display: inline-block;">

                                        <input  type="submit"  value="Sign In"></span>

                                    </div>
                                </form>
                            </fieldset>
                            <div class="clearfix"></div>

                        <div class="clearfix"></div>

                    </div> <!-- end login -->
                    <div class="logo">
<img src="dist/img/uilogo.png" alt="Official Logo">                        
                    </div>

                </div>
            </center>
        </div>

    </div>
@endsection
