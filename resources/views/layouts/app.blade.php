<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Product Management System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #f8f9fa;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dashboard-header {
            min-height: 140px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #fff;
        }

        .dashboard-header .subtitle {
            opacity: 0.85;
        }

        .card-stats {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #121212;
            color: white;
        }

        body.dark-mode .card {
            background-color: #1e1e1e;
            color: white;
        }

        body.dark-mode .table {
            color: white;
        }

        body.dark-mode .table-dark {
            background-color: #000;
        }

        body.dark-mode .form-control {
            background-color: #2a2a2a;
            color: white;
            border: 1px solid #555;
        }

        body.dark-mode .navbar {
            background-color: black !important;
        }
    </style>
</head>

<body>

    <!-- JavaScript ពិនិត្យ និងដាក់ Dark Mode ភ្លាមៗដើម្បីកុំឱ្យធ្លាក់ភ្នែកពេលទំព័រដំបូងកំពុង Load -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    </script>

    <!-- Navigation -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main class="container-fluid mt-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 Toast Notification -->
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    <!-- Dark Mode Event Listener Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const darkBtn = document.getElementById('darkModeBtn');

            if (darkBtn) {
                darkBtn.addEventListener('click', () => {
                    document.body.classList.toggle('dark-mode');

                    if (document.body.classList.contains('dark-mode')) {
                        localStorage.setItem('darkMode', 'enabled');
                    } else {
                        localStorage.setItem('darkMode', 'disabled');
                    }
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
