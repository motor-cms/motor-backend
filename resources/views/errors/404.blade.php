@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    Page not found
@endsection

@section('contentheader_title')
    404 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3>Oops! Page not found.</h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href='{{ url('/backend') }}'>return to dashboard</a>.
            </p>
        </div>
    </div><!-- /.error-page -->

@endsection