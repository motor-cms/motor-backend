<script src="{{ mix('/js/motor-backend.js') }}" type="text/javascript"></script>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
