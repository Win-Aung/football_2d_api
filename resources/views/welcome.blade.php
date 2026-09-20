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
    <div class="modal fade" id="paymentSettingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">ငွေပေးချေမှု အချက်အလက်များ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentSettingsForm">
                        <div class="mb-3 text-center">
                            <img id="previewQr" src="" alt="QR Code" class="img-fluid mb-2" style="max-height: 200px; display: none;">
                            <input type="text" class="form-control" id="qrUrlInput" name="qrUrl" placeholder="QR Image URL ထည့်ရန်">
                        </div>
                        <div class="mb-3">
                            <label for="phoneInput" class="form-label">လက်ခံမည့် ဖုန်းနံပါတ်</label>
                            <input type="text" class="form-control" id="phoneInput" name="phone" placeholder="ဥပမာ - 09xxxxxxxxx">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="savePaymentSettings()">သိမ်းမည်</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar p-3 d-flex flex-column justify-content-between" id="appSidebar">
        <div>
            <div class="d-flex align-items-center justify-content-between mb-4 px-2">
                <h4 class="text-white m-0 fs-5"><i class="fa-solid fa-gauge me-2 text-danger"></i> Admin Panel</h4>
                <button class="btn btn-sm text-white d-lg-none" onclick="toggleSidebar()"><i class="fa-solid fa-xmark fs-5"></i></button>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="switchTab('home', event)"><i class="fa-solid fa-home me-2"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="switchTab('users', event)"><i class="fa-solid fa-users me-2"></i> Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="2d-user-bets" onclick="switchTab('twodbets', event)"><i class="fa-solid fa-dice me-2"></i> 2D User Bets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="switchTab('football', event)"><i class="fa-solid fa-futbol me-2"></i> ဘောပွဲ</a>
                </li>
            </ul>
        </div>
        <div class="pt-3 border-top border-secondary">
            <button class="btn btn-outline-light w-100 btn-sm py-2" onclick="logout()"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 px-4 py-3 rounded-3">
            <div class="container-fluid px-0">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light me-3 d-lg-none" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                    <span class="navbar-brand mb-0 h1 fs-5 fw-bold text-dark" id="current-tab-title">Dashboard Home</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm px-3" onclick="toggleDarkMode()"><i class="fa-solid fa-moon me-1" id="darkModeIcon"></i> Dark</button>
                    <button class="btn btn-outline-secondary btn-sm px-3" onclick="openTimerSettings()"><i class="fa-solid fa-clock me-1"></i> Timer</button>
                    <button class="btn btn-outline-secondary btn-sm px-3" onclick="openPaymentSettings()"><i class="fa-solid fa-qrcode me-1"></i> Payment</button>
                </div>
            </div>
        </nav>

        <!-- Timer Settings Modal -->
        <div class="modal fade" id="timerSettingsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header text-white px-4 py-3" style="background-color: #6f42c1;">
                        <h5 class="modal-title fw-bold fs-5 d-flex align-items-center">
                            <i class="fa-solid fa-clock text-warning me-2 fs-4"></i> အချိန် (Timer) သတ်မှတ်ရန်
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-light">
                        <form id="timerSettingsForm">
                            <!-- Duration (Hours, Minutes, Seconds) Clock Timepicker Style -->
                            <div class="mb-4 text-center bg-white p-3 rounded-3 shadow-sm border">
                                <label class="form-label fw-bold text-secondary mb-2 d-flex align-items-center justify-content-center gap-1">
                                    <i class="fa-solid fa-stopwatch text-purple"></i> Duration (နာရီ၊ မိနစ်၊ စက္ကန့်)
                                </label>
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <div class="input-group shadow-sm rounded" style="max-width: 280px; border: 1px solid #dcd6f7;">
                                        <span class="input-group-text bg-white text-purple border-0 px-2 fs-5">
                                            <i class="fa-regular fa-clock"></i>
                                        </span>
                                        <!-- နာရီ (Hours) -->
                                        <input type="number" class="form-control text-center fw-bold fs-5 border-0 p-1" id="durationHours" placeholder="00" min="0" style="color: #6f42c1; background-color: #f8f4ff;" title="နာရီ">
                                        <span class="input-group-text bg-transparent border-0 px-0 text-muted">:</span>
                                        <!-- မိနစ် (Minutes) -->
                                        <input type="number" class="form-control text-center fw-bold fs-5 border-0 p-1" id="durationMinutes" placeholder="05" min="0" max="59" style="color: #6f42c1; background-color: #f8f4ff;" title="မိနစ်">
                                        <span class="input-group-text bg-transparent border-0 px-0 text-muted">:</span>
                                        <!-- စက္ကန့် (Seconds) -->
                                        <input type="number" class="form-control text-center fw-bold fs-5 border-0 p-1" id="durationSeconds" placeholder="00" min="0" max="59" style="color: #6f42c1; background-color: #f8f4ff;" title="စက္ကန့်">
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block" style="font-size: 12px;">နာရီ၊ မိနစ် နှင့် စက္ကန့်များကို လိုအပ်သလို အတိအကျ ချိန်ညှိပါ။</small>
                            </div>

                            <!-- End Time Section -->
                            <div class="mb-2 bg-white p-3 rounded-3 shadow-sm border">
                                <label for="endTimeInput" class="form-label fw-bold text-secondary mb-2 d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-calendar-days text-purple"></i> End Time (ပြီးဆုံးမည့်အချိန်)
                                </label>
                                <input type="datetime-local" class="form-control shadow-sm border-0 bg-light py-2" id="endTimeInput" name="endTime">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0 bg-white px-4 py-3">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold rounded-pill" data-bs-dismiss="modal">ပိတ်မည်</button>
                        <button type="button" class="btn btn-sm px-4 fw-bold text-white rounded-pill shadow-sm" style="background-color: #6f42c1;" onclick="saveTimerSettings()">သိမ်းမည်</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Home Tab -->
        <div id="home-tab" class="tab-content-section active">
            <div class="row">
                <!-- 📅 ဒိုင်၏ နေ့စဥ် အနိုင် / အရှုံး စာရင်း Card -->
                <div class="col-xl-6 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="background-color: #eff6ff;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-6 mb-3 text-primary">
                                <i class="fa-solid fa-calendar-day me-2"></i> 📅 ဒိုင်၏ နေ့စဥ် အနိုင် / အရှုံး စာရင်း
                            </h5>
                            <hr class="text-muted opacity-25">
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>User တွေ နိုင်ငွေပေါင်း:</span> <strong id="daily-win">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>User တွေ ရှုံးငွေပေါင်း:</span> <strong id="daily-loss">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>ငွေသွင်း (Deposit):</span> <strong class="text-success" id="daily-deposit">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>ငွေထုတ် (Withdraw):</span> <strong class="text-warning" id="daily-withdraw">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 mt-2"><span>ဒိုင်အသားတင် (Net):</span> <strong id="daily-net">0 ကျပ်</strong></div>
                        </div>
                    </div>
                </div>

                <!-- 🗓️ ဒိုင်၏ လစဥ် အနိုင် / အရှုံး စာရင်း Card -->
                <div class="col-xl-6 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="background-color: #faf5ff;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title fw-bold fs-6 m-0 text-purple" style="color: #6f42c1;">
                                    <i class="fa-solid fa-calendar-days me-2"></i> 🗓️ ဒိုင်၏ လစဥ် အနိုင် / အရှုံး စာရင်း
                                </h5>
                                <!-- 🟢 လအလိုက် ရွေးချယ်ရန် Dropdown -->
                                <div>
                                    <select id="monthlyDropdown" class="form-select form-select-sm fw-bold text-purple border-purple shadow-sm" style="width: 140px; background-color: #f3e8ff; color: #6f42c1;" onchange="onMonthlyDropdownChange()">
                                        <!-- JavaScript ဖြင့် လများကို အလိုအလျောက် ထည့်သွင်းပေးပါမည် -->
                                    </select>
                                </div>
                            </div>
                            <hr class="text-muted opacity-25">
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>User တွေ နိုင်ငွေပေါင်း:</span> <strong id="monthly-win">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>User တွေ ရှုံးငွေပေါင်း:</span> <strong id="monthly-loss">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>ငွေသွင်း (Deposit):</span> <strong class="text-success" id="monthly-deposit">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 border-bottom"><span>ငွေထုတ် (Withdraw):</span> <strong class="text-warning" id="monthly-withdraw">0 ကျပ်</strong></div>
                            <div class="d-flex justify-content-between py-1 mt-2"><span>ဒိုင်အသားတင် (Net):</span> <strong id="monthly-net">0 ကျပ်</strong></div>
                        </div>
                    </div>
                </div>
        </div>

            <!-- Pending Requests Table -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">🔔 အတည်ပြုရန် ကျန်ရှိနေသော ငွေသွင်း/ငွေထုတ် တောင်းဆိုမှုများ (Pending Vouchers)</h5>
                    <span class="badge bg-warning text-dark" id="pending-count">0</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="pending-requests-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Transaction ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="pending-requests-tbody">
                                <!-- Dynamic rows via admin-script.js -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Approve Deposit Modal -->
                <div class="modal fade" id="approveDepositModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">ငွေသွင်းအတည်ပြုရန်</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="approveRequestId">
                                <div class="mb-3">
                                    <label class="form-label text-muted">ငွေဖြည့်ထားသော ပမာဏ (Amount)</label>
                                    <!-- ပြင်ခွင့်မပေးရန် readonly ထည့်ထားသည် -->
                                    <input type="text" class="form-control fw-bold text-success" id="approveAmountDisplay" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="approveTransactionId" class="form-label">Transaction ID ထည့်ရန်</label>
                                    <input type="text" class="form-control" id="approveTransactionId" placeholder="Transaction ID ရိုက်ထည့်ပါ">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="confirmApproveDeposit()">အတည်ပြုမည်</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Customer Service Chat Box Section -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center" style="background-color: #6f42c1;">
                    <h5 class="mb-0 fs-6 fw-bold">
                        <i class="fa-solid fa-headset me-2"></i> User များနှင့် တိုက်ရိုက်ပြောဆိုရန် Chat Box
                    </h5>
                    <span class="badge bg-light text-dark" id="activeChatUserLabel">User ရွေးချယ်ပါ</span>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0" style="height: 400px;">
                        <!-- ဘယ်ဘက်ခြမ်း - User များ စာရင်း -->
                        <div class="col-md-4 border-end overflow-auto bg-light" id="adminChatUserList" style="height: 100%;">
                            <div class="p-2 border-bottom fw-bold text-muted small">စကားပြောထားသော User များ</div>
                            <!-- Dynamic User List များကို JavaScript ဖြင့် အောက်ပါ ပုံစံအတိုင်း ထည့်သွင်းပေးပါ -->
                             <span class="badge bg-danger rounded-pill" id="totalUnreadBadge" style="display: none;">0</span>
                        </div>
                        
                        <!-- ညာဘက်ခြမ်း - Chat Message ပုံစံ -->
                        <div class="col-md-8 d-flex flex-column" style="height: 100%;">
                            <!-- မက်ဆေ့ဂျ်များပြမည့် နေရာ -->
                            <div class="flex-grow-1 p-3 overflow-auto bg-white" id="adminChatBox" style="height: calc(100% - 60px);">
                                <div class="text-center text-muted mt-5">ကျေးဇူးပြု၍ ဘယ်ဘက်မှ User တစ်ဦးကို ရွေးချယ်ပါ။</div>
                            </div>
                            
                            <!-- စာပို့ရန် Input Area -->
                            <div class="p-2 border-top bg-light">
                                <form id="adminChatForm" class="input-group" onsubmit="sendAdminMessage(event)">
                                    <input type="text" id="adminChatInput" class="form-control" placeholder="စာပြန်ရန် ရေးသားပါ..." required disabled>
                                    <button class="btn btn-purple text-white" type="submit" id="adminSendBtn" style="background-color: #6f42c1;" disabled>
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- 2. Users Tab -->
        <div id="users-tab" class="tab-content-section">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <h5 class="card-title fw-bold text-dark m-0">
                            <i class="fa-solid fa-users-gear text-primary me-2"></i> Registered Users List & Balances
                        </h5>
                        <!-- Search Bar -->
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                            <input type="text" id="userSearchInput" class="form-control form-control-sm border-start-0 bg-light" placeholder="နာမည် သို့မဟုတ် ဖုန်းဖြင့် ရှာရန်...">
                        </div>
                    </div>
                    
                    <!-- Users Sub-tabs Navigation -->
                    <ul class="nav nav-tabs mb-3" id="usersTabNav" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="users-list-subtab" data-bs-toggle="tab" data-bs-target="#users-list-content" type="button">👥 User စာရင်းများ</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="users-payment-subtab" data-bs-toggle="tab" data-bs-target="#users-payment-content" type="button">💳 Payment</button>
                        </li>
                    </ul>

                    <!-- Sub-tabs Content Area -->
                    <div class="tab-content p-3 bg-white border border-top-0 rounded-bottom shadow-sm">
                        <!-- 1st Sub-tab: Users List -->
                        <div class="tab-pane fade show active" id="users-list-content">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="usersTable">
                                    <thead class="table-light text-secondary text-uppercase fs-7">
                                        <tr>
                                            <th class="py-3 px-3">အမည် (Name)</th>
                                            <th class="py-3 px-3">ဖုန်းနံပါတ် (Phone)</th>
                                            <th class="py-3 px-3">ငွေလက်ခံသည့် ပုံစံ (Payment)</th>
                                            <th class="py-3 px-3">လက်ကျန်ငွေ (Balance)</th>
                                            <th class="py-3 px-3 text-center" style="width: 180px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-table-body">
                                        @forelse($users as $user)
                                            <tr>
                                                <td class="py-3 px-3 fw-bold text-dark">
                                                    {{ $user->name ?? 'အမည်မရှိ (Admin)' }}
                                                </td>
                                                <td class="py-3 px-3 text-muted">{{ $user->phone ?? '-' }}</td>
                                                <td class="py-3 px-3">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 fw-semibold">
                                                        {{ $user->payment ?? 'KBZPay' }}
                                                    </span>
                                                </td>
                                                
                                                <td class="py-3 px-3 fw-bold text-success">
                                                    {{ number_format($user->balance ?? 0) }} ကျပ်
                                                </td>
                                                <td class="py-3 px-3 text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-sm btn-primary px-2 py-1" onclick="editUser({{ $user->id }})">
                                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger px-2 py-1" onclick="deleteUserConfirm({{ $user->id }})">
                                                            <i class="fa-solid fa-trash me-1"></i> Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    <i class="fa-solid fa-folder-open fs-3 mb-2 d-block text-secondary opacity-50"></i>
                                                    မှတ်ပုံတင်ထားသော User များ မရှိသေးပါ။
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 2nd Sub-tab: Payment -->
                        <div class="tab-pane fade" id="users-payment-content">
                            <div class="py-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                                    <h6 class="fw-bold mb-0 text-dark">
                                        <i class="fa-solid fa-receipt text-primary me-2"></i> ငွေပေးချေမှု တောင်းဆိုချက်များ (Payment Requests)
                                    </h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Search Bar -->
                                        <div class="input-group input-group-sm" style="max-width: 250px;">
                                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                                            <input type="text" id="paymentSearchInput" class="form-control form-control-sm border-start-0 bg-light" placeholder="နာမည် သို့မဟုတ် ဖုန်းဖြင့် ရှာရန်...">
                                        </div>
                                        <!-- Delete Selected Button -->
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedPaymentRequests()">
                                            <i class="fa-solid fa-trash me-1"></i> ရွေးချယ်ထားသမျှ ဖျက်မည်
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive border rounded-3 bg-white shadow-sm">
                                    <table class="table table-hover align-middle mb-0" id="paymentRequestsTable">
                                        <thead class="table-light text-secondary text-uppercase fs-7">
                                            <tr>
                                                <th class="py-3 px-3" style="width: 40px;">
                                                    <input type="checkbox" class="form-check-input" id="selectAllPaymentCheckbox" onclick="toggleSelectAllPayments(this)">
                                                </th>
                                                <th class="py-3 px-3">ID</th>
                                                <th class="py-3 px-3">User Name</th>
                                                <th class="py-3 px-3">Phone</th>
                                                <th class="py-3 px-3">Type</th>
                                                <th class="py-3 px-3">Amount</th>
                                                <th class="py-3 px-3">Payment</th>
                                                <th class="py-3 px-3">Transaction ID</th>
                                                <th class="py-3 px-3">Status</th>
                                                <th class="py-3 px-3">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody id="payment-requests-table-body">
                                            <!-- Dynamic Data -->
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination Container -->
                                <div id="paymentPaginationContainer" class="d-flex justify-content-between align-items-center mt-3 pt-2"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Search Function Script -->
        <script>
            document.getElementById('userSearchInput')?.addEventListener('keyup', function() {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#users-table-body tr');
                
                rows.forEach(row => {
                    let text = row.innerText.toLowerCase();
                    if(text.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">User အချက်အလက် ပြင်ဆင်ရန်</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            <input type="hidden" id="editUserId">
                            <div class="mb-3">
                                <label for="editUserName" class="form-label">အမည် (Name)</label>
                                <input type="text" class="form-control" id="editUserName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserPhone" class="form-label">ဖုန်းနံပါတ် (Phone)</label>
                                <input type="text" class="form-control" id="editUserPhone">
                            </div>
                            <div class="mb-3">
                                <label for="editUserPayment" class="form-label">ငွေပေးချေသည့် ပုံစံ (Payment)</label>
                                <select class="form-control" id="editUserPayment">
                                    <option value="KBZPay">KBZPay</option>
                                    <option value="AYA Pay">AYA Pay</option>
                                    <option value="Wave Money">Wave Money</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editUserBalance" class="form-label">လက်ကျန်ငွေ (Balance)</label>
                                <input type="number" class="form-control" id="editUserBalance">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="updateUser()">အပြောင်းအလဲ သိမ်းမည်</button>
                    </div>
                </div>
            </div>
        </div>

                <!-- 3. 2D User Bets Tab -->
                <div id="twodbets-tab" class="tab-content-section">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-6 mb-3">🎰 2D User Bets စာရင်းများ</h5>
                            
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                                <div class="input-group input-group-sm w-auto">
                                    <select id="selectSessionName" class="form-select form-select-sm">
                                        <option value="11:00 AM">11:00 AM Session</option>
                                        <option value="12:00 PM">12:00 PM Session</option>
                                        <option value="3:00 PM">3:00 PM Session</option>
                                        <option value="4:30 PM">4:30 PM Session</option>
                                    </select>
                                    <button type="button" class="btn btn-outline-primary px-3" onclick="load2DSessionSettings()">
                                        <i class="fa-solid fa-clock-rotate-left me-1"></i> စကက်ကျူး သတ်မှတ်ရန်
                                    </button>
                                    <button type="button" class="btn btn-success px-3" onclick="openTwoDAnnounceModal()">
                                        <i class="fa-solid fa-bullhorn me-1"></i> 2D ဂဏန်းကြေငြာရန်
                                    </button>
                                </div>

                                <!-- 11:00 AM Session Switch -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="session_1100" onchange="updateSessionOpenStatus('11:00 AM', this.checked ? 1 : 0)">
                                    <label class="form-check-label" for="session_1100">11:00 AM ဖွင့်/ပိတ်</label>
                                </div>

                                <!-- 12:00 PM Session Switch -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="session_1200" onchange="updateSessionOpenStatus('12:00 PM', this.checked ? 1 : 0)">
                                    <label class="form-check-label" for="session_1200">12:00 PM ဖွင့်/ပိတ်</label>
                                </div>

                                <!-- 3:00 PM Session Switch -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="session_0300" onchange="updateSessionOpenStatus('3:00 PM', this.checked ? 1 : 0)">
                                    <label class="form-check-label" for="session_0300">3:00 PM ဖွင့်/ပိတ်</label>
                                </div>

                                <!-- 4:30 PM Session Switch -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="session_0430" onchange="updateSessionOpenStatus('4:30 PM', this.checked ? 1 : 0)">
                                    <label class="form-check-label" for="session_0430">4:30 PM ဖွင့်/ပိတ်</label>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <!-- ဂဏန်း သို့မဟုတ် အမည်ဖြင့် ရှာရန် Search Input -->
                                    <div class="input-group input-group-sm" style="max-width: 250px;">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                                        <input type="text" id="twodBetSearchInput" class="form-control form-control-sm border-start-0 bg-light" placeholder="ဂဏန်း သို့မဟုတ် အမည်ဖြင့် ရှာရန်...">
                                    </div>
                                    <!-- ရွေးချယ်ထားသမျှ ဖျက်မည် ခလုတ် -->
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedTwoDBets()">
                                        <i class="fa-solid fa-trash me-1"></i> ရွေးချယ်ထားသမျှ ဖျက်မည်
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered align-middle" id="2d-bets-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px;" class="text-center">
                                                <input type="checkbox" class="form-check-input" id="selectAllTwoDBetsCheckbox" onclick="toggleSelectAllTwoDBets(this)">
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Amount</th>
                                            <th>Session</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="twod-bets-table-body">
                                        <!-- Data will be loaded via admin-script.js -->
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination Container -->
                            <div id="twodBetPaginationContainer" class="d-flex justify-content-between align-items-center mt-3 pt-2"></div>
                        </div>
                    </div>
                </div>
                

                <!-- 2D Session Settings Modal -->
                <div class="modal fade" id="twodSettingsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">⚙️ Session အလိုက် အချိန် စီမံရန်</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="twodSettingsForm">
                                    <!-- 🛑 ဤ Session အတွက် ထိုး၍ရရန် ဖွင့်မည်/ပိတ်မည် (Switch) ကို UI မှ ဖယ်ရှားလိုက်ပါပြီ -->
                                    <div class="mb-3">
                                        <label for="twodOpenTime" class="form-label fw-bold">ဖွင့်မည့်အချိန် (Open Time)</label>
                                        <input type="datetime-local" class="form-control" id="twodOpenTime">
                                    </div>
                                    <div class="mb-3">
                                        <label for="twodCloseTime" class="form-label fw-bold">ပိတ်မည့်အချိန် (Close Time)</label>
                                        <input type="datetime-local" class="form-control" id="twodCloseTime">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="save2DSessionSettings()">သိမ်းမည်</button>
                            </div>
                        </div>
                    </div>
                </div>
                


                <!-- 2D Announcement & Settle Modal -->
                <div class="modal fade" id="twodAnnounceModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">🎲 2D ဂဏန်းကြေငြာခြင်းနှင့် အနိုင်စစ်ဆေးရန်</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="twodAnnounceForm">
                                    <div class="mb-3">
                                        <label for="announceSession" class="form-label fw-bold">Session ရွေးရန်</label>
                                        <select class="form-select" id="announceSession" name="session" required>
                                            <option value="11:00 AM">11:00 AM</option>
                                            <option value="12:00 PM">12:00 PM</option>
                                            <option value="3:00 PM">3:00 PM</option>
                                            <option value="4:30 PM">4:30 PM</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="winningNumber" class="form-label fw-bold">ထွက်မည့် 2D ဂဏန်း (Winning Number)</label>
                                        <input type="text" class="form-control" id="winningNumber" maxlength="2" placeholder="ဥပမာ - 34" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="announceMultiplier" class="form-label fw-bold">အဆပေါင်း (Multiplier)</label>
                                        <input type="number" class="form-control" id="announceMultiplier" value="80" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                                <button type="button" class="btn btn-success btn-sm" onclick="submitTwoDAnnounce()">ကြေငြာမည် & ငွေရှင်းမည်</button>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- 4. Football Tab -->
                <div id="football-tab" class="tab-content-section">
                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                        <button class="btn btn-success btn-sm px-3" onclick="openAnnounceMatchModal()"><i class="fa-solid fa-bullhorn me-1"></i> ဘောပွဲကြေငြာရန်</button>
                        <button class="btn btn-success btn-sm px-3" onclick="openAddLeagueModal()">
                                <i class="fa-solid fa-bullhorn me-1"></i> +League နှင့် အသင်းများ ထည့်ရန်
                        </button>
                    </div>

                    <!-- ဘောပွဲကြေငြာရန် Modal -->
                    <div class="modal fade" id="announceMatchModal" tabindex="-1" aria-labelledby="announceMatchModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="announceMatchModalLabel">ဘောပွဲ ကြေငြာရန်</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="announceMatchForm">
                                        <!-- League ရွေးရန် -->
                                        <div class="mb-3">
                                            <label for="announceLeague" class="form-label">League</label>
                                            <select class="form-select" id="announceLeague" required>
                                                <option value="">League ရွေးချယ်ပါ</option>
                                            </select>
                                        </div>

                                        <!-- အိမ်ရှင်နှင့် ဧည့်သည်အသင်းများ -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="announceHomeTeam" class="form-label">အိမ်ရှင်အသင်း</label>
                                                <select class="form-select" id="announceHomeTeam" required>
                                                    <option value="">အိမ်ရှင်အသင်း ရွေးပါ</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="announceAwayTeam" class="form-label">ဧည့်သည်အသင်း</label>
                                                <select class="form-select" id="announceAwayTeam" required>
                                                    <option value="">ဧည့်သည်အသင်း ရွေးပါ</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- အိမ်ရှင်ကြေး / ဧည့်သည်ကြေး -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="announceHomeOdds" class="form-label">အိမ်ရှင်ကြေး</label>
                                                <input type="text" class="form-control" id="announceHomeOdds">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="announceAwayOdds" class="form-label">ဧည့်သည်ကြေး</label>
                                                <input type="text" class="form-control" id="announceAwayOdds">
                                            </div>
                                        </div>

                                        <!-- ဂိုးပေါင်းကြေး / Live Video Play Link -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="announceGoalTotal" class="form-label">ဂိုးပေါင်းကြေး (မထည့်လဲရ)</label>
                                                <input type="text" class="form-control" id="announceGoalTotal">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="announceVideoLink" class="form-label">Live Video Play Link များ (မထည့်လဲရ၊ တစ်ကြောင်းလျှင် တစ်ခု (သို့) ကော်မာခံရန်)</label>
                                                <textarea class="form-control" id="announceVideoLink" rows="2" placeholder="လင့်ခ်များကို အများကြီးထည့်ရန်..."></textarea>
                                            </div>
                                        </div>

                                        <!-- ဘောဒီအိမ်ရှင်ကြေး / ဘောဒီဧည့်သည်ကြေး -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="announceBodyOdds" class="form-label">ဘောဒီအိမ်ရှင်ကြေး</label>
                                                <input type="text" class="form-control" id="announceBodyOdds">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="announceBodyAwayOdds" class="form-label">ဘောဒီဧည့်သည်ကြေး</label>
                                                <input type="text" class="form-control" id="announceBodyAwayOdds">
                                            </div>
                                        </div>

                                        <!-- ဘောဒီဂိုးပေါင်းကြေး -->
                                        <div class="mb-3">
                                            <label for="announceBodyGoalTotal" class="form-label">ဘောဒီဂိုးပေါင်းကြေး (မထည့်လဲရ)</label>
                                            <input type="text" class="form-control" id="announceBodyGoalTotal">
                                        </div>

                                        <!-- Close Time -->
                                        <div class="mb-3">
                                            <label for="announceCloseTime" class="form-label">ပိတ်မည့်အချိန် (Close Time/Date)</label>
                                            <input type="datetime-local" class="form-control" id="announceCloseTime" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="submitAnnounceMatchBtn" onclick="submitAnnounceMatch()">ကြေငြာမည်</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bootstrap Modal -->
                    <div class="modal fade" id="addLeagueModal" tabindex="-1" aria-labelledby="addLeagueModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addLeagueModalLabel">League နှင့် အသင်းများ ထည့်သွင်းရန်</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
            <form id="addLeagueForm">
                    <!-- Dropdown (League များကို ရွေးချယ်ရန်) -->
                        <div class="mb-3">
                            <label for="league_name" class="form-label">League အမည် (League Name)</label>
                            <select class="form-control" id="league_name" name="league_name" required onchange="checkNewLeague(this)">                                
                                <option value="">-- League တစ်ခု ရွေးပါ (သို့) အသစ်ထည့်ရန် --</option>
                                <option value="NEW_LEAGUE">➕ League အသစ်ထည့်မည်</option>
                            </select>
                        </div>

                        <!-- League အသစ်ထည့်ရန် Text Input (မူလက ပိတ်ထားမည်) -->
                        <div class="mb-3 d-none" id="newLeagueContainer">
                            <label for="new_league_name" class="form-label">League အမည်အသစ် ရိုက်ထည့်ရန်</label>
                            <input type="text" class="form-control" id="new_league_name" placeholder="ဥပမာ - Premier League">
                        </div>

                        <!-- အသင်းများ ထည့်ရန် -->
                        <div class="mb-3">
                            <label for="teams" class="form-label">ဘောလုံးအသင်းများ (Teams - ကော်မာ , ဖြင့်ခံရန်)</label>
                            <textarea class="form-control" id="teams" name="teams" rows="3" required placeholder="Manchester United, Arsenal, Chelsea"></textarea>
                        </div>
                    
                    <div class="alert alert-danger d-none" id="leagueErrorMsg"></div>
                    <div class="alert alert-success d-none" id="leagueSuccessMsg"></div>
            </form>
        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="submitLeagueData()">သိမ်းဆည်းမည်</button>
                    </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs" id="footballTabNav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="matches-subtab" data-bs-toggle="tab" data-bs-target="#matches-content" type="button">⚽ ကြေငြာထားသော ပွဲစဉ်များ</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bets-subtab" data-bs-toggle="tab" data-bs-target="#bets-content" type="button">💰 ထိုးထားသော Bet များ</button>
                </li>
            </ul>

            <div class="tab-content p-3 bg-white border border-top-0 rounded-bottom shadow-sm">
                <div class="tab-pane fade show active" id="matches-content">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="announced-matches-table">
                            <div class="mb-3">
                    <input type="text" id="matchSearchInput" class="form-control w-25" placeholder="အသင်းအမည်ဖြင့် ရှာရန်..." onkeyup="filterMatches()">
                    </div>
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th style="background-color: #e3f2fd; color: #0d6efd;">ID</th>
                                    <th style="background-color: #e3f2fd; color: #fd0d0d;">ပိတ်ချိန်</th>
                                    <th style="background-color: #e3f2fd; color: #09fd09;">အိမ်ရှင် vs ဧည့်သည်</th>
                                    <th style="background-color: #e3f2fd; color: #fd0d55;">မောင်းဂိုးပေါင်း</th>
                                    <th style="background-color: #e3f2fd; color: #250dfd;">Bအိမ်ရှင် vs Bဧည့်သည်</th>
                                    <th style="background-color: #e3f2fd; color: #fd0d0d;">ဘော်ဒီဂိုးပေါင်း</th>
                                    <th style="background-color: #e3f2fd; color: #e10dfd;">ဘောဒီ Status</th>
                                    <th style="background-color: #e3f2fd; color: #e10dfd;">မောင်း Status</th>
                                    <th style="background-color: #e3f2fd; color: #fd0d0d;">Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                <!-- Dynamic Data -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ဘောပွဲပြင်ဆင်ရန် Modal -->
                <div class="modal fade" id="editMatchModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">ဘောပွဲ အချက်အလက် ပြင်ဆင်ရန်</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editMatchForm">
                                    <input type="hidden" id="editMatchId">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">League</label>
                                        <input type="text" class="form-control" id="editLeagueName" readonly>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">အိမ်ရှင်အသင်း</label>
                                            <input type="text" class="form-control" id="editHomeTeam" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ဧည့်သည်အသင်း</label>
                                            <input type="text" class="form-control" id="editAwayTeam" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">အိမ်ရှင်ကြေး</label>
                                            <input type="text" class="form-control" id="editHomeOdds">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ဧည့်သည်ကြေး</label>
                                            <input type="text" class="form-control" id="editAwayOdds">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">ဂိုးပေါင်းကြေး</label>
                                            <input type="text" class="form-control" id="editGoalTotal">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Live Video Play Link များ</label>
                                            <textarea class="form-control" id="editVideoLink" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">ဘောဒီအိမ်ရှင်ကြေး</label>
                                            <input type="text" class="form-control" id="editBodyOdds">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ဘောဒီဧည့်သည်ကြေး</label>
                                            <input type="text" class="form-control" id="editBodyAwayOdds">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">ဘောဒီဂိုးပေါင်းကြေး</label>
                                        <input type="text" class="form-control" id="editBodyGoalTotal">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">ပိတ်မည့်အချိန် (Close Time)</label>
                                        <input type="datetime-local" class="form-control" id="editCloseTime">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ပိတ်မည်</button>
                                <button type="button" class="btn btn-primary" onclick="submitEditMatch()">ပြင်ဆင်မည်</button>
                            </div>
                        </div>

                        
                    </div>
                </div>
                <div class="tab-pane fade" id="bets-content">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
        <div class="input-group" style="max-width: 350px;">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="betSearchQuery" class="form-control" placeholder="Bet ID (သို့) အသင်းနာမည်ဖြင့် ရှာရန်...">
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedFootballBets()">
            <i class="fa-solid fa-trash me-1"></i> ရွေးချယ်ထားသမျှ ဖျက်မည်
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;" class="text-center">
                        <input type="checkbox" class="form-check-input" id="selectAllFootballBetsCheckbox" onclick="toggleSelectAllFootballBets(this)">
                    </th>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Bet Type</th>
                    <th>ရွေးချယ်မှု (Selected Options)</th>
                    <th>စုစုပေါင်းပမာဏ</th>
                    <th>Status</th>
                    <th>အချိန်</th>
                    <th>အရေးယူဆောင်ရွက်ရန်</th>
                </tr>
            </thead>
            <tbody id="footballBetsTableBody">
                <!-- JavaScript ဖြင့် Data များကို ဤနေရာတွင် ထည့်သွင်းမည် -->
            </tbody>
        </table>
    </div>
</div>
        </div>
    </div>
</div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Admin JS -->
    <script src="{{ asset('js/admin-script.js') }}"></script>
</body>
</html>