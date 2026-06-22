<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body { opacity: 0; }
    </style>
    @yield('styles')
    <?= vite(['resources/css/app.css', 'resources/js/app.js']) ?>
</head>
<body>

    @yield('content')

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.transition = 'opacity 0.15s ease';
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>