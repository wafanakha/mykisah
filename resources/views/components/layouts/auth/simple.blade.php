<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'Auth' }}</title>
    <style>
        .gradient-wave {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            position: relative;
            overflow: hidden;
        }
        .gradient-wave::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20%;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 1200 120' preserveAspectRatio='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%23ffffff' opacity='.25'/%3E%3Cpath d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' fill='%23ffffff' opacity='.25'/%3E%3Cpath d='M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z' fill='%23ffffff' opacity='.25'/%3E%3C/svg%3E");
            background-size: cover;
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="min-h-screen bg-white antialiased dark:bg-neutral-900">
    <div class="flex min-h-screen">
        <div class="hidden lg:flex w-6/10 items-center justify-center gradient-wave text-white p-10 relative">
            <div class="max-w-2xl z-10 px-10"> 
                <h1 class="text-5xl  mb-6 leading-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-100 to-white">
                    Selamat Datang di <span class="font-extrabold">MyKisah</span>!
                </h1>
                <p class="text-xl leading-relaxed text-blue-100/90 tracking-wide">
                    Temukan dan bagikan kisah inspiratif dari kehidupan sehari-hari. Jadikan kisahmu berarti bagi orang lain.
                </p>
            </div>
            
            <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-white/10 blur-xl"></div>
            <div class="absolute bottom-1/3 right-1/3 w-40 h-40 rounded-full bg-blue-400/20 blur-lg"></div>
        </div>

        <div class="flex w-full lg:w-4/10 items-center justify-center p-6 md:p-10">
            <div class="w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl p-8 border border-white/20 dark:border-neutral-700/30">
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-2 font-medium" wire:navigate>
                        <x-app-logo-icon class="size-12 text-blue-600 dark:text-blue-400 hover:scale-105 transition-transform" />
                    </a>
                </div>
                
                {{ $slot }}
            </div>
        </div>
    </div>

    @fluxScripts
</body>
</html>