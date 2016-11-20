@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('motor-backend::backend/permissions.new') }}
    {!! link_to_route('backend.permissions.index', trans('motor-backend::backend/global.back'), [], ['class' => 'pull-right btn btn-sm btn-danger']) !!}
@endsection

@section('main-content')
    @include('errors.list')
    @include('motor-backend::backend.permissions.form')
@endsection