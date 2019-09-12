@extends('front.layouts.main')
@section('title', '新用户注册绑定')
@section('header', '')

@section('content')
    <h5>新用户注册绑定</h5>
    <?=$form->view() ?>
    <div class="buttons" style="margin-top: 10px">
        <a class="btn btn-lg btn-primary btn-block" role="button" href="{{route('oauth_bind')}}">已有账户，登陆绑定</a>
    </div>
@endsection
