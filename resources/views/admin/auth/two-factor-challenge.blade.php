<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Two-Factor Authentication - {{ config('app.name', 'InSocialWise') }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='grad1' x1='0%' y1='0%' x2='100%' y2='100%'><stop offset='0%' style='stop-color:%233b82f6;stop-opacity:1' /><stop offset='100%' style='stop-color:%239333ea;stop-opacity:1' /></linearGradient></defs><rect width='100' height='100' rx='20' fill='url(%23grad1)'/><path d='M50 20L65 50L50 80L35 50Z' fill='white' opacity='0.9'/><path d='M30 45L50 35L70 45' stroke='white' stroke-width='3' fill='none' stroke-linecap='round'/></svg>">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Two-Factor Authentication</h1>
            <p class="text-slate-400 mt-2">Enter the code from your authenticator app</p>
        </div>

        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-8" x-data="{ useRecovery: false }">
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/30">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-red-300">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.two-factor.verify') }}" method="POST">
                @csrf
                
                <div x-show="!useRecovery">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Authentication Code</label>
                        <input type="text" 
                               name="code" 
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white text-center text-2xl font-mono tracking-widest placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                               maxlength="6" 
                               pattern="[0-9]{6}"
                               placeholder="000000"
                               autofocus>
                    </div>
                </div>

                <div x-show="useRecovery" x-cloak>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Recovery Code</label>
                        <input type="text" 
                               name="recovery_code" 
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white text-center font-mono placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                               placeholder="xxxx-xxxx-xxxx">
                    </div>
                </div>

                <button type="submit" class="w-full btn btn-primary py-3 mb-4">
                    Verify
                </button>

                <button type="button" 
                        @click="useRecovery = !useRecovery" 
                        class="w-full text-sm text-slate-400 hover:text-white transition-colors">
                    <span x-show="!useRecovery">Use a recovery code instead</span>
                    <span x-show="useRecovery">Use authentication code instead</span>
                </button>
            </form>
        </div>

        <p class="text-center text-slate-500 text-sm mt-6">
            <a href="{{ route('admin.login') }}" class="hover:text-white transition-colors">
                &larr; Back to login
            </a>
        </p>
    </div>
</body>
</html>
