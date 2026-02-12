<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'e-GoalTrack Enterprise')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative font-sans antialiased bg-gray-50 flex flex-col min-h-screen overflow-x-hidden">

    <!-- Cercles animés en arrière-plan -->
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[80rem] h-[80rem] bg-gradient-to-r from-indigo-400 to-purple-600 rounded-full opacity-20 animate-pulse-slow z-0"></div>
    <div class="absolute bottom-0 right-0 w-[50rem] h-[50rem] bg-gradient-to-tr from-pink-400 to-indigo-500 rounded-full opacity-15 animate-pulse-slow z-0"></div>

    <!-- Navigation fixe en haut -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ redirectByRole() }}"
                       class="text-2xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        e-GoalTrack
                    </a>
                </div>

                <!-- Menu utilisateur -->
                @auth
                    <div class="flex items-center space-x-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Déconnexion
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Se connecter</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-indigo-700 transition">Créer un compte</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="relative z-10 flex-grow pt-20">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer fixé en bas -->
    <footer class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-inner">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            © {{ date('Y') }} e-GoalTrack Enterprise - Tous droits réservés
        </div>
    </footer>

    <!-- Animation pulse lente -->
    <style>
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1) translate(0,0); opacity: 0.2; }
        50% { transform: scale(1.1) translate(10px, -10px); opacity: 0.3; }
    }
    .animate-pulse-slow {
        animation: pulse-slow 12s infinite;
    }
    </style>

</body>
</html>
