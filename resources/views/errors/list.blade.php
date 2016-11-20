@if ($errors->any())
    <div class="callout callout-danger">
        <h4>Data missing!</h4>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif