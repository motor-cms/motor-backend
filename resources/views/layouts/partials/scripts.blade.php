<script type="module">
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>

    window.websocket = {
        key: '{{ env('VITE_REVERB_APP_KEY', env('REVERB_APP_KEY')) }}',
        host: '{{ env('VITE_REVERB_HOST', 'localhost') }}',
        port: {{ env('VITE_REVERB_PORT', 80) }},
        path: '{{ env('VITE_REVERB_PATH', '/socket') }}',
        scheme: '{{ env('VITE_REVERB_SCHEME', 'http') }}',
    };
</script>
@vite(['resources/assets/js/app.js'])
