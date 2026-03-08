<script src="{{ mix('/js/motor-backend.js') }}" type="text/javascript"></script>

<script type="module">
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
