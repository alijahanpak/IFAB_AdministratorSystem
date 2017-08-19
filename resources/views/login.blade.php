<!doctype html>
<html class="no-js" lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foundation for Sites</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/key.css') }}">
</head>
<body class="BYekan">
<div class="grid-container login-el-center">
    <div class="grid-x">
        <div style="margin-top: 40px;margin-bottom: 20px;" class="medium-6 large-offset-1">
            <img class="login-logo-mrg" src="{{ asset('pic\logom.jpg') }}" width="74px" height="74px">
        </div>
    </div>
    <div class="grid-x">
        <div class="">
            <h5 class="BYekan large-offset-7 login-txt">سامانه یکپارچه اداری-مالی و بودجه</h5>
        </div>
    </div>
    <div class="grid-x">
        <div style="margin-top: 20px;" class="large-4 large-offset-4 cell callout ">
            {!! Form::open(array('id' => 'signInForm' , 'url' => '/signin' , 'class' => 'form' , 'data-abide novalidate')) !!}
                {!! csrf_field() !!}
                @if(count($errors->loginErrors))
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i> {{ $errors->loginErrors->first() }}</p>
                    </div>
                @endif
                <div class="row">
                    <div class="small-12 columns">
                        <label>نام کاربری
                            <input name="email" type="text" required pattern="text">
                            <span class="form-error"></span>
                        </label>
                    </div>
                </div>
                <div class="row">
                <div class="small-12 columns">
                    <label>رمز عبور
                        <input name="password" type="password" id="password" required >
                        <span class="form-error">لطفا رمز عبور را روباره وارد کنید</span>
                    </label>
                </div>
                </div>
                <div class="row">
                    <fieldset class="large-6 columns">
                        <button class="button expanded" type="submit" value="Submit">ورود</button>
                    </fieldset>
                </div>
             {!! Form::close() !!}
        </div>
    </div>


</div>
<div class="grid-x">
    <div class="large-12">
        <ul class="menu small-font align-center ul-margin">
            <li><a class="footer-menu" href="#">راهنمای سامانه</a></li>
            <li><a class="footer-menu" href="#">درباره ما</a></li>
            <li><a class="footer-menu" href="#">دیدگاه</a></li>
        </ul>
    </div>
    <div class="large-12">
        <p class="small-font footer-txt-size">تمامی حقوق این وب سایت متعلق یه اداره کل میراث فرهنگی صنایع دستی و گردشگری استان همدان می باشد</p>
    </div>
</div>
</body>
</html>