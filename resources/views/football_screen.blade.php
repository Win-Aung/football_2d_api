<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ဘောပွဲစဉ်များ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f3e8ff; font-family: sans-serif; padding-bottom: 140px; }
        .bg-purple { background-color: #6f42c1 !important; }
        .text-purple { color: #6f42c1 !important; }
        .main-container { max-width: 600px; margin: 20px auto; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .match-card { background: white; border-radius: 16px; border: 1px solid rgba(111, 66, 193, 0.15); box-shadow: 0 4px 10px rgba(111, 66, 193, 0.08); margin-bottom: 12px; padding: 12px; }
        .option-btn { cursor: pointer; transition: 0.2s; border: 1px solid #dee2e6; border-radius: 10px; padding: 8px; text-align: center; background: #f8f9fa; }
        .option-btn.selected { background-color: #6f42c1 !important; color: white !important; border-color: #6f42c1 !important; }
        .option-btn.selected span { color: white !important; }
        
        /* Bottom Navigation Bar Styles */
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); display: flex; justify-content: space-around; padding: 10px 0; z-index: 1000; }
        .nav-item-custom { text-align: center; color: #6c757d; text-decoration: none; font-size: 13px; }
        .nav-item-custom.active { color: #6f42c1; font-weight: bold; }
        .nav-item-custom i { font-size: 20px; display: block; margin-bottom: 2px; }

        .fixed-submit-container {
            position: fixed;
            bottom: 60px;
            left: 0;
            right: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.95);
            padding: 10px 15px;
            box-shadow: 0 -4px 10px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="main-container">
        
        <!-- Header & History Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-purple fw-bold m-0"><i class="fa-solid fa-futbol me-1"></i> ဘောပွဲစဉ်များ</h5>
            <button class="btn btn-sm btn-purple text-white fw-bold shadow-sm" style="background-color: #6f42c1;" onclick="showHistoryModal()">
                <i class="fa-solid fa-receipt me-1"></i> လောင်းခဲ့သောပွဲများ
            </button>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-pills nav-fill mb-3 bg-light p-1 rounded-3" id="footballTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-purple" id="body-tab" data-bs-toggle="tab" data-bs-target="#body-content" type="button" role="tab">ဘော်ဒီ</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-purple" id="maung-tab" data-bs-toggle="tab" data-bs-target="#maung-content" type="button" role="tab">မောင်း</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-danger" id="live-tab" data-bs-toggle="tab" data-bs-target="#live-content" type="button" role="tab"><i class="fa-solid fa-circle-dot me-1"></i>LIVE</button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content" id="footballTabsContent">
            <!-- 1. Body Tab -->
            <div class="tab-pane fade show active" id="body-content" role="tabpanel">
                <div id="body-matches-list" class="vstack gap-3">
                    <div class="text-center py-4"><div class="spinner-border text-purple" role="status"></div></div>
                </div>
            </div>

            <!-- 2. Maung Tab -->
            <div class="tab-pane fade" id="maung-content" role="tabpanel">
                <div id="maung-matches-list" class="vstack gap-3">
                    <div class="text-center py-4"><div class="spinner-border text-purple" role="status"></div></div>
                </div>
            </div>

            <!-- 3. LIVE Tab -->
            <div class="tab-pane fade" id="live-content" role="tabpanel">
                <!-- League Dropdown Filter for Live Tab -->
                <div class="mb-3">
                    <select id="live-league-filter" class="form-select form-select-sm fw-bold text-purple border-purple" onchange="renderMatches()">
                        <option value="all">လိဂ်အားလုံး (All Leagues)</option>
                    </select>
                </div>
                <div id="live-matches-list" class="vstack gap-3">
                    <div class="text-center py-4"><div class="spinner-border text-danger" role="status"></div></div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Fixed Submit Buttons Container -->
<div class="fixed-submit-container">
    <div id="body-submit-container" class="d-none">
        <button class="btn btn-warning text-white w-100 py-2 fw-bold shadow" style="background-color: #d97706;" onclick="submitBodyBets()">
            ဘော်ဒီ လောင်းမယ် (<span id="body-selected-count">0</span> ပွဲ)
        </button>
    </div>
    <div id="maung-submit-container" class="d-none">
        <button class="btn btn-warning text-white w-100 py-2 fw-bold shadow" style="background-color: #d97706;" onclick="showMaungAmountModal()">
            မောင်း လောင်းမယ် (<span id="maung-selected-count">0</span> ပွဲ)
        </button>
    </div>
</div>

<!-- Maung Amount Input Modal -->
<div class="modal fade" id="maungModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-purple text-white" style="background-color: #6f42c1;">
                <h5 class="modal-title fw-bold">မောင်း လောင်းမည့် ငွေပမာဏ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">ပမာဏ (Amount - အနည်းဆုံး ၁၀၀၀)</label>
                    <input type="number" id="maung-input-amount" class="form-control" placeholder="၁၀၀၀ ကျပ်မှစ၍">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-warning text-white btn-sm fw-bold" style="background-color: #d97706;" onclick="submitMaungBets()">အတည်ပြုမည်</button>
            </div>
        </div>
    </div>
</div>

<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-purple text-white" style="background-color: #6f42c1;">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-receipt me-2"></i> လောင်းခဲ့သော စလပ်မှတ်တမ်းများ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs nav-fill mb-3" role="tablist">
                    <li class="nav-item"><button class="nav-link active fw-bold text-purple" data-bs-toggle="tab" data-bs-target="#history-body" type="button">ဘော်ဒီစလပ်များ</button></li>
                    <li class="nav-item"><button class="nav-link fw-bold text-purple" data-bs-toggle="tab" data-bs-target="#history-maung" type="button">မောင်းစလပ်များ</button></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="history-body">
                        <div id="history-body-list" class="vstack gap-2"><div class="text-center py-3">ရှာဖွေနေသည်...</div></div>
                    </div>
                    <div class="tab-pane fade" id="history-maung">
                        <div id="history-maung-list" class="vstack gap-2"><div class="text-center py-3">ရှာဖွေနေသည်...</div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
            </div>
        </div>
    </div>
</div>

<!-- Live Video Pop-up Modal -->
<div class="modal fade" id="liveVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden bg-dark">
            <div class="modal-header border-0 pb-0 text-white justify-content-between align-items-center">
                <h5 class="modal-title fw-bold fs-6">🔴 Live Match Stream</h5>
                <!-- Resolution Selection Buttons -->
                <div id="resolution-buttons" class="d-flex gap-1 flex-wrap"></div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="stopLiveStream()"></button>
            </div>
            <div class="modal-body p-0 position-relative" style="min-height: 350px; background: #000;">
                <div id="video-container" class="ratio ratio-16x9"></div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation Bar -->
<div class="bottom-nav">
    <a href="{{ url('/game-home') }}" class="nav-item-custom">
        <i class="fa-solid fa-gamepad"></i> Game
    </a>
    <a href="{{ url('/game-home') }}" class="nav-item-custom">
        <i class="fa-solid fa-calculator"></i> 2D
    </a>
    <a href="{{ route('football') }}" class="nav-item-custom active">
        <i class="fa-solid fa-futbol"></i> ဘောပွဲ
    </a>
    <a href="{{ url('/game-home#') }}" class="nav-item-custom">
        <i class="fa-solid fa-wallet"></i> Wallet
    </a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const baseUrl = "{{ url('/api') }}";
    const token = localStorage.getItem('auth_token') || "{{ session('auth_token') }}";
    let userBalance = Number("{{ auth()->user()->balance ?? 0 }}");
    const userDocId = "{{ auth()->id() ?? '1' }}";

    let matchesList = [];
    let bodySelectedBets = {}; 
    let bodyAmounts = {};      
    let maungSelectedBets = {}; 

    document.addEventListener("DOMContentLoaded", function() {
        fetchMatches();
        setInterval(() => {
            fetchMatchesSilent();
            checkAndCloseMatchStatuses();
        }, 5000);
    });

    async function fetchMatches() {
        try {
            let res = await fetch(`${baseUrl}/football-matches`, {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            let data = await res.json();
            matchesList = Array.isArray(data) ? data : (data.data || []);
            updateLiveLeagueDropdown();
            renderMatches();
        } catch (e) {
            console.error(e);
        }
    }

    async function fetchMatchesSilent() {
        try {
            let res = await fetch(`${baseUrl}/football-matches`, {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            let data = await res.json();
            let newMatches = Array.isArray(data) ? data : (data.data || []);
            if (JSON.stringify(newMatches) !== JSON.stringify(matchesList)) {
                matchesList = newMatches;
                updateLiveLeagueDropdown();
                renderMatches();
            }
        } catch (e) {}
    }

    async function checkAndCloseMatchStatuses() {
        try {
            await fetch(`${baseUrl}/football-matches/check-and-close`, {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
        } catch (e) {}
    }

    function updateLiveLeagueDropdown() {
        let leagueSelect = document.getElementById('live-league-filter');
        if (!leagueSelect) return;
        
        let currentSelected = leagueSelect.value;
        let leagues = new Set();
        
        matchesList.forEach(m => {
            let hasVideo = m.video_link && m.video_link.trim() !== '' && m.video_link !== 'NULL';
            if (hasVideo && m.league_name) {
                leagues.add(m.league_name);
            }
        });

        let optionsHtml = `<option value="all">လိဂ်အားလုံး (All Leagues)</option>`;
        leagues.forEach(l => {
            optionsHtml += `<option value="${l}">${l}</option>`;
        });

        leagueSelect.innerHTML = optionsHtml;
        if ([...leagues].includes(currentSelected) || currentSelected === 'all') {
            leagueSelect.value = currentSelected;
        }
    }

    function renderMatches() {
        let bodyHtml = '';
        let maungHtml = '';
        let liveHtml = '';

        let bodyMatches = matchesList.filter(m => m.body_status == 1 || m.body_status === true);
        let maungMatches = matchesList.filter(m => m.maung_status == 1 || m.maung_status === true);
        
        let liveMatches = matchesList.filter(m => m.video_link && m.video_link.trim() !== '' && m.video_link !== 'NULL');

        let selectedLeague = document.getElementById('live-league-filter')?.value || 'all';
        if (selectedLeague !== 'all') {
            liveMatches = liveMatches.filter(m => m.league_name === selectedLeague);
        }

        bodyMatches.sort((a,b) => (a.id || 0) - (b.id || 0));
        maungMatches.sort((a,b) => (a.id || 0) - (b.id || 0));
        liveMatches.sort((a,b) => (a.id || 0) - (b.id || 0));

        if (bodyMatches.length === 0) {
            bodyHtml = `<div class="text-center text-muted py-4">ယခုလက်ရှိ ဘော်ဒီပွဲစဉ်များ မရှိသေးပါ</div>`;
        } else {
            bodyMatches.forEach(m => {
                let isHomeSelected = bodySelectedBets[m.id] === m.home_team;
                let isAwaySelected = bodySelectedBets[m.id] === m.away_team;
                let isOverSelected = bodySelectedBets[m.id] === 'ဂိုးပေါ်';
                let isUnderSelected = bodySelectedBets[m.id] === 'ဂိုးအောက်';
                let currentAmt = bodyAmounts[m.id] || '';

                bodyHtml += `
                    <div class="match-card">
                        <div class="d-flex justify-content-between align-items-center text-muted small mb-2">
                            <div>
                                <span class="fw-bold text-purple">${m.league_name || 'General League'}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span>ပွဲစဥ်: ${m.id}</span>
                            </div>
                        </div>
                        <div class="row g-2 align-items-center">
                            <div class="col-5">
                                <div class="option-btn ${isHomeSelected ? 'selected' : ''}" onclick="toggleBodySelection(${m.id}, '${m.home_team}')">
                                    <div class="fw-bold small">${m.home_team}</div>
                                    <div class="text-muted small" style="font-size: 11px;">${m.body_odds || m.home_odds || ''}</div>
                                </div>
                            </div>
                            <div class="col-2 text-center fw-bold text-purple">${m.body_goal_total || m.goal_total || '-'}</div>
                            <div class="col-5">
                                <div class="option-btn ${isAwaySelected ? 'selected' : ''}" onclick="toggleBodySelection(${m.id}, '${m.away_team}')">
                                    <div class="fw-bold small">${m.away_team}</div>
                                    <div class="text-muted small" style="font-size: 11px;">${m.body_away_odds || m.away_odds || ''}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <div class="option-btn ${isOverSelected ? 'selected' : ''}" onclick="toggleBodySelection(${m.id}, 'ဂိုးပေါ်')" style="color: #15803d; border-color: #15803d;">
                                    <span class="fw-bold small">ဂိုးပေါ် (Over)</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="option-btn ${isUnderSelected ? 'selected' : ''}" onclick="toggleBodySelection(${m.id}, 'ဂိုးအောက်')" style="color: #b91c1c; border-color: #b91c1c;">
                                    <span class="fw-bold small">ဂိုးအောက် (Under)</span>
                                </div>
                            </div>
                        </div>
                        ${bodySelectedBets[m.id] ? `
                            <div class="mt-2">
                                <input type="number" id="body-amt-${m.id}" class="form-control form-control-sm" placeholder="လောင်းမည့် ငွေပမာဏ (အနည်းဆုံး ၁၀၀၀)" value="${currentAmt}" oninput="updateBodyAmount(${m.id}, this.value)">
                            </div>
                        ` : ''}
                    </div>
                `;
            });
        }

        if (maungMatches.length === 0) {
            maungHtml = `<div class="text-center text-muted py-4">ယခုလက်ရှိ မောင်ပွဲစဉ်များ မရှိသေးပါ</div>`;
        } else {
            maungMatches.forEach(m => {
                let isHomeSelected = maungSelectedBets[m.id] === m.home_team;
                let isAwaySelected = maungSelectedBets[m.id] === m.away_team;
                let isOverSelected = maungSelectedBets[m.id] === 'ဂိုးပေါ်';
                let isUnderSelected = maungSelectedBets[m.id] === 'ဂိုးအောက်';

                maungHtml += `
                    <div class="match-card">
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span class="fw-bold text-purple">${m.league_name || 'General League'}</span>
                            <span>ပွဲစဥ်: ${m.id}</span>
                        </div>
                        <div class="row g-2 align-items-center">
                            <div class="col-5">
                                <div class="option-btn ${isHomeSelected ? 'selected' : ''}" onclick="toggleMaungSelection(${m.id}, '${m.home_team}')">
                                    <div class="fw-bold small">${m.home_team}</div>
                                    <div class="text-muted small" style="font-size: 11px;">${m.home_odds || ''}</div>
                                </div>
                            </div>
                            <div class="col-2 text-center fw-bold text-purple">${m.goal_total || '-'}</div>
                            <div class="col-5">
                                <div class="option-btn ${isAwaySelected ? 'selected' : ''}" onclick="toggleMaungSelection(${m.id}, '${m.away_team}')">
                                    <div class="fw-bold small">${m.away_team}</div>
                                    <div class="text-muted small" style="font-size: 11px;">${m.away_odds || ''}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <div class="option-btn ${isOverSelected ? 'selected' : ''}" onclick="toggleMaungSelection(${m.id}, 'ဂိုးပေါ်')" style="color: #15803d; border-color: #15803d;">
                                    <span class="fw-bold small">ဂိုးပေါ် (Over)</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="option-btn ${isUnderSelected ? 'selected' : ''}" onclick="toggleMaungSelection(${m.id}, 'ဂိုးအောက်')" style="color: #b91c1c; border-color: #b91c1c;">
                                    <span class="fw-bold small">ဂိုးအောက် (Under)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        if (liveMatches.length === 0) {
            liveHtml = `<div class="text-center text-muted py-4">ယခုလက်ရှိ တိုက်ရိုက်ကြည့်ရှုနိုင်သော LIVE ပွဲစဉ်များ မရှိသေးပါ</div>`;
        } else {
            liveMatches.forEach(m => {
                liveHtml += `
                    <div class="match-card border-danger">
                        <div class="d-flex justify-content-between align-items-center text-muted small mb-2">
                            <div>
                                <span class="badge bg-danger text-white me-1" style="font-size: 10px;"><i class="fas fa-circle me-1" style="font-size: 6px;"></i>LIVE STREAM</span>
                                <span class="fw-bold text-purple">${m.league_name || 'General League'}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="badge bg-danger text-white border-0 px-2 py-1 shadow-sm" style="font-size: 11px; cursor: pointer;" onclick="openLiveModal('${m.video_link ? m.video_link.replace(/'/g, "\\'") : ''}')">
                                    <i class="fas fa-play-circle me-1"></i> ဖွင့်ကြည့်ရန်
                                </button>
                                <span>ပွဲစဥ်: ${m.id}</span>
                            </div>
                        </div>
                        <div class="row g-2 align-items-center">
                            <div class="col-5">
                                <div class="option-btn bg-light text-dark" style="pointer-events: none;">
                                    <div class="fw-bold small">${m.home_team}</div>
                                    <div class="text-muted small" style="font-size: 11px;">${m.body_odds || m.home_odds || ''}</div>
                                </div>
                            </div>
                            <div class="col-2 text-center fw-bold text-purple">${m.body_goal_total || m.goal_total || '-'}</div>
                            <div class="col-5">
                                <div class="option-btn bg-light text-dark" style="pointer-events: none;">
                                    <div class="fw-bold small">${m.away_team}</div>
                                    <div class="text-muted small" style="font-size: 11px;">${m.body_away_odds || m.away_odds || ''}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('body-matches-list').innerHTML = bodyHtml;
        document.getElementById('maung-matches-list').innerHTML = maungHtml;
        document.getElementById('live-matches-list').innerHTML = liveHtml;

        let bodyCount = Object.keys(bodySelectedBets).length;
        let maungCount = Object.keys(maungSelectedBets).length;

        let bodyContainer = document.getElementById('body-submit-container');
        if (bodyCount > 0) {
            bodyContainer.classList.remove('d-none');
            document.getElementById('body-selected-count').innerText = bodyCount;
        } else {
            bodyContainer.classList.add('d-none');
        }

        let maungContainer = document.getElementById('maung-submit-container');
        if (maungCount > 0) {
            maungContainer.classList.remove('d-none');
            document.getElementById('maung-selected-count').innerText = maungCount;
        } else {
            maungContainer.classList.add('d-none');
        }
    }

    function openLiveModal(videoLinksStr) {
        let videoContainer = document.getElementById('video-container');
        let resContainer = document.getElementById('resolution-buttons');
        if (!videoContainer || !resContainer) return;

        videoContainer.innerHTML = '';
        resContainer.innerHTML = '';

        // လင့်ခ်များကို ကော်မာ (,) သို့မဟုတ် အတန်းအသစ် (Newline) ဖြင့် သေချာခွဲထုတ်ခြင်း
        let links = String(videoLinksStr).split(/[\r\n,]+/).map(l => l.trim()).filter(l => l.length > 0);

        if (links.length === 0) {
            videoContainer.innerHTML = `<div class="text-white text-center p-4">ဗီဒီယိုလင့်ခ် မရှိပါ။</div>`;
            return;
        }

        // လင့်ခ်တစ်ခုတည်းသာရှိလျှင် တိုက်ရိုက်ဖွင့်မည်
        if (links.length === 1) {
            videoContainer.innerHTML = `
                <iframe src="${links[0]}" 
                    title="Live Stream" 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            `;
        } else {
            // လင့်ခ်များစွာရှိလျှင် ရွေးချယ်စရာ ခလုတ်များဖန်တီးပေးမည်
            let qualities = ['480 (480p)', '720 (720p)', '1080 (1080p)', 'HQ', 'LQ'];
            
            links.forEach((link, index) => {
                let qualityLabel = qualities[index] ? qualities[index] : `Quality ${index + 1}`;
                let btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `btn btn-sm ${index === 0 ? 'btn-danger' : 'btn-outline-light'} fw-bold px-2 py-1`;
                btn.style.fontSize = '11px';
                btn.innerText = qualityLabel;
                
                btn.onclick = function() {
                    resContainer.querySelectorAll('button').forEach(b => {
                        b.classList.remove('btn-danger');
                        b.classList.add('btn-outline-light');
                    });
                    btn.classList.remove('btn-outline-light');
                    btn.classList.add('btn-danger');

                    videoContainer.innerHTML = `
                        <iframe src="${link}" 
                            title="Live Stream" 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    `;
                };
                resContainer.appendChild(btn);
            });

            // ပထမဆုံးလင့်ခ်ကို အစောဆုံး ဖွင့်ပြပေးရန်
            videoContainer.innerHTML = `
                <iframe src="${links[0]}" 
                    title="Live Stream" 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            `;
        }

        let modal = new bootstrap.Modal(document.getElementById('liveVideoModal'));
        modal.show();
    }

    function stopLiveStream() {
        let videoContainer = document.getElementById('video-container');
        if (videoContainer) {
            videoContainer.innerHTML = '';
        }
    }

    function toggleBodySelection(matchId, option) {
        if (bodySelectedBets[matchId] === option) {
            delete bodySelectedBets[matchId];
            delete bodyAmounts[matchId];
        } else {
            bodySelectedBets[matchId] = option;
        }
        renderMatches();
    }

    function updateBodyAmount(matchId, val) {
        bodyAmounts[matchId] = val;
    }

    function toggleMaungSelection(matchId, option) {
        if (maungSelectedBets[matchId] === option) {
            delete maungSelectedBets[matchId];
        } else {
            maungSelectedBets[matchId] = option;
        }
        renderMatches();
    }

    async function submitBodyBets() {
        let token = localStorage.getItem('auth_token');
        let betsList = [];
        let totalAmount = 0;

        for (let matchId in bodySelectedBets) {
            let amt = parseFloat(bodyAmounts[matchId]) || 0;
            if (amt < 1000) {
                alert('ပွဲတစ်ပွဲလျှင် ငွေပမာဏ အနည်းဆုံး ၁၀၀၀ ကျပ်မှစ၍ ထည့်သွင်းရပါမည်။');
                return;
            }
            totalAmount += amt;

            let match = matchesList.find(m => m.id == matchId);
            betsList.push({
                match_id: matchId,
                home_team: match?.home_team || '',
                away_team: match?.away_team || '',
                home_odds: match?.body_odds || match?.home_odds || '',
                away_odds: match?.body_away_odds || match?.away_odds || '',
                goal_total: match?.body_goal_total || match?.goal_total || '',
                selected_option: bodySelectedBets[matchId],
                amount: amt
            });
        }

        sendBetsRequest('body', betsList);
    }

    function showMaungAmountModal() {
        if (Object.keys(maungSelectedBets).length < 3) {
            alert('မောင်းလောင်းရန် အနည်းဆုံး ၃ ပွဲ ရွေးချယ်ရပါမည်။');
            return;
        }
        new bootstrap.Modal(document.getElementById('maungModal')).show();
    }

    function submitMaungBets() {
        let amount = parseFloat(document.getElementById('maung-input-amount').value) || 0;
        if (amount < 1000) {
            alert('ငွေပမာဏ အနည်းဆုံး ၁၀၀၀ ကျပ် ရှိရပါမည်။');
            return;
        }

        let maungDetails = [];
        for (let matchId in maungSelectedBets) {
            let match = matchesList.find(m => m.id == matchId);
            maungDetails.push({
                match_id: matchId,
                home_team: match?.home_team || '',
                away_team: match?.away_team || '',
                home_odds: match?.home_odds || match?.body_odds || '',
                away_odds: match?.away_odds || match?.body_away_odds || '',
                goal_total: match?.goal_total || match?.body_goal_total || '',
                selected_option: maungSelectedBets[matchId]
            });
        }

        let betsList = [{
            match_id: 'MULTI',
            home_team: `${maungDetails.length} ပွဲပေါင်း`,
            goal_total: '',
            away_team: '',
            selected_option: JSON.stringify(maungDetails),
            amount: amount
        }];

        bootstrap.Modal.getInstance(document.getElementById('maungModal')).hide();
        sendBetsRequest('maung', betsList);
    }

    async function sendBetsRequest(betType, betsList) {
        try {
            let res = await fetch(`${baseUrl}/football/place-bet`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    user_doc_id: userDocId,
                    bet_type: betType,
                    bets: betsList
                })
            });
            let data = await res.json();
            if (data.status === 'success') {
                alert('လောင်းခြင်း အောင်မြင်ပါသည်');
                if (betType === 'body') {
                    bodySelectedBets = {};
                    bodyAmounts = {};
                } else {
                    maungSelectedBets = {};
                }
                renderMatches();
            } else {
                alert('အမှားရှိသည်: ' + (data.message || 'မအောင်မြင်ပါ။'));
            }
        } catch (e) {
            alert('ချိတ်ဆက်မှု အမှားရှိသည်: ' + e);
        }
    }

    let allFootballBets = [];

    async function showHistoryModal() {
        new bootstrap.Modal(document.getElementById('historyModal')).show();
        try {
            let res = await fetch(`${baseUrl}/football/history?user_doc_id=${userDocId}`, {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            let data = await res.json();
            allFootballBets = Array.isArray(data) ? data : (data.data || []);

            renderFootballDateFilter(allFootballBets);
            filterFootballHistoryByDate('all');
        } catch (e) {
            document.getElementById('history-body-list').innerHTML = '<div class="text-center text-danger">မှတ်တမ်း ရယူ၍မရပါ။</div>';
            document.getElementById('history-maung-list').innerHTML = '<div class="text-center text-danger">မှတ်တမ်း ရယူ၍မရပါ။</div>';
        }
    }

    function renderFootballDateFilter(allBets) {
        let modalBody = document.querySelector('#historyModal .modal-body');
        if (!modalBody) return;

        let datesSet = new Set();
        allBets.forEach(b => {
            let fullDateStr = b.created_at ? b.created_at.toString() : '';
            let dateOnly = fullDateStr.split(' ')[0];
            if (dateOnly) datesSet.add(dateOnly);
        });

        let datesArray = Array.from(datesSet).sort().reverse();

        let filterContainer = document.getElementById('football-date-filter-container');
        if (!filterContainer) {
            filterContainer = document.createElement('div');
            filterContainer.id = 'football-date-filter-container';
            filterContainer.className = 'mb-3';
            modalBody.insertBefore(filterContainer, modalBody.firstChild);
        }

        let optionsHtml = `<option value="all">ရက်စွဲအားလုံး</option>`;
        datesArray.forEach(d => {
            optionsHtml += `<option value="${d}">${d}</option>`;
        });

        filterContainer.innerHTML = `
            <div class="d-flex align-items-center justify-content-between bg-light p-2 rounded border">
                <label class="fw-bold text-purple small mb-0"><i class="fas fa-calendar-alt me-1"></i> ရက်အလိုက်ကြည့်ရန်:</label>
                <select id="football-date-select" class="form-select form-select-sm w-auto fw-bold" onchange="filterFootballHistoryByDate(this.value)">
                    ${optionsHtml}
                </select>
            </div>
        `;
    }

    function filterFootballHistoryByDate(selectedDate) {
        let filteredBets = allFootballBets;
        if (selectedDate !== 'all') {
            filteredBets = allFootballBets.filter(b => {
                let fullDateStr = b.created_at ? b.created_at.toString() : '';
                return fullDateStr.startsWith(selectedDate);
            });
        }

        let bodyBets = filteredBets.filter(b => b.bet_type === 'body');
        let maungBets = filteredBets.filter(b => b.bet_type === 'maung');

        document.getElementById('history-body-list').innerHTML = renderHistoryList(bodyBets, true);
        document.getElementById('history-maung-list').innerHTML = renderHistoryList(maungBets, false);
    }

    function renderHistoryList(bets, isBody) {
        if (!bets || bets.length === 0) {
            return `<div class="text-center text-muted py-3">${isBody ? "ဘော်ဒီ" : "မောင်း"} လောင်းထားသော စလပ် မရှိသေးပါ</div>`;
        }
        let html = '';
        bets.forEach(b => {
            let selectedOptionStr = b.selected_option ? b.selected_option.toString() : '';
            let mainAmount = b.amount ? b.amount.toString() : '0';
            let mainWinAmount = b.win_amount ? b.win_amount.toString() : '0';
            let mainLost = b.lost ? b.lost.toString() : '0';
            let mainStatus = b.status ? b.status.toString() : 'pending';
            let rowId = b.id ? b.id.toString() : '';
            let createdAt = b.created_at ? b.created_at.toString() : '';

            let parsedMatches = [];
            try {
                let decoded = JSON.parse(selectedOptionStr);
                if (Array.isArray(decoded)) {
                    parsedMatches = decoded;
                }
            } catch (_) {}

            let statusColor = 'text-warning';
            if (mainStatus === 'win') {
                statusColor = 'text-success';
            } else if (mainStatus === 'lose' || mainStatus === 'lost' || (mainStatus === 'completed' && Number(mainLost) > 0)) {
                statusColor = 'text-danger';
            }

            html += `
                <div class="p-3 border rounded-3 bg-white shadow-sm mb-2" style="border-color: rgba(111, 66, 193, 0.3) !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold small text-purple">${isBody ? "ဘော်ဒီ" : "မောင်း"} (ID: ${rowId})</span>
                        <span class="text-muted" style="font-size: 10px;">${createdAt}</span>
                    </div>
                    <hr class="my-1">
            `;

            if (parsedMatches.length > 0) {
                parsedMatches.forEach(singleMatch => {
                    let hTeam = singleMatch['home_team'] ? singleMatch['home_team'].toString() : '';
                    let aTeam = singleMatch['away_team'] ? singleMatch['away_team'].toString() : '';
                    let selectedOpt = singleMatch['selected_option'] ? singleMatch['selected_option'].toString() : '';
                    let matchAmount = singleMatch['amount'] ? singleMatch['amount'].toString() : '0';
                    let goalTotal = singleMatch['goal_total'] ? singleMatch['goal_total'].toString() : '';
                    let matchWinAmount = singleMatch['win_amount'] ? singleMatch['win_amount'].toString() : '0';
                    let matchStatus = singleMatch['status'] ? singleMatch['status'].toString() : 'pending';

                    let matchStatusColor = 'text-warning';
                    if (matchStatus === 'win') matchStatusColor = 'text-success';
                    else if (matchStatus === 'lose' || matchStatus === 'lost') matchStatusColor = 'text-danger';

                    html += `
                        <div class="p-2 mb-1 rounded" style="background-color: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05);">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold" style="font-size: 11px;">${hTeam}</span>
                                <span class="fw-bold text-purple" style="font-size: 10px;">${goalTotal}</span>
                                <span class="fw-bold" style="font-size: 11px; text-align: right;">${aTeam}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="text-primary" style="font-size: 10px;">ရွေးချယ်မှု: ${selectedOpt}</span>
                                ${isBody && matchAmount !== '0' ? `<span class="text-warning" style="font-size: 10px;">ငွေ: ${matchAmount}</span>` : ''}
                            </div>
                            ${isBody ? `
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <span class="text-success fw-bold" style="font-size: 10px;">အနိုင်ရငွေ: ${matchWinAmount}</span>
                                    <span class="${matchStatusColor} fw-bold" style="font-size: 10px;">အခြေအနေ: ${matchStatus}</span>
                                </div>
                            ` : ''}
                        </div>
                    `;
                });
            } else {
                html += `
                    <div class="small fw-bold">${b.home_team || ''} vs ${b.away_team || ''}</div>
                    <div class="small text-primary">ရွေးချယ်မှု: ${selectedOptionStr}</div>
                `;
            }

            html += `
                    <hr class="my-1">
                    <div class="d-flex justify-content-between align-items-center small fw-bold mt-1">
                        <span style="font-size: 11px;">စုစုပေါင်း: ${mainAmount} ကျပ်</span>
                        <span class="${statusColor}" style="font-size: 11px;">အခြေအနေ: ${mainStatus}</span>
                    </div>
            `;

            if (!isBody) {
                html += `
                    <div class="d-flex justify-content-between small mt-1">
                        <span class="text-success fw-bold" style="font-size: 11px;">အနိုင်ရငွေ: ${mainWinAmount} ကျပ်</span>
                        <span class="text-danger fw-bold" style="font-size: 11px;">ရှုံးငွေ: ${mainLost} ကျပ်</span>
                    </div>
                `;
            }

            html += `</div>`;
        });
        return html;
    }
</script>
</body>
</html>