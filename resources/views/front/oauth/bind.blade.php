@extends('front.layouts.main')
@section('title', '用户绑定')
@section('header', '')

@section('content')
    <h5>绑定用户</h5>
    <?=$form->view() ?>
    <div class="buttons" style="margin-top: 10px">
        <a class="btn btn-lg btn-primary btn-block" role="button" href="{{route('oauth_binding_signup')}}">立即注册并绑定</a>
    </div>
@endsection
