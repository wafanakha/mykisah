<!DOCTYPE html>
<html lang="en" class="h-full" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyKisah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes fadeInSlide {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInSlide 0.8s ease-out forwards;
        }


    </style>
</head>
<body class="bg-gradient-to-r from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-blue-800 dark:to-blue-900 transition-all duration-500 h-full text-center text-gray-800 dark:text-gray-100">
    <div id="page-content" class="min-h-screen flex flex-col justify-center items-center px-4 space-y-6 opacity-0 transition-opacity duration-700">
        <!-- Logo -->
        <div >
            <img src="{{ asset('images/logo-light.png') }}" alt="MyKisah Logo" class="w-64 mb-6 dark:hidden">
            <img src="{{ asset('images/logo-dark.png') }}" alt="MyKisah Logo Dark" class="w-64 mb-6 hidden dark:block">
        </div>

        <!-- Title & Description -->
        <h1 class="text-5xl font-bold text-blue-700 dark:text-blue-200 fade-in">Selamat Datang di <span class="font-extrabold">MyKisah</span>!</h1>
        <p class="text-xl max-w-xl text-gray-700 dark:text-gray-300 fade-in" style="animation-delay: 0.3s;">Temukan dan bagikan kisah inspiratif dari kehidupan sehari-hari. Jadikan kisahmu berarti bagi orang lain.</p>

        <!-- Buttons -->
        <div class="flex space-x-4 mt-6 fade-in" style="animation-delay: 0.6s;">
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition-all" onclick="handlePageTransition(event)">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-white border border-blue-600 text-blue-700 hover:bg-blue-50 dark:bg-blue-400 dark:text-blue-900 dark:hover:bg-blue-300 font-bold py-2 px-6 rounded-full shadow-lg transition-all" onclick="handlePageTransition(event)">
                Daftar
            </a>
        </div>
    </div>

    <script>
        // Fade in saat load
        window.addEventListener('DOMContentLoaded', () => {
            const page = document.getElementById('page-content');
            page.classList.remove('opacity-0');
            page.classList.add('opacity-100');
        });

        // Fade out sebelum pindah halaman
        function handlePageTransition(event) {
            event.preventDefault();
            const url = event.currentTarget.href;
            const page = document.getElementById('page-content');
            page.classList.remove('opacity-100');
            page.classList.add('opacity-0');
            setTimeout(() => {
                window.location.href = url;
            }, 600); // durasi harus sesuai dengan transition-duration
        }
    </script>
</body>
</html>
