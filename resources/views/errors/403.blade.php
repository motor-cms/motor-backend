@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    Access denied
@endsection

@section('contentheader_title')
    403 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

    <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2>
        <div class="error-content">
            <h3>Oops! You don't have access to this page.</h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href='{{ url('/backend') }}'>return to dashboard</a>.
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

@endsection