@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('motor-backend::backend/users.profile.edit') }}
@endsection

@section('main-content')
    @include('motor-backend::errors.list')
    @include('motor-backend::backend.profile.form')
@endsection