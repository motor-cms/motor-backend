@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    Server error
@endsection

@section('contentheader_title')
    500 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

    <div class="error-page">
        <h2 class="headline text-red">500</h2>
        <div class="error-content">
            <h3>Oops! Something went wrong.</h3>
            <p>
                We will work on fixing that right away.
                Meanwhile, you may <a href='{{ url('/backend') }}'>return to dashboard</a>.
            </p>
        </div>
    </div><!-- /.error-page -->

@endsection