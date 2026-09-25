<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Professional Dashboard</title>
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-style.css?v=' . time()) }}">

    <style>
        body.dark-mode {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }
        body.dark-mode .navbar, 
        body.dark-mode .card, 
        body.dark-mode .modal-content {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
            border-color: #333 !important;
        }
        body.dark-mode .table {
            color: #e0e0e0 !important;
        }
        body.dark-mode .table-light {
            background-color: #2a2a2a !important;
            color: #e0e0e0 !important;
        }
    </style>

    <!-- 🟢 မှန်ကန်သော Token Key (auth_token) ကို ထည့်သွင်းခြင်း -->
    <script>
        window.Laravel = { 
            baseUrl: "{{ url('/') }}",
            token: "{{ session('auth_token') }}" 
        };
    </script>
    <audio id="notificationSound" src="{{ url('/') }}/paymentrequest.mp3" preload="auto"></audio>
</head>

<body>

    <!-- Payment Settings Modal -->
    @include('admin.partials.modals.payment-settings')

    <!-- Sidebar Navigation -->
    @include('admin.partials.sidebar')

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navbar -->
        @include('admin.partials.navbar')

        <!-- Timer Settings Modal -->
        @include('admin.partials.modals.timer-settings')

        <!-- 1. Home Tab -->
        @include('admin.partials.tabs.home-tab')

        <!-- 2. Users Tab -->
        @include('admin.partials.tabs.users-tab')

        <!-- 3. AnimalBet Tab Section -->
        @include('admin.partials.tabs.animalbet-tab')

        <!-- 3. 2D User Bets Tab -->
        @include('admin.partials.tabs.twod-tab')

        <!-- 4. Football Tab -->
        @include('admin.partials.tabs.football-tab')

        <!-- Live Stream Tab Section -->
        @include('admin.partials.tabs.live-stream')

        <!-- Image Slider Tab Section -->
        @include('admin.partials.tabs.image-slider')
        
    </div>
</div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Admin JS -->
    <script src="{{ asset('js/admin-script.js') }}"></script>
</body>
</html>