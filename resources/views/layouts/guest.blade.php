<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/KomikQue.png') }}">
    <title>{{ config('app.name', 'KomikQue') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 Script -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-image font-sans text-gray-900 antialiased ">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center h-screen"
         style="background-image: url('/images/black.jpg'); dark:bg-gray-900">
         <div class="cursor">
            <div class="cursor__ball cursor__ball--big">
                <svg height="30" width="30">
                    <circle cx="15" cy="15" r="14"></circle>
                </svg>
            </div>
            <div class="cursor__ball cursor__ball--small">
                <svg height="12" width="12">
                    <circle cx="5" cy="5" r="4"></circle>
                </svg>
            </div>
        </div>
        <div>
            <a href="/">
                <!-- Ganti bagian ini dengan logo baru -->
                <img src="{{ asset('images/KomikQue.png') }}" alt="Logo" class="w-20 h-auto border border-black rounded-lg  ">
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    <script>
        const $bigBall = document.querySelector('.cursor__ball--big');
        const $smallBall = document.querySelector('.cursor__ball--small');
        const $hoverables = document.querySelectorAll('.hoverable');

        document.body.addEventListener('mousemove', onMouseMove);
        $hoverables.forEach(item => {
            item.addEventListener('mouseenter', onMouseHover);
            item.addEventListener('mouseleave', onMouseHoverOut);
        });

        const cursorSizeBig = 30; // Diameter of the big cursor circle
        const cursorSizeSmall = 12; // Diameter of the small cursor circle

        // Move the cursor
        function onMouseMove(e) {
            const offsetBig = cursorSizeBig / 1.2; // Half of the size to center the big cursor
            const offsetSmall = cursorSizeSmall / 2; // Half of the size to center the small cursor

            TweenMax.to($bigBall, 1, {
                x: e.pageX - offsetBig,
                y: e.pageY - offsetBig
            });
            TweenMax.to($smallBall, 0.1, {
                x: e.pageX - offsetSmall,
                y: e.pageY - offsetSmall
            });
        }


        // Hover an element
        function onMouseHover() {
            TweenMax.to($bigBall, 0.3, {
                scale: 2, // Slightly smaller scaling for the hover effect
                fill: "rgba(255, 255, 255, 0.6)"
            });
        }

        function onMouseHoverOut() {
            TweenMax.to($bigBall, 0.3, {
                scale: 1,
                fill: "rgba(255, 255, 255, 0.2)"
            });
        }
    </script>
        <!-- Cursor JS -->
        <script>
            const $bigBall = document.querySelector('.cursor__ball--big');
            const $smallBall = document.querySelector('.cursor__ball--small');
            const $hoverables = document.querySelectorAll('.hoverable');

            document.body.addEventListener('mousemove', onMouseMove);
            $hoverables.forEach(item => {
                item.addEventListener('mouseenter', onMouseHover);
                item.addEventListener('mouseleave', onMouseHoverOut);
            });

            const cursorSizeBig = 30; // Diameter of the big cursor circle
            const cursorSizeSmall = 12; // Diameter of the small cursor circle

            // Move the cursor
            function onMouseMove(e) {
                const offsetBig = cursorSizeBig / 1.2; // Half of the size to center the big cursor
                const offsetSmall = cursorSizeSmall / 2; // Half of the size to center the small cursor

                TweenMax.to($bigBall, 1, {
                    x: e.pageX - offsetBig,
                    y: e.pageY - offsetBig
                });
                TweenMax.to($smallBall, 0.1, {
                    x: e.pageX - offsetSmall,
                    y: e.pageY - offsetSmall
                });
            }


            // Hover an element
            function onMouseHover() {
                TweenMax.to($bigBall, 0.3, {
                    scale: 2, // Slightly smaller scaling for the hover effect
                    fill: "rgba(255, 255, 255, 0.6)"
                });
            }

            function onMouseHoverOut() {
                TweenMax.to($bigBall, 0.3, {
                    scale: 1,
                    fill: "rgba(255, 255, 255, 0.2)"
                });
            }
        </script>
</body>

</html>
