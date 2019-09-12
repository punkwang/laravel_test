@extends('front.layouts.main')
@section('title', '用户首页')

@section('content')
    <?=$form->view() ?>
    @include('front.common._oauth_buttons')
@endsection
