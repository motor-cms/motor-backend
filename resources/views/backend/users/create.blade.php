@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('motor-backend::backend/users.new') }}
    {!! link_to_route('backend.users.index', trans('motor-backend::backend/global.back'), [], ['class' => 'pull-right btn btn-sm btn-danger']) !!}
@endsection

@section('main-content')
    @include('motor-backend::errors.list')
    @include('motor-backend::backend.users.form')
@endsection