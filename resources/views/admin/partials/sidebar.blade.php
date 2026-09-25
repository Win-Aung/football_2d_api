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
                <a class="nav-link" href="#" onclick="switchTab('animalbet', event)"><i class="fa-solid fa-paw me-2"></i> AnimalBet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="switchTab('football', event)"><i class="fa-solid fa-futbol me-2"></i> ဘောပွဲ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="switchTab('livestream', event)">
                    <i class="fa-solid fa-video me-2"></i> Live Stream
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="switchTab('image-slider', event)">
                    <i class="fa-solid fa-images me-2"></i> Image Slider
                </a>
            </li>
        </ul>
    </div>
    <div class="pt-3 border-top border-secondary">
        <button class="btn btn-outline-light w-100 btn-sm py-2" onclick="logout()"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
    </div>
</nav>