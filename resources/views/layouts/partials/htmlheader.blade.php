<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ config('motor-backend-project.name') }} Backend">
    <meta name="author" content="Reza Esmaili">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('motor-backend-project.name') }} Backend - @yield('htmlheader_title', 'Your title here') </title>

    @yield('view_styles')

<!-- Main styles for this application -->
    @vite(['resources/assets/sass/project.package-development.scss'])

    {{-- Apply dark mode before paint to avoid flash --}}
    <script>
        (function() {
            var dark = localStorage.getItem('pm-dark-mode');
            if (dark === null) dark = 'true';
            window.__pmDark = dark === 'true';
            if (window.__pmDark) {
                document.documentElement.style.background = '#181a1e';
                // Apply c-dark-theme to body as soon as it exists
                new MutationObserver(function(mutations, obs) {
                    if (document.body) {
                        document.body.classList.add('c-dark-theme');
                        obs.disconnect();
                    }
                }).observe(document.documentElement, { childList: true });
            }
        })();
    </script>
</head>
