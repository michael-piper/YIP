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
                                <h3 class="uk-card-title uk-text-center">Sign up as a Vendor!</h3>
                                <form>
                                    @csrf
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: world"></span>
                                            <input class="uk-input uk-form-large" name="name" placeholder="store name" type="text" value="{{$body['name'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                                            <input class="uk-input uk-form-large" name="contact_name" placeholder="contact name" type="text" value="{{$body['contact_name'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                                            <input class="uk-input uk-form-large" name="phone" placeholder="contact number" type="tel" value="{{$body['phone'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                            <input class="uk-input uk-form-large" name="email" placeholder="contact email" type="email" value="{{$body['email'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: location"></span>
                                            <select name="state" class="uk-input uk-select uk-form-large">
                                                <option value="" default="" selected="">Select state</option>
                                                <option value="Abia">Abia</option>
                                                <option value="Adamawa">Adamawa</option>
                                                <option value="Akwa Ibom">Akwa Ibom</option>
                                                <option value="Anambra">Anambra</option>
                                                <option value="Bauchi">Bauchi</option>
                                                <option value="Bayelsa">Bayelsa</option>
                                                <option value="Benue">Benue</option>
                                                <option value="Borno">Borno</option>
                                                <option value="Cross River">Cross River</option>
                                                <option value="Delta">Delta</option>
                                                <option value="Ebonyi">Ebonyi</option>
                                                <option value="Edo">Edo</option>
                                                <option value="Ekiti">Ekiti</option>
                                                <option value="Enugu">Enugu</option>
                                                <option value="FCT">FCT</option>
                                                <option value="Gombe">Gombe</option>
                                                <option value="Imo">Imo</option>
                                                <option value="Jigawa">Jigawa</option>
                                                <option value="Kaduna">Kaduna</option>
                                                <option value="Kano">Kano</option>
                                                <option value="Katsina">Katsina</option>
                                                <option value="Kebbi">Kebbi</option>
                                                <option value="Kogi">Kogi</option>
                                                <option value="Kwara">Kwara</option>
                                                <option value="Lagos">Lagos</option>
                                                <option value="Nassarawa">Nassarawa</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Ogun">Ogun</option>
                                                <option value="Ondo">Ondo</option>
                                                <option value="Osun">Osun</option>
                                                <option value="Oyo">Oyo</option>
                                                <option value="Plateau">Plateau</option>
                                                <option value="Rivers">Rivers</option>
                                                <option value="Sokoto">Sokoto</option>
                                                <option value="Taraba">Taraba</option>
                                                <option value="Yobe">Yobe</option>
                                                <option value="Zamfara">Zamfara</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: location"></span>
                                            <textarea class="uk-input uk-form-large" name="address" placeholder="Store address" value="{{$body['address'] ?? ''}}"></textarea>
                                        </div>
                                    </div>

                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: pencil"></span>
                                            <select  name="id_card_type" class="uk-input uk-select uk-form-large">
                                                <option value="" default="" {{isset($body['id_card_type']) && ($body['id_card_type']=='' )? 'selected=""':''}}>ID card type</option>
                                                <option value="National ID card" {{isset($body['id_card_type']) && ($body['id_card_type']=='National ID card' )? 'selected=""':''}}>National ID card</option>
                                                <option value="National Voter's card" {{isset($body['id_card_type']) && ($body['id_card_type']=='National Voter\'s card' )? 'selected=""':''}}>National Voter's card</option>
                                                <option value="National Driver's License" {{isset($body['id_card_type']) && ($body['id_card_type']=='National Driver\'s License' )? 'selected=""':''}}>National Driver's License</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: pencil"></span>
                                            <input class="uk-input uk-form-large" name="id_card_number" placeholder="ID card number" type="text" value="{{$body['id_card_number'] ?? ''}}">
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
                                        want to buy on MotopartsArena? <a href="/signup">Sign up as Customer</a>
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
