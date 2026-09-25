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

