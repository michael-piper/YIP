@extends('layouts.main')

@section("title","")

@section('style')
<style>
</style>
@endsection

@section('js')

@endsection

@section('content')
<section>
        <div class="uk-section uk-section-muted uk-flex uk-flex-middle uk-animation-fade">
            <div class="uk-width-1-1">
                <div class="uk-container">
                    <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                        <div class="uk-width-1-1@m">
                            <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                                @if (isset($error))
                                    @alert(['error'=>$error])
                                    @endalert
                                @elseif(isset($success))
                                    @alert(['success'=>$success])
                                    @endalert
                                @elseif(isset($warning))
                                    @alert(['warning'=>$warning])
                                    @endalert
                                @endif
                                <h3 class="uk-card-title uk-text-center">Sign up as a customer!</h3>
                                <form method="POST" action="/signup">
                                    @csrf
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                                        <input class="uk-input uk-form-large" name="name" placeholder="Full name" type="text" value="{{$body['name']??''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                            <input class="uk-input uk-form-large" name="email" placeholder="Email" type="email" value="{{$body['email'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                                            <input class="uk-input uk-form-large" name="phone" placeholder="Phone number" type="tel" value="{{$body['phone'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: location"></span>
                                            <textarea class="uk-input uk-form-large" name="address" placeholder="address">{{$body['address'] ?? ''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                            <input class="uk-input uk-form-large" name="password" placeholder="Password" type="password" value="{{$body['password'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                            <input class="uk-input uk-form-large" name="confirm_password" placeholder="Confirm password" type="password" value="{{$body['confirm_password'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <button class="uk-button uk-button-primary uk-button-large uk-width-1-1">Register</button>
                                    </div>
                                    <div class="uk-text-small uk-text-center">
                                        want to sell on MotopartsArena? <a href="/signup_vendor">Sign up as Vendor</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
@endsection
