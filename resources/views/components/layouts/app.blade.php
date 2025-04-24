<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/ff1d767ea6.js" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        /* Pastikan modal berada di atas konten lainnya */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            /* Darken background */
            z-index: 50;
            /* Ensure it's on top */
            display: block;
            /* Ensure visibility */
        }

        /* Modal content */
        .modal-content {
            position: relative;
            z-index: 100;
            /* Modal content on top */
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    {{ $slot }}

</body>

</html>