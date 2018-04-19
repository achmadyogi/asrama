@extends('layouts.default')

@section('title','Email Verification')

@section('main_menu')
    @parent

@endsection

@section('header_title','Email Verification')
@section('content')

@section('content')
<div class="container">
    <br><br><br>
    <style>
    .verificationEmail{
        border: 1px solid rgba(175,175,175,1.00);
		background-color: rgba(224,224,224,1.00);
		padding: 15px;
    }
    </style>
    <div class="verificationEmail">
        <p>Silahkan melakukan verifikasi pada email Anda untuk aktivasi akun. Apabila Anda tidak menemukan email verifikasi, silahkan klik <a href="#">disini</a> untuk mengirimkan ulang email verifikasi bila email tidak ditemukan di inbox email Anda. Terimakasih!</p>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>
@endsection
