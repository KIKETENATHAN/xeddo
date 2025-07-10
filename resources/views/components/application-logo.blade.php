@props(['type' => 'full', 'size' => 'default'])

@php
    $sizeClasses = [
        'small' => 'h-8 w-auto',
        'default' => 'h-12 w-auto',
        'large' => 'h-16 w-auto',
        'xlarge' => 'h-20 w-auto'
    ];
    
    $currentSize = $sizeClasses[$size] ?? $sizeClasses['default'];
@endphp

@if($type === 'icon')
    <!-- Icon only version -->
    <img src="{{ asset('images/logo.jpg') }}" 
         alt="Xeddo Travel Link Logo" 
         {{ $attributes->merge(['class' => $currentSize . ' object-contain']) }}>
@else
    <!-- Full logo with text -->
    <div {{ $attributes->merge(['class' => 'flex items-center space-x-3']) }}>
        <!-- Logo Image -->
        <img src="{{ asset('images/logo.jpg') }}" 
             alt="Xeddo Travel Link Logo" 
             class="{{ $currentSize }} object-contain">
        
        <!-- Text (optional - can be removed if logo.jpg already contains text) -->
        <div class="flex flex-col leading-none">
            <span class="font-bold text-2xl text-primary tracking-tight">Xeddo</span>
            <span class="text-sm text-secondary font-medium">Travel Link</span>
        </div>
    </div>
@endif
