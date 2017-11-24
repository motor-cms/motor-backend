<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
{{--<script src="{{ asset('/js/moment-with-locales.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>--}}

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
