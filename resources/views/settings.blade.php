@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 animated fadeInUp delay-1s faster">
                    <h1>Settings</h1>
                    
                    <section class="basic-information section-container">
                            <div class="form">
                                <h4>Basic information</h4>
                                @isset($errors)
                                    <ul class="errors">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                @endisset
                                <form method="post" action="{{route('settings/update/basic')}}">
                                    {{ csrf_field() }}
                                    {{ method_field('patch') }}
                                    
                                    <div class="row">
                                        <input type="email" name="email" placeholder="Email" value=" {{ $user->email }}" />
                                    </div>

                                    <div class="row">
                                        <input type="password" placeholder="Password" name="password" />
                                    </div>
                                    <div class="row">
                                        <input type="password" placeholder="Password Confirmation" name="password_confirmation" />
                                    </div>

                                    <input type="submit" class="btn" value="Save">
                                </form>
                            </div>
                    </section>
                    <section class="settings-news section-container">
                            <h4>News Sources</h4>
                            <sources></sources>
                    </section>

                    <section class="basic-information section-container">
                            <h4>Tags</h4>
                            <p>Tags to look out in articles for</p>
                            <tags></tags>
                    </section>

                    
                    <section class="delete-account section-container">                    
                        <h4>Delete Account</h4>
                        <p>You can delete your account here. You won't be able to undo this action.</p>
                        <deleteaccount :route-data="'{!!route('settings/account/remove')!!}'"></deleteaccount>
                    </section>
        </div>
    </div>
</div>
@endsection
