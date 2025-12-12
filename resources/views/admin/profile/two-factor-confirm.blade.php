@extends('admin.layouts.app')

@section('title', 'Confirm Two-Factor Authentication')

@section('content')
<div class="max-w-lg mx-auto space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Profile', 'url' => route('admin.profile.show')],
        ['label' => 'Two-Factor Authentication', 'url' => route('admin.profile.two-factor')],
        ['label' => 'Confirm', 'url' => null]
    ]" />

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Setup Two-Factor Authentication</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Scan the QR code with your authenticator app</p>
        </div>

        <div class="p-6">
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <div class="text-center mb-6">
                <div class="inline-block p-4 bg-white rounded-xl shadow-sm border border-gray-200">
                    {!! $qrCodeSvg !!}
                </div>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 text-center">Or enter this code manually:</p>
                <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg text-center">
                    <code class="text-lg font-mono font-semibold text-gray-900 dark:text-white tracking-widest">{{ $secret }}</code>
                </div>
            </div>

            <form action="{{ route('admin.two-factor.confirm') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Enter the 6-digit code from your app</label>
                    <input type="text" 
                           name="code" 
                           class="form-input w-full text-center text-2xl font-mono tracking-widest" 
                           maxlength="6" 
                           pattern="[0-9]{6}"
                           placeholder="000000"
                           required
                           autofocus>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.profile.two-factor') }}" class="btn btn-secondary flex-1 justify-center">Cancel</a>
                    <button type="submit" class="btn btn-primary flex-1 justify-center">Confirm & Enable</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
