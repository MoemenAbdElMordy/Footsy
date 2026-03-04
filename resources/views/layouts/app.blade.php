<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Footsy - Footwear E-Commerce')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS Variables -->
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <style>
        .object-fit-cover {
            object-fit: cover;
        }
        
        /* Responsive adjustments - keeping original design on desktop */
        @media (max-width: 767.98px) {
            /* Hero section responsive */
            section[style*="height: 600px"] {
                height: 400px !important;
                min-height: 400px !important;
            }
            
            /* Typography scaling for mobile */
            .display-4 { font-size: 2rem !important; }
            .display-5 { font-size: 1.75rem !important; }
            .display-6 { font-size: 1.5rem !important; }
            .lead { font-size: 1rem !important; }
            
            /* Container padding on mobile */
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            /* Hero content padding on mobile */
            .text-white[style*="padding: var(--spacing-xl)"] {
                padding: 1.5rem !important;
            }
            
            /* Button stacking on mobile */
            .d-flex.gap-3 {
                flex-direction: column;
            }
            .d-flex.gap-3 > * {
                width: 100%;
            }
        }
        
        @media (max-width: 575.98px) {
            /* Extra small devices */
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: var(--color-background); color: var(--color-foreground);">
    <x-header />
    
    <main class="flex-grow-1">
        @yield('content')
    </main>
    
    <x-footer />
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

