<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="{{ config('app.name') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>@yield('page-title') - {{ config('app.name', 'MiniMart') }}</title>
    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/minimart-icon.svg') }}">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="admin" />
    <meta property="og:title" content="@yield('page-title') - {{ config('app.name', 'MiniMart') }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:site_name" content="{{ config('app.name', 'MiniMart') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="{{ url('/') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('build-base/ktmt/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('build-base/ktmt/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('build-base/ktmt/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('build-base/ktmt/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('build-base/ktmt/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('build-base/assets/css/new-dashboard.css')}}" rel="stylesheet" type="text/css" />

    {{-- Include Metronic styles --}}
    <link href="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- Include Animate.css for additional animations --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!--end::Global Theme Styles-->

    <script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{ module_vite('build-base', 'resources/assets/sass/app.scss') }}
    {{ module_vite('build-base', 'resources/assets/sass/responsive.scss') }}

    <script>
        (function() {
            var theme = localStorage.getItem('mm-theme') || localStorage.getItem('data-bs-theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    @yield('custom-css-section')
    @yield('initialize-js-section')

    <style>
        /* MiniMart Unified Theme System */
        :root, [data-bs-theme="light"], body:not(.dark-mode) {
            --mm-primary: #2563EB;
            --mm-primary-dark: #1D4ED8;
            --mm-accent: #14B8A6;
            --mm-bg: #F8FAFC;
            --mm-surface: #FFFFFF;
            --mm-surface-subtle: #F1F5F9;
            --mm-text: #0F172A;
            --mm-text-secondary: #64748B;
            --mm-border: #E2E8F0;
            --mm-border-light: #F1F5F9;
            --mm-aside-bg: #FFFFFF;
            --mm-aside-border: #E2E8F0;
            --mm-header-bg: #FFFFFF;
            --mm-header-border: #E2E8F0;
            --mm-success: #22C55E;
            --mm-warning: #F59E0B;
            --mm-danger: #EF4444;
        }

        [data-bs-theme="dark"], body.dark-mode {
            --mm-primary: #3B82F6;
            --mm-primary-dark: #2563EB;
            --mm-accent: #2DD4BF;
            --mm-bg: #0B0F19;
            --mm-surface: #111827;
            --mm-surface-subtle: #1F2937;
            --mm-text: #F9FAFB;
            --mm-text-secondary: #9CA3AF;
            --mm-border: #1F2937;
            --mm-border-light: #374151;
            --mm-aside-bg: #111827;
            --mm-aside-border: #1F2937;
            --mm-header-bg: #111827;
            --mm-header-border: #1F2937;
        }

        /* LIGHT THEME (White Mode): Sidebar, Header, and Layout */
        body:not(.dark-mode), html:not([data-bs-theme="dark"]) body {
            background-color: var(--mm-bg) !important;
            color: var(--mm-text) !important;
        }

        body:not(.dark-mode) .wrapper,
        body:not(.dark-mode) .content,
        body:not(.dark-mode) .page,
        body:not(.dark-mode) #main_page_wrapper_area,
        body:not(.dark-mode) #kt_content_container {
            background-color: var(--mm-bg) !important;
        }

        /* Light Sidebar / Left Menu */
        body:not(.dark-mode) #kt_aside,
        body:not(.dark-mode) .aside,
        body:not(.dark-mode) .aside.aside-dark,
        html:not([data-bs-theme="dark"]) #kt_aside,
        html:not([data-bs-theme="dark"]) .aside {
            background-color: #FFFFFF !important;
            border-right: 1px solid #E2E8F0 !important;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.02) !important;
        }

        body:not(.dark-mode) #kt_aside_logo,
        html:not([data-bs-theme="dark"]) #kt_aside_logo {
            background-color: #FFFFFF !important;
            border-bottom: 1px solid #F1F5F9 !important;
        }

        body:not(.dark-mode) #kt_aside_toggle,
        body:not(.dark-mode) .aside-toggle,
        html:not([data-bs-theme="dark"]) #kt_aside_toggle {
            color: #64748B !important;
        }

        body:not(.dark-mode) #kt_aside_toggle:hover {
            color: #2563EB !important;
        }

        body:not(.dark-mode) .aside .menu-title,
        html:not([data-bs-theme="dark"]) .aside .menu-title {
            color: #334155 !important;
            font-weight: 600;
        }

        body:not(.dark-mode) .aside .menu-icon,
        body:not(.dark-mode) .aside .menu-icon i,
        body:not(.dark-mode) .aside .menu-icon .svg-icon,
        body:not(.dark-mode) .aside .menu-bullet i,
        html:not([data-bs-theme="dark"]) .aside .menu-icon i {
            color: #64748B !important;
        }

        body:not(.dark-mode) .aside .menu-arrow:after,
        html:not([data-bs-theme="dark"]) .aside .menu-arrow:after {
            background-color: #94A3B8 !important;
        }

        body:not(.dark-mode) .aside .menu-section,
        html:not([data-bs-theme="dark"]) .aside .menu-section {
            color: #94A3B8 !important;
        }

        body:not(.dark-mode) .aside .menu-link:hover,
        html:not([data-bs-theme="dark"]) .aside .menu-link:hover {
            background-color: #F8FAFC !important;
            color: #2563EB !important;
        }

        body:not(.dark-mode) .aside .menu-link:hover .menu-title,
        body:not(.dark-mode) .aside .menu-link:hover .menu-icon i,
        html:not([data-bs-theme="dark"]) .aside .menu-link:hover .menu-title {
            color: #2563EB !important;
        }

        body:not(.dark-mode) .aside .menu-link.active,
        body:not(.dark-mode) .aside .menu-item.here > .menu-link,
        html:not([data-bs-theme="dark"]) .aside .menu-link.active,
        html:not([data-bs-theme="dark"]) .aside .menu-item.here > .menu-link {
            background-color: #EFF6FF !important;
            color: #2563EB !important;
            border-radius: 0.5rem !important;
        }

        body:not(.dark-mode) .aside .menu-link.active .menu-title,
        body:not(.dark-mode) .aside .menu-item.here > .menu-link .menu-title,
        html:not([data-bs-theme="dark"]) .aside .menu-link.active .menu-title {
            color: #2563EB !important;
            font-weight: 700 !important;
        }

        body:not(.dark-mode) .aside .menu-link.active .menu-icon i,
        body:not(.dark-mode) .aside .menu-link.active .menu-bullet i,
        body:not(.dark-mode) .aside .menu-item.here > .menu-link .menu-icon i,
        html:not([data-bs-theme="dark"]) .aside .menu-link.active .menu-icon i {
            color: #2563EB !important;
        }

        /* Light Header */
        body:not(.dark-mode) #kt_header,
        body:not(.dark-mode) .header,
        html:not([data-bs-theme="dark"]) #kt_header,
        html:not([data-bs-theme="dark"]) .header {
            background-color: #FFFFFF !important;
            border-bottom: 1px solid #E2E8F0 !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03) !important;
        }

        body:not(.dark-mode) .header-page-title,
        body:not(.dark-mode) .header h3,
        body:not(.dark-mode) #kt_header .text-light,
        html:not([data-bs-theme="dark"]) .header-page-title,
        html:not([data-bs-theme="dark"]) #kt_header h3 {
            color: #0F172A !important;
            font-weight: 700;
        }

        body:not(.dark-mode) .topbar-item,
        body:not(.dark-mode) .topbar-item a,
        html:not([data-bs-theme="dark"]) .topbar-item {
            color: #334155 !important;
            font-weight: 600;
        }

        body:not(.dark-mode) #minimartThemeToggle,
        html:not([data-bs-theme="dark"]) #minimartThemeToggle {
            background-color: #F1F5F9 !important;
            border: 1px solid #E2E8F0 !important;
        }

        body:not(.dark-mode) #minimartThemeToggle i,
        body:not(.dark-mode) .theme-toggle-icon,
        html:not([data-bs-theme="dark"]) #minimartThemeToggle i {
            color: #F59E0B !important;
        }

        body:not(.dark-mode) #kt_toolbar {
            background-color: transparent !important;
        }

        body:not(.dark-mode) .card {
            background-color: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            color: #0F172A !important;
        }

        /* Logo switcher */
        body:not(.dark-mode) .logo-dark-theme,
        html:not([data-bs-theme="dark"]) .logo-dark-theme {
            display: none !important;
        }
        body:not(.dark-mode) .logo-light-theme,
        html:not([data-bs-theme="dark"]) .logo-light-theme {
            display: block !important;
        }
        body.dark-mode .logo-dark-theme,
        [data-bs-theme="dark"] .logo-dark-theme {
            display: block !important;
        }
        body.dark-mode .logo-light-theme,
        [data-bs-theme="dark"] .logo-light-theme {
            display: none !important;
        }

        /* DARK THEME: Full readability and contrast */
        [data-bs-theme="dark"], body.dark-mode {
            background-color: #0B0F19 !important;
            color: #F9FAFB !important;
        }

        body.dark-mode .page,
        body.dark-mode .wrapper,
        body.dark-mode .content,
        body.dark-mode #main_page_wrapper_area,
        body.dark-mode #kt_content_container,
        [data-bs-theme="dark"] .page,
        [data-bs-theme="dark"] .wrapper,
        [data-bs-theme="dark"] .content,
        [data-bs-theme="dark"] #kt_content_container {
            background-color: #0B0F19 !important;
            color: #F9FAFB !important;
        }

        /* Dark Left Menu / Sidebar */
        body.dark-mode #kt_aside,
        body.dark-mode .aside,
        body.dark-mode .aside.aside-dark,
        [data-bs-theme="dark"] #kt_aside,
        [data-bs-theme="dark"] .aside,
        [data-bs-theme="dark"] .aside.aside-dark {
            background-color: #111827 !important;
            border-right: 1px solid #1F2937 !important;
        }

        body.dark-mode #kt_aside_logo,
        [data-bs-theme="dark"] #kt_aside_logo {
            background-color: #111827 !important;
            border-bottom: 1px solid #1F2937 !important;
        }

        body.dark-mode #kt_aside_toggle,
        [data-bs-theme="dark"] #kt_aside_toggle {
            color: #9CA3AF !important;
        }

        body.dark-mode .aside .menu-title,
        [data-bs-theme="dark"] .aside .menu-title {
            color: #E5E7EB !important;
            font-weight: 500;
        }

        body.dark-mode .aside .menu-icon,
        body.dark-mode .aside .menu-icon i,
        body.dark-mode .aside .menu-icon .svg-icon,
        body.dark-mode .aside .menu-bullet i,
        [data-bs-theme="dark"] .aside .menu-icon,
        [data-bs-theme="dark"] .aside .menu-icon i,
        [data-bs-theme="dark"] .aside .menu-bullet i {
            color: #9CA3AF !important;
        }

        body.dark-mode .aside .menu-arrow:after,
        [data-bs-theme="dark"] .aside .menu-arrow:after {
            background-color: #6B7280 !important;
        }

        body.dark-mode .aside .menu-section,
        [data-bs-theme="dark"] .aside .menu-section {
            color: #6B7280 !important;
        }

        body.dark-mode .aside .menu-link:hover,
        [data-bs-theme="dark"] .aside .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #60A5FA !important;
        }

        body.dark-mode .aside .menu-link:hover .menu-title,
        body.dark-mode .aside .menu-link:hover .menu-icon i,
        [data-bs-theme="dark"] .aside .menu-link:hover .menu-title,
        [data-bs-theme="dark"] .aside .menu-link:hover .menu-icon i {
            color: #60A5FA !important;
        }

        body.dark-mode .aside .menu-link.active,
        body.dark-mode .aside .menu-item.here > .menu-link,
        [data-bs-theme="dark"] .aside .menu-link.active,
        [data-bs-theme="dark"] .aside .menu-item.here > .menu-link {
            background-color: rgba(37, 99, 235, 0.25) !important;
            color: #93C5FD !important;
            border-radius: 0.5rem !important;
        }

        body.dark-mode .aside .menu-link.active .menu-title,
        body.dark-mode .aside .menu-item.here > .menu-link .menu-title,
        [data-bs-theme="dark"] .aside .menu-link.active .menu-title,
        [data-bs-theme="dark"] .aside .menu-item.here > .menu-link .menu-title {
            color: #93C5FD !important;
            font-weight: 700 !important;
        }

        body.dark-mode .aside .menu-link.active .menu-icon i,
        body.dark-mode .aside .menu-link.active .menu-bullet i,
        [data-bs-theme="dark"] .aside .menu-link.active .menu-icon i,
        [data-bs-theme="dark"] .aside .menu-link.active .menu-bullet i {
            color: #93C5FD !important;
        }

        /* Dark Header */
        body.dark-mode #kt_header,
        body.dark-mode .header,
        [data-bs-theme="dark"] #kt_header,
        [data-bs-theme="dark"] .header {
            background-color: #111827 !important;
            border-bottom: 1px solid #1F2937 !important;
        }

        body.dark-mode .header-page-title,
        body.dark-mode .header h3,
        body.dark-mode #kt_header .text-light,
        [data-bs-theme="dark"] .header-page-title,
        [data-bs-theme="dark"] .header h3,
        [data-bs-theme="dark"] #kt_header .text-light {
            color: #F9FAFB !important;
        }

        body.dark-mode .topbar-item,
        body.dark-mode .topbar-item a,
        [data-bs-theme="dark"] .topbar-item,
        [data-bs-theme="dark"] .topbar-item a {
            color: #E5E7EB !important;
        }

        body.dark-mode #minimartThemeToggle,
        [data-bs-theme="dark"] #minimartThemeToggle {
            background-color: #1F2937 !important;
            border: 1px solid #374151 !important;
        }

        body.dark-mode #minimartThemeToggle i,
        body.dark-mode .theme-toggle-icon,
        [data-bs-theme="dark"] #minimartThemeToggle i,
        [data-bs-theme="dark"] .theme-toggle-icon {
            color: #F59E0B !important;
        }

        body.dark-mode #kt_toolbar,
        [data-bs-theme="dark"] #kt_toolbar {
            background-color: transparent !important;
        }

        /* Dark Cards */
        body.dark-mode .card,
        [data-bs-theme="dark"] .card {
            background-color: #111827 !important;
            border: 1px solid #1F2937 !important;
            color: #F9FAFB !important;
        }

        /* FIX ALL TEXT LABELS, HEADINGS & NUMBERS IN DARK MODE */
        body.dark-mode .text-gray-900,
        body.dark-mode .text-gray-800,
        body.dark-mode .text-gray-700,
        body.dark-mode .text-dark,
        body.dark-mode .card-title,
        body.dark-mode .card-label,
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3,
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6,
        [data-bs-theme="dark"] .text-gray-900,
        [data-bs-theme="dark"] .text-gray-800,
        [data-bs-theme="dark"] .text-gray-700,
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] .card-title,
        [data-bs-theme="dark"] .card-label,
        [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2,
        [data-bs-theme="dark"] h3, [data-bs-theme="dark"] h4,
        [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6 {
            color: #F9FAFB !important;
        }

        body.dark-mode .fs-2hx,
        [data-bs-theme="dark"] .fs-2hx {
            color: #FFFFFF !important;
        }

        body.dark-mode .text-muted,
        body.dark-mode .text-gray-600,
        body.dark-mode .text-gray-500,
        body.dark-mode .text-gray-400,
        [data-bs-theme="dark"] .text-muted,
        [data-bs-theme="dark"] .text-gray-600,
        [data-bs-theme="dark"] .text-gray-500,
        [data-bs-theme="dark"] .text-gray-400 {
            color: #9CA3AF !important;
        }

        /* Dark Tables */
        body.dark-mode .table,
        [data-bs-theme="dark"] .table {
            color: #E5E7EB !important;
            border-color: #1F2937 !important;
        }

        body.dark-mode .table th,
        [data-bs-theme="dark"] .table th {
            background-color: #1F2937 !important;
            color: #9CA3AF !important;
            border-bottom: 2px solid #374151 !important;
        }

        body.dark-mode .table td,
        [data-bs-theme="dark"] .table td {
            color: #E5E7EB !important;
            border-bottom: 1px solid #1F2937 !important;
        }

        body.dark-mode .table tbody tr:hover,
        [data-bs-theme="dark"] .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03) !important;
        }

        body.dark-mode .table a,
        [data-bs-theme="dark"] .table a {
            color: #F9FAFB !important;
        }

        /* Dark Timeline & Activity */
        body.dark-mode .timeline-content,
        [data-bs-theme="dark"] .timeline-content {
            color: #E5E7EB !important;
        }

        body.dark-mode .timeline-content a,
        [data-bs-theme="dark"] .timeline-content a {
            color: #60A5FA !important;
        }

        body.dark-mode .timeline-label,
        [data-bs-theme="dark"] .timeline-label {
            color: #9CA3AF !important;
        }

        body.dark-mode .list-group-item,
        [data-bs-theme="dark"] .list-group-item {
            background-color: #111827 !important;
            border-color: #1F2937 !important;
            color: #E5E7EB !important;
        }

        /* Dark Dropdowns & Menus */
        body.dark-mode .menu-sub-dropdown,
        body.dark-mode .dropdown-menu,
        [data-bs-theme="dark"] .menu-sub-dropdown,
        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #111827 !important;
            border: 1px solid #1F2937 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
        }

        body.dark-mode .menu-sub-dropdown .menu-link,
        body.dark-mode .dropdown-menu .dropdown-item,
        [data-bs-theme="dark"] .menu-sub-dropdown .menu-link,
        [data-bs-theme="dark"] .dropdown-menu .dropdown-item {
            color: #E5E7EB !important;
        }

        body.dark-mode .menu-sub-dropdown .menu-link:hover,
        body.dark-mode .dropdown-menu .dropdown-item:hover,
        [data-bs-theme="dark"] .menu-sub-dropdown .menu-link:hover,
        [data-bs-theme="dark"] .dropdown-menu .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.06) !important;
            color: #60A5FA !important;
        }

        body.dark-mode .separator,
        [data-bs-theme="dark"] .separator {
            border-color: #1F2937 !important;
        }

        /* Dark Form Controls */
        body.dark-mode .form-control,
        body.dark-mode .form-select,
        body.dark-mode input:not([type="checkbox"]):not([type="radio"]),
        body.dark-mode select,
        body.dark-mode textarea,
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select,
        [data-bs-theme="dark"] input:not([type="checkbox"]):not([type="radio"]),
        [data-bs-theme="dark"] select,
        [data-bs-theme="dark"] textarea {
            background-color: #1F2937 !important;
            border: 1px solid #374151 !important;
            color: #F9FAFB !important;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus,
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #1F2937 !important;
            border-color: #3B82F6 !important;
            color: #F9FAFB !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
        }

        body.dark-mode ::placeholder,
        [data-bs-theme="dark"] ::placeholder {
            color: #6B7280 !important;
        }

        /* Soft badges in dark mode */
        body.dark-mode .badge-light-success, [data-bs-theme="dark"] .badge-light-success {
            background-color: rgba(34, 197, 94, 0.2) !important;
            color: #4ADE80 !important;
        }
        body.dark-mode .badge-light-warning, [data-bs-theme="dark"] .badge-light-warning {
            background-color: rgba(245, 158, 11, 0.2) !important;
            color: #FBBF24 !important;
        }
        body.dark-mode .badge-light-danger, [data-bs-theme="dark"] .badge-light-danger {
            background-color: rgba(239, 68, 68, 0.2) !important;
            color: #F87171 !important;
        }
        body.dark-mode .badge-light-primary, [data-bs-theme="dark"] .badge-light-primary {
            background-color: rgba(59, 130, 246, 0.2) !important;
            color: #93C5FD !important;
        }
        body.dark-mode .badge-light-info, [data-bs-theme="dark"] .badge-light-info {
            background-color: rgba(6, 182, 212, 0.2) !important;
            color: #67E8F9 !important;
        }

        /* Modernized Soft Avatar / Icon Containers */
        body.dark-mode .bg-light-primary, [data-bs-theme="dark"] .bg-light-primary {
            background-color: rgba(37, 99, 235, 0.18) !important;
        }
        body.dark-mode .bg-light-info, [data-bs-theme="dark"] .bg-light-info {
            background-color: rgba(6, 182, 212, 0.18) !important;
        }
        body.dark-mode .bg-light-success, [data-bs-theme="dark"] .bg-light-success {
            background-color: rgba(34, 197, 94, 0.18) !important;
        }

        /* Card Modernization */
        .card-hover, .card {
            border-radius: 0.85rem !important;
            border: 1px solid var(--mm-border) !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -6px rgba(37, 99, 235, 0.12) !important;
        }

        /* Modern Button System */
        .btn-primary, .btn-mm-primary {
            background-color: var(--mm-primary) !important;
            border-color: var(--mm-primary) !important;
            color: #FFFFFF !important;
            font-weight: 600;
            border-radius: 0.6rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }
        .btn-primary:hover, .btn-mm-primary:hover {
            background-color: var(--mm-primary-dark) !important;
            border-color: var(--mm-primary-dark) !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary, .btn-mm-secondary {
            background-color: #F1F5F9 !important;
            border-color: #E2E8F0 !important;
            color: #475569 !important;
            font-weight: 600;
            border-radius: 0.6rem;
        }

        /* Table Modernization */
        .table th {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: var(--mm-text-secondary) !important;
            border-bottom: 2px solid var(--mm-border) !important;
        }
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: rgba(37, 99, 235, 0.03) !important;
        }

        /* Status Badges */
        .badge-success, .badge-light-success {
            background-color: rgba(34, 197, 94, 0.12) !important;
            color: #15803D !important;
            font-weight: 700;
            border-radius: 20px;
            padding: 0.35rem 0.75rem;
        }
        .badge-warning, .badge-light-warning {
            background-color: rgba(245, 158, 11, 0.12) !important;
            color: #B45309 !important;
            font-weight: 700;
            border-radius: 20px;
            padding: 0.35rem 0.75rem;
        }
        .badge-danger, .badge-light-danger {
            background-color: rgba(239, 68, 68, 0.12) !important;
            color: #B91C1C !important;
            font-weight: 700;
            border-radius: 20px;
            padding: 0.35rem 0.75rem;
        }
        .badge-primary, .badge-light-primary {
            background-color: rgba(37, 99, 235, 0.12) !important;
            color: #1D4ED8 !important;
            font-weight: 700;
            border-radius: 20px;
            padding: 0.35rem 0.75rem;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: 0.6rem !important;
            border: 1px solid var(--mm-border) !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--mm-primary) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
    </style>
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

    {{ module_vite('build-base', 'resources/assets/js/themeColor.js') }}
    <!--begin::Main-->

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid page" id="main_page_wrapper_area">

            <!--begin::Aside-->
            @include('base::layouts.partials.mt-sidebar')
            <!--end::Aside-->

            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('base::layouts.partials.mt-header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    <!--begin::Subheader Toolbar -->
                    <div class="toolbar" id="kt_toolbar">

                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">

                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center me-3 flex-wrap lh-1">

                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center text-gray-900 fw-bold my-1 fs-3">
                                    @yield('page-sub-title')</h1>
                                <!--end::Title-->

                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start mx-4"></span>
                                <!--end::Separator-->

                                <!--begin::Breadcrumb-->
                                @include('base::layouts.partials.mt-breadcrumbs')
                                <!--end::Breadcrumb-->

                            </div>
                            <!--end::Page title-->

                        </div>
                        <!--end::Container-->

                    </div>
                    <!--end::Subheader Toolbar -->

                    <!--begin::Entry-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">


                        <div id="kt_content_container" class="container-fluid">
                            @if(session()->has('success'))
                                <div class="alert alert-custom alert-success alert-light-success d-flex flex-column flex-sm-row w-100 p-5 mb-10 fade show"
                                    role="alert">
                                    <!-- <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
                                    <div class="alert-text">{{ session()->get('success') }}</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                        </button>
                                    </div> -->
                                    <i class="ki-duotone ki-notification-bing fs-2hx text-success me-4 mb-5 mb-sm-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="d-flex flex-column justify-content-center text-light pe-0 pe-sm-10">
                                        <h4 class="mb-2 light">{{ session()->get('success') }}</h4>
                                    </div>
                                    <button type="button"
                                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                        data-bs-dismiss="alert">
                                        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </button>
                                </div>
                            @endif

                            @if(session()->has('message'))
                                <div class="alert alert-custom alert-dark alert-light-dark d-flex flex-column flex-sm-row w-100 p-5 mb-10 fade show"
                                    role="alert">
                                    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
                                    <script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
                                    <script
                                        src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.9/adapters/jquery.js"></script>
                                    s="alert alert-custom alert-info alert-light-info d-flex flex-column flex-sm-row w-100
                                    p-5 mb-10 fade show" role="alert">
                                    <!-- <div class="alert-icon"><i class="flaticon-information"></i></div>
                                    <div class="alert-text">{{ session()->get('message') }}</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                        </button>
                                    </div> -->
                                    <i class="ki-duotone ki-notification-bing fs-2hx text-info me-4 mb-5 mb-sm-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="d-flex flex-column justify-content-center text-light pe-0 pe-sm-10">
                                        <h4 class="mb-2 light">{{ session()->get('message') }}</h4>
                                    </div>
                                    <button type="button"
                                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                        data-bs-dismiss="alert">
                                        <i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </button>
                                </div>
                            @endif

                            @if(session()->has('error'))
                                <div class="alert alert-custom alert-danger alert-light-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10 fade show"
                                    role="alert">
                                    <!-- <div class="alert-icon"><i class="flaticon2-warning"></i></div>
                                    <div class="alert-text">{{ session()->get('error') }}</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                        </button>
                                    </div> -->
                                    <i class="ki-duotone ki-notification-bing fs-2hx text-danger me-4 mb-5 mb-sm-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="d-flex flex-column justify-content-center text-light pe-0 pe-sm-10">
                                        <h4 class="mb-2 light">{{ session()->get('error') }}</h4>
                                    </div>
                                    <button type="button"
                                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                        data-bs-dismiss="alert">
                                        <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-custom alert-danger alert-light-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10 fade show"
                                    role="alert">
                                    <!-- <div class="alert-icon"><i class="flaticon2-warning"></i></div>
                                    <div class="alert-text">
                                        <ul class="list-unstyled">
                                            {!! implode('', $errors->all('<li><span>:message</span></li>')) !!}
                                        </ul>
                                    </div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                        </button>
                                    </div> -->
                                    <i class="ki-duotone ki-notification-bing fs-2hx text-danger me-4 mb-5 mb-sm-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="d-flex flex-column justify-content-center text-light pe-0 pe-sm-10">
                                        <h4 class="mb-2 light">{!! implode('', $errors->all('<span>:message</span>')) !!}
                                        </h4>
                                    </div>
                                    <button type="button"
                                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                        data-bs-dismiss="alert">
                                        <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </button>
                                </div>
                            @endif

                            <div class="custom_alert_trigger_messages_area">

                            </div>

                            @yield('content')

                        </div>

                    </div>
                    <!--end::Entry-->

                </div>
                <!--end::Content-->

                @yield('content-before-footer')

                <!--begin::Footer-->
                @include('base::layouts.partials.mt-footer')
                <!--end::Footer-->

            </div>
            <!--end::Wrapper-->


        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "{{ url('/') }}";
    </script>
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#8950FC",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('build-base/ktmt/plugins/global/plugins.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('build-base/ktmt/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('build-base/ktmt/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    {{--
    <script src="{{ asset('build-base/ktmt/js/.bundle.js') }}"></script>--}}
    <script src="{{ asset('build-base/ktmt/js/scripts.bundle.js') }}"></script>

    {{-- Laravel Vite - JS File --}}
    {{ module_vite('build-base', 'resources/assets/js/app.js') }}
    @yield('custom-js-section')

    <!--end::Custom Javascript-->
    <!--end::Javascript-->

</body>
<script>
    // $(document).ready(function () {
    //     function highlightActiveMenuItem() {
    //         var currentUrl = window.location.href;

    //         $(".menu-link").each(function () {
    //             var menuItemUrl = $(this).attr("href");

    //             $(this).removeClass('active');

    //             if (currentUrl === menuItemUrl) {
    //                 $(this).addClass('active');
    //             }
    //         });
    //     }

    //     highlightActiveMenuItem();
    // });

    $(document).ready(function () {
        function highlightActiveMenuItem() {
            var currentUrl = window.location.href;

            $(".menu-link").each(function () {
                var menuItemUrl = $(this).attr("href");

                // Check if the current URL matches the menu item
                if (currentUrl === menuItemUrl) {
                    $(this).addClass('active');

                    // Add 'show' class to open the parent submenu and 'active' class to parent menu
                    $(this).closest(".menu-sub-accordion").addClass('show');
                    $(this).closest(".menu-accordion").addClass('here show');
                } else {
                    $(this).removeClass('active');
                }
            });
        }

        highlightActiveMenuItem();

        // Unified Theme toggle handler for MiniMart
        function applyTheme(theme) {
            if (theme === 'dark') {
                $('html').attr('data-bs-theme', 'dark');
                $('body').addClass('dark-mode');
                localStorage.setItem('mm-theme', 'dark');
                localStorage.setItem('data-bs-theme', 'dark');
                $('#minimartThemeToggle i').removeClass('ki-night-day').addClass('ki-sun');
            } else {
                $('html').attr('data-bs-theme', 'light');
                $('body').removeClass('dark-mode');
                localStorage.setItem('mm-theme', 'light');
                localStorage.setItem('data-bs-theme', 'light');
                $('#minimartThemeToggle i').removeClass('ki-sun').addClass('ki-night-day');
            }
        }

        $('#minimartThemeToggle').on('click', function () {
            var isDark = $('body').hasClass('dark-mode') || $('html').attr('data-bs-theme') === 'dark';
            applyTheme(isDark ? 'light' : 'dark');
        });

        // Initialize from preference
        var savedTheme = localStorage.getItem('mm-theme') || localStorage.getItem('data-bs-theme') || 'light';
        applyTheme(savedTheme);
    });
</script>

</html>