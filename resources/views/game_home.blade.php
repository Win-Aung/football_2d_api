<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Game - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f3e8ff; font-family: sans-serif; }
        .bg-purple { background-color: #6f42c1 !important; }
        .text-purple { color: #6f42c1 !important; }
        .main-container { max-width: 600px; margin: 20px auto; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .animal-card { cursor: pointer; transition: 0.2s; background-color: #f8f4ff; border: 1px solid #dcd6f7; }
        .animal-card:hover { background-color: #ede7f6; }
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); display: flex; justify-content: space-around; padding: 10px 0; z-index: 1000; }
        .nav-item-custom { text-align: center; color: #6c757d; text-decoration: none; font-size: 13px; }
        .nav-item-custom.active { color: #6f42c1; font-weight: bold; }
        .nav-item-custom i { font-size: 20px; display: block; margin-bottom: 2px; }
        .content-section { display: none; padding-bottom: 90px; } 
        .content-section.active { display: block; }
        
        .fixed-submit-container {
            position: fixed;
            bottom: 60px;
            left: 0;
            right: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.95);
            padding: 10px 15px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 -4px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="main-container">

        <!-- ================= 1. GAME TAB (ANIMAL GAME) ================= -->
        <div id="section-game" class="content-section active">
            <div class="card bg-purple text-white mb-3 shadow-sm">
                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa-solid fa-stopwatch text-warning"></i> 
                        <span id="timer-display" class="fw-bold text-warning fs-5">00:00</span>
                    </div>
                    
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="fetchLatestBatchDetail()">
    မှတ်တမ်း
</button>
                    <div class="badge bg-white text-dark px-3 py-2">
                        ပေါက်ကောင်: <span id="lucky-animal-display" class="fw-bold text-purple">စောင့်ဆိုင်းဆဲ...</span>
                    </div>
                </div>
            </div>

            <div class="row g-2 mb-5" id="animals-grid">
                <!-- Javascript ဖြင့် အကောင် ၃၆ ကောင်ကို ထည့်သွင်းမည် -->
            </div>
        </div>

        <!-- ဆော့ထားသော အသေးစိတ်စာရင်း ပြမည့် Modal Box -->
        <div class="modal fade" id="batchDetailModal" tabindex="-1" aria-labelledby="batchDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-purple text-white" style="background-color: #6f42c1;">
                        <h5 class="modal-title fs-6" id="batchDetailModalLabel">📜 ဆော့ထားသော အသေးစိတ်စာရင်း</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- ခေါင်းစဉ်နှင့် အခြေအနေပြရန် -->
                        <div class="mb-3">
                            <p id="batch-status-title" class="mb-1 fw-bold fs-6" style="color: #6f42c1;"></p>
                        </div>
                        <!-- အသေးစိတ်စာရင်းများ ထည့်သွင်းမည့် Container -->
                        <div id="batch-detail-list" style="max-height: 350px; overflow-y: auto;">
                            <!-- Javascript ဖြင့် Dynamic ထည့်သွင်းမည် -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 2. 2D TAB ================= -->
        @include('two_d_screen')

        <!-- ================= 3. FOOTBALL TAB ================= -->
        <div id="section-football" class="content-section">
            <h5 class="text-purple fw-bold mb-3">⚽ ဘောပွဲစဉ်များ</h5>
            <div class="alert alert-light border">
                <p class="m-0">ဘောပွဲစာရင်းများနှင့် လောင်းကြေးများ ပြသရန်နေရာ။</p>
            </div>
        </div>

        <!-- ================= 4. WALLET & HISTORY TAB ================= -->
         @include('wallet_history')                   

        <!-- Fixed Submit Button -->
        <div class="fixed-submit-container">
            <button class="btn bg-purple text-white w-100 py-2 fw-bold shadow" onclick="submitBets()" style="background-color: #6f42c1;">
                ဆော့မည် (<span id="total-bet-amount">0</span> ကျပ်)
            </button>
        </div>

<!-- Bottom Navigation Bar -->
<div class="bottom-nav">
    <a href="#" class="nav-item-custom active" onclick="switchTab('game', this)">
        <i class="fa-solid fa-gamepad"></i> Game
    </a>
    <a href="#" class="nav-item-custom" onclick="switchTab('2d', this)">
        <i class="fa-solid fa-calculator"></i> 2D
    </a>
    <a href="{{ route('football') }}" class="nav-item-custom">
        <i class="fa-solid fa-futbol"></i> ဘောပွဲ
    </a>
    <a href="#" class="nav-item-custom" onclick="switchTab('wallet', this)">
        <i class="fa-solid fa-wallet"></i> Wallet
    </a>
</div>
<!-- Alert ပေါ်မည့် Container (HTML) -->
<div id="custom-alert-container" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 500px;"></div>
<!-- Bootstrap 5 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript Logic -->
<script>
    
    const baseUrl = "http://127.0.0.1:8000/api";
    const token = localStorage.getItem('auth_token');

    const animals = [
        'မြင်း', 'တော', 'ရွှေနဂါး', 'လိပ်ပြာ', 'ဆတ်', 'မြွေ', 
        'မျောက်', 'ပင့်ကူ', 'ဗျိုင်း', 'သီလ', 'ငန်း', 'ခရု', 
        'ဆင်', 'ရွှေငါး', 'ကြက်', 'လိပ်', 'ကျီး', 'ငှက်', 
        'ကျား', 'ဝက်', 'ဒေါင်း', 'ယုန်', 'ခွေး', 'ပုစွန်', 
        'နဂါး', 'ဆိတ်', 'နွား', 'အိမ်', 'တီ', 'ငွေငါး', 
        'ခို', 'ဖား', 'ပျား', 'ကျောက်', 'ကြွက်', 'ရှဉ့်'
    ];

    let betAmounts = {};
    let amounts = {};
    for (let i = 0; i <= 99; i++) {
        amounts[String(i).padStart(2, '0')] = 0;
    }

    let selectedSession = '';
    let isSubmitting = false;
    let sessionStatuses = {
        '11:00 AM': { is_open: true, open_time: null, close_time: null },
        '12:00 PM': { is_open: true, open_time: null, close_time: null },
        '3:00 PM': { is_open: true, open_time: null, close_time: null },
        '4:30 PM': { is_open: true, open_time: null, close_time: null }
    };

    let countdownTimer = null;
    let remainingSeconds = 0;
    let isTimerInitialized = false; // Timer တစ်ကြိမ်စပြီးပါက ထပ်မံအတင်း override မဖြစ်စေရန်

    window.onload = function() {
        if (!token) {
            alert('ကျေးဇူးပြု၍ Login အရင်ဝင်ပါ။');
            window.location.href = "http://127.0.0.1:8000";
            return;
        }
        renderAnimalsGrid();
        fetchUserInfo();
        
        fetch2DResult();
        fetchSessionStatus();
        buildNumberGrid();

        fetchLuckyAnimalConfig(true); // ပထမအကြိမ် စတင်ချိန်တွင်သာ Duration ကို ယူမည်

        setInterval(() => {
            fetch2DResult();
            fetchSessionStatus();
            fetchLuckyAnimalConfig(false); // နောက်ပိုင်း Interval တွေမှာ Timer ကို မထိခိုက်စေဘဲ ပေါက်ကောင်ကိုသာ စစ်မည်
        }, 5000);
    };

    // 🛑 ဆာဗာမှ Timer နှင့် ပေါက်ကောင် အချက်အလက်ယူရန် (isInitial ထည့်သွင်းထားသည်)
    function fetchLuckyAnimalConfig(isInitial = false) {
        fetch(`${baseUrl}/config/timer`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            let configData = data.data || data;
            
            // ပထမအကြိမ် သို့မဟုတ် Timer မစတင်ရသေးမှသာ ဆာဗာအချိန်ကို ယူမည်
            if (isInitial || !isTimerInitialized) {
                remainingSeconds = configData.durationSeconds ? parseInt(configData.durationSeconds) : 300;
                startCountdown();
                isTimerInitialized = true;
            }
            
            // ပေါက်ကောင်နာမည် ပြရန်
            let luckyDisplay = document.getElementById('lucky-animal-display');
            if (luckyDisplay) {
                if (configData.luckyAnimal) {
                    luckyDisplay.innerText = configData.luckyAnimal;
                    luckyDisplay.className = "fw-bold text-purple";
                } else {
                    luckyDisplay.innerText = "စောင့်ဆိုင်းဆဲ...";
                }
            }
        })
        .catch(err => console.error('Error fetching timer/animal config:', err));
    }

    // 🛑 Timer ကို တစ်စက္ကန့်ချင်း လျော့သွားစေပြီး ပြီးဆုံးပါက ပေါက်ကောင် ထွက်လာစေရန် API ခေါ်သည့် function
    function startCountdown() {
        if (countdownTimer) clearInterval(countdownTimer);

        countdownTimer = setInterval(() => {
            let timerDisplay = document.getElementById('timer-display');
            
            if (remainingSeconds > 0) {
                remainingSeconds--;
                let mins = Math.floor(remainingSeconds / 60);
                let sec = remainingSeconds % 60;
                if (timerDisplay) {
                    timerDisplay.innerText = String(mins).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
                }
            } else {
                // အချိန်ပြည့်သွားပါက (00:00 ရောက်ပါက)
                clearInterval(countdownTimer);
                if (timerDisplay) {
                    timerDisplay.innerText = "00:00";
                }
                
                // ဆာဗာဘက်သို့ ပေါက်ကောင်တွက်ချက်ရန် (Trigger) လှမ်းခေါ်မည်
                triggerAndFetchResult();
            }
        }, 1000);
    }

    // 🛑 သတ်မှတ်ချိန်ရောက်လျှင် ပေါက်ကောင်တွက်ချက်ပေးမည့် API သို့ ပို့ရန်
    function triggerAndFetchResult() {
        let luckyDisplay = document.getElementById('lucky-animal-display');
        if (luckyDisplay) {
            luckyDisplay.innerText = "တွက်ချက်နေသည်...";
        }

        fetch(`${baseUrl}/trigger-lucky-draw`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.luckyAnimal) {
                if (luckyDisplay) {
                    luckyDisplay.innerText = data.luckyAnimal;
                    luckyDisplay.className = "fw-bold text-purple";
                }
                // အနိုင်အရှုံး ငွေရှင်းပြီးပါက User Balance ကိုပါ အသစ်ပြန်ခေါ်ရန်
                fetchUserInfo();
            }

            // ပေါက်ကောင် အောင်မြင်စွာထွက်လာပြီး အနိုင်အရှုံး စစ်ဆေးပြီးချိန်တွင် ဤကုဒ်ကို ထည့်ပါ
            if (data.status === 'success' && data.luckyAnimal) {
                let luckyAnimal = data.luckyAnimal;
                let userWon = data.isWin || false; // ဆာဗာမှ ပို့ပေးမည့် အနိုင်/အရှုံး boolean
                let winnings = data.winnings || 0; // ရရှိမည့် ဆုကြေးငွေ

                if (userWon) {
                    // 🥳 နိုင်သွားသည့်အခါ ပြမည့် Alert (Green)
                    showCustomAlert(`🎉 ဂုဏ်ယူပါတယ်! ပေါက်ကောင် (${luckyAnimal}) ထွက်ပါသည် ဆုကြေးငွေ ${Number(winnings).toLocaleString()} ကျပ် ရရှိပါပြီ!`, 'success');
                } else {
                    // 😢 မနိုင်သည့်အခါ ပြမည့် Alert (Red)
                    showCustomAlert(`😢 ယခုအကြိမ် ပေါက်ကောင်မှာ (${luckyAnimal}) ဖြစ်ပါသည်။ သင် မဆော့ထားပါ။`, 'danger');
                }
            }
            
            // ခဏအကြာတွင် Timer အသစ်ကို ပြန်စရန် (ဆာဗာက duration အသစ်ကို ယူရန် fetchLuckyAnimalConfig(true) ကို သုံးပါ)
            setTimeout(() => {
                fetchLuckyAnimalConfig(true); // Admin ချိန်းထားသည့် Timer အသစ်ကို ဆာဗာမှ ပြန်လှမ်းယူမည်
            }, 3000);
        })
        .catch(err => {
            console.error('Error triggering lucky draw:', err);
            setTimeout(() => { 
                fetchLuckyAnimalConfig(true); 
            }, 3000);
        });

        
    }

    // SnackBar ပုံစံ Alert ပြပေးမည့် Function
    function showCustomAlert(message, type = 'success') {
        let container = document.getElementById('custom-alert-container');
        if (!container) return;
        
        let bgColor = type === 'success' ? '#198754' : '#dc3545'; // Colors.green နှင့် Colors.redAccent
        
        let alertHtml = `
            <div class="alert text-white shadow-lg fade show d-flex align-items-center justify-content-between" role="alert" style="background-color: ${bgColor}; border-radius: 8px;">
                <div>${message}</div>
                <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.remove()"></button>
            </div>
        `;
        
        container.innerHTML = alertHtml;

        // ၄ စက္ကန့်ကြာပါက အလိုအလျောက် ပျောက်သွားရန်
        setTimeout(() => {
            let alertEl = container.querySelector('.alert');
            if (alertEl) {
                alertEl.classList.remove('show');
                setTimeout(() => alertEl.remove(), 150);
            }
        }, 4000);
    }

    // ဆော့ထားသော အသေးစိတ်စာရင်းကို API မှတဆင့် ယူ၍ Modal တွင် ပြသရန်
    function fetchAndShowBatchDetail(batchId) {
        fetch(`${baseUrl}/animal/history`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(response => {
            if (response.status === 'success' && Array.isArray(response.data)) {
                // သက်ဆိုင်သော batchId (သို့မဟုတ် id) နှင့် ကိုက်ညီသော ဒေတာကို ရှာရန်
                let matchedRecord = response.data.find(item => item.id == batchId || item.batchId == batchId);
                
                if (matchedRecord && matchedRecord.bets_json) {
                    let bets = typeof matchedRecord.bets_json === 'string' 
                        ? JSON.parse(matchedRecord.bets_json) 
                        : matchedRecord.bets_json;
                    
                    showBatchDetailModal(batchId, bets, matchedRecord.luckyAnimal);
                } else {
                    alert('အသေးစိတ်စာရင်း မတွေ့ရှိပါ။');
                }
            }
        })
        .catch(err => {
            console.error('Error fetching batch detail:', err);
            alert('ဒေတာရယူ၍ မရပါ။');
        });
    }

    let allAnimalHistoryRecords = []; // Global variable for storing all animal history records

    // မှတ်တမ်းခလုတ်ကို နှိပ်သောအခါ ဆော့ထားသော မှတ်တမ်းအားလုံးကို API မှ ယူ၍ Modal တွင် ပြသရန်
    function fetchLatestBatchDetail() {
        let currentUserId = window.appConfig && window.appConfig.userDocId ? window.appConfig.userDocId : '';

        fetch(`${baseUrl}/animal/history?userId=${currentUserId}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(response => {
            if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                allAnimalHistoryRecords = response.data;
                showAllBatchHistoryModal(allAnimalHistoryRecords);
            } else {
                fetch(`${baseUrl}/animal/history`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(fallbackRes => {
                    if (fallbackRes.status === 'success' && Array.isArray(fallbackRes.data) && fallbackRes.data.length > 0) {
                        allAnimalHistoryRecords = fallbackRes.data;
                        showAllBatchHistoryModal(allAnimalHistoryRecords);
                    } else {
                        alert('ဆော့ထားသော မှတ်တမ်း လုံးဝမရှိသေးပါ။');
                    }
                })
                .catch(() => {
                    alert('ဆော့ထားသော မှတ်တမ်း လုံးဝမရှိသေးပါ။');
                });
            }
        })
        .catch(err => {
            console.error('Error fetching batch detail:', err);
            alert('ဒေတာရယူ၍ မရပါ။');
        });
    }

    // ရက်စွဲအလိုက် စစ်ထုတ်ရန် Dropdown UI နှင့်အတူ မှတ်တမ်းများပြသခြင်း
    function showAllBatchHistoryModal(records) {
        let modalBody = document.querySelector('#batchDetailModal .modal-body');
        if (!modalBody) return;

        // ရက်စွဲများ စုဆောင်းခြင်း
        let datesSet = new Set();
        records.forEach(r => {
            let fullDateStr = r.time || r.created_at || '';
            let dateOnly = fullDateStr.split(' ')[0]; // YYYY-MM-DD
            if (dateOnly) datesSet.add(dateOnly);
        });

        let datesArray = Array.from(datesSet).sort().reverse();

        // Filter UI Container ဖန်တီးခြင်း (မရှိသေးပါက)
        let filterContainer = document.getElementById('animal-date-filter-container');
        if (!filterContainer) {
            filterContainer = document.createElement('div');
            filterContainer.id = 'animal-date-filter-container';
            filterContainer.className = 'mb-3';
            let statusTitleEl = document.getElementById('batch-status-title');
            if (statusTitleEl && statusTitleEl.parentElement) {
                statusTitleEl.parentElement.insertAdjacentElement('beforebegin', filterContainer);
            }
        }

        let optionsHtml = `<option value="all">ရက်စွဲအားလုံး</option>`;
        datesArray.forEach(d => {
            optionsHtml += `<option value="${d}">${d}</option>`;
        });

        filterContainer.innerHTML = `
            <div class="d-flex align-items-center justify-content-between bg-light p-2 rounded border">
                <label class="fw-bold text-purple small mb-0"><i class="fas fa-calendar-alt me-1"></i> ရက်အလိုက်ကြည့်ရန်:</label>
                <select id="animal-date-select" class="form-select form-select-sm w-auto fw-bold" onchange="filterAnimalHistoryByDate(this.value)">
                    ${optionsHtml}
                </select>
            </div>
        `;

        renderAnimalHistoryList(records);

        let myModal = new bootstrap.Modal(document.getElementById('batchDetailModal'));
        myModal.show();
    }

    // ရွေးချယ်ထားသော ရက်စွဲအလိုက် စစ်ထုတ်ခြင်း
    function filterAnimalHistoryByDate(selectedDate) {
        let filtered = allAnimalHistoryRecords;
        if (selectedDate !== 'all') {
            filtered = allAnimalHistoryRecords.filter(r => {
                let fullDateStr = r.time || r.created_at || '';
                return fullDateStr.startsWith(selectedDate);
            });
        }
        renderAnimalHistoryList(filtered);
    }

    // မှတ်တမ်း စာရင်းများကို 渲染 (Render) လုပ်ခြင်း
    function renderAnimalHistoryList(records) {
        let statusTitleEl = document.getElementById('batch-status-title');
        if (statusTitleEl) {
            statusTitleEl.innerHTML = `📜 စုစုပေါင်း မှတ်တမ်းများ (${records.length} ခု)`;
        }

        let listContainer = document.getElementById('batch-detail-list');
        if (!listContainer) return;
        listContainer.innerHTML = '';

        if (records.length === 0) {
            listContainer.innerHTML = '<p class="text-muted text-center py-3">ရွေးချယ်ထားသော ရက်စွဲတွင် မှတ်တမ်း မရှိပါ။</p>';
            return;
        }

        records.forEach(record => {
            let bets = typeof record.bets_json === 'string' ? JSON.parse(record.bets_json) : record.bets_json;
            let luckyAnimal = record.luckyAnimal || '-';
            let batchTime = record.time || '-';
            let totalAmt = parseFloat(record.total_amount) || 0;
            let rowStatus = record.status || 'Pending';

            let headerHtml = `
                <div class="p-2 mb-2 bg-light border rounded">
                    <div class="d-flex justify-content-between text-muted" style="font-size: 11px;">
                        <span>အချိန်: ${batchTime}</span>
                        <span>ပေါက်ကောင်: <strong class="text-purple">${luckyAnimal}</strong></span>
                    </div>
                    <div class="fw-bold text-dark" style="font-size: 12px;">စုစုပေါင်းထိုးငွေ: ${totalAmt.toLocaleString()} ကျပ် (${rowStatus})</div>
                </div>
            `;
            listContainer.innerHTML += headerHtml;

            if (Array.isArray(bets)) {
                bets.forEach(bet => {
                    let animal = bet.animal || bet.animal_name || '';
                    let amount = parseFloat(bet.amount) || 0;
                    let status = bet.status || 'Pending';
                    let winAmt = parseFloat(bet.winAmount || bet.win_amount || (status.toLowerCase() === 'win' ? amount * 27 : 0));

                    let isWin = status.toLowerCase() === 'win';
                    let isPending = status.toLowerCase() === 'pending';

                    let cardBg = isPending ? '#fff3cd' : (isWin ? '#d1e7dd' : '#f8d7da');
                    let badgeBg = isPending ? '#ffecb5' : (isWin ? '#badbcc' : '#f5c2c7');
                    let badgeColor = isPending ? '#664d03' : (isWin ? '#0f5132' : '#842029');
                    let statusText = isPending ? 'Pending' : (isWin ? 'Win (နိုင်)' : 'Lost (ရှုံး)');

                    let subtitleText = isWin 
                        ? `ထိုးငွေ: ${amount.toLocaleString()} ကျပ် | နိုင်ငွေ: ${winAmt.toLocaleString()} ကျပ်`
                        : `ထိုးငွေ: ${amount.toLocaleString()} ကျပ်`;

                    let itemHtml = `
                        <div class="card mb-2 shadow-sm border-0 ms-3" style="background-color: ${cardBg};">
                            <div class="card-body p-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 13px;">အကောင်: ${animal}</h6>
                                    <small class="text-muted" style="font-size: 11px;">${subtitleText}</small>
                                </div>
                                <span class="badge px-2 py-1" style="background-color: ${badgeBg}; color: ${badgeColor}; font-size: 10px;">
                                    ${statusText}
                                </span>
                            </div>
                        </div>
                    `;
                    listContainer.innerHTML += itemHtml;
                });
            }
        });
    }

    
    //2
    function switchTab(tabName, element) {
        document.querySelectorAll('.content-section').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.nav-item-custom').forEach(el => el.classList.remove('active'));

        document.getElementById(`section-${tabName}`).classList.add('active');
        if (element) element.classList.add('active');

        let submitContainer = document.querySelector('.fixed-submit-container');
        if (tabName === 'game') {
            submitContainer.style.display = 'block';
        } else {
            submitContainer.style.display = 'none';
        }
    }

    function renderAnimalsGrid() {
        let gridHtml = '';
        animals.forEach((animal, index) => {
            betAmounts[index] = 0;
            gridHtml += `
                <div class="col-4">
                    <div class="card animal-card p-2 text-center shadow-sm">
                        <span class="fw-bold text-purple small">${animal}</span>
                        <div class="input-group input-group-sm mt-1">
                            <button type="button" class="btn btn-outline-danger py-0 px-1" onclick="updateBet(${index}, -100)">-</button>
                            <input type="number" id="bet-input-${index}" class="form-control text-center p-0" value="0" onchange="calculateTotal()">
                            <button type="button" class="btn btn-outline-success py-0 px-1" onclick="updateBet(${index}, 100)">+</button>
                        </div>
                    </div>
                </div>
            `;
        });
        document.getElementById('animals-grid').innerHTML = gridHtml;
    }

    function updateBet(index, amount) {
        let input = document.getElementById(`bet-input-${index}`);
        let currentVal = parseInt(input.value) || 0;
        let newVal = currentVal + amount;
        if (newVal < 0) newVal = 0;
        input.value = newVal;
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        animals.forEach((_, index) => {
            let val = parseInt(document.getElementById(`bet-input-${index}`).value) || 0;
            total += val;
        });
        document.getElementById('total-bet-amount').innerText = total;
    }

    async function fetchUserInfo() {
        try {
            let res = await fetch(`${baseUrl}/user/info`, {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            let data = await res.json();
            if(data.status === 'success') {
                document.getElementById('user-name-display').innerText = data.user.name;
                document.getElementById('user-phone-display').innerText = data.user.phone;
                document.getElementById('user-balance-display').innerText = data.user.balance + ' ကျပ်';
                
                if (window.appConfig) {
                    window.appConfig.userBalance = Number(data.user.balance) || 0;
                }
            }
        } catch(e) { console.error(e); }
    }

    async function submitBets() {
        if (isSubmitting) return;

        let betsToSubmit = [];
        animals.forEach((animal, index) => {
            let input = document.getElementById(`bet-input-${index}`);
            let amount = parseInt(input.value) || 0;
            if (amount > 0) {
                betsToSubmit.push({
                    animal_index: index,
                    animal_name: animal,
                    amount: amount
                });
            }
        });

        if (betsToSubmit.length === 0) {
            alert('ကျေးဇူးပြု၍ ထိုးမည့်အကောင်နှင့် ငွေပမာဏကို ထည့်သွင်းပါ။');
            return;
        }

        let total = parseInt(document.getElementById('total-bet-amount').innerText) || 0;
        
        let currentBalance = window.appConfig && window.appConfig.userBalance !== undefined ? window.appConfig.userBalance : 0;
        if (currentBalance < total) {
            alert('လက်ကျန်ငွေ မလုံလောက်ပါ။');
            return;
        }

        isSubmitting = true;

        try {
            let res = await fetch(`${baseUrl}/place-bets`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': window.appConfig.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    userId: window.appConfig.userDocId,
                    userName: window.appConfig.userName,
                    bets: betsToSubmit
                })
            });

            let data = await res.json();

            if (res.ok && data.status === 'success') {
                alert('လောင်းကြေး တင်သွင်းခြင်း အောင်မြင်ပါသည်။');
                
                animals.forEach((_, index) => {
                    let input = document.getElementById(`bet-input-${index}`);
                    if (input) input.value = 0;
                });
                calculateTotal();
                fetchUserInfo();
            } else {
                alert('အမှားအယွင်းရှိသည်: ' + (data.message || 'မအောင်မြင်ပါ။'));
            }
        } catch (e) {
            console.error(e);
            alert('ဆာဗာသို့ ချိတ်ဆက်၍ မရပါ။');
        } finally {
            isSubmitting = false;
        }
    }

    function fetch2DResult() {
        fetch(`${baseUrl}/proxy/twod-live`, {
            headers: { 
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json' 
            }
        })
        .then(res => res.json())
        .then(data => {
            let resData = data.data || data;
            
            let dateVal = document.getElementById('date-val');
            if(dateVal) dateVal.innerText = 'ရက်စွဲ: ' + (resData.date || '-');
            let lastDateVal = document.getElementById('last-date-val');
            if(lastDateVal) lastDateVal.innerText = 'နောက်ဆုံးရက်: ' + (resData.last_date || '-');
            let liveVal = document.getElementById('live-val');
            if(liveVal) liveVal.innerText = resData.live || '-';

            renderSessions([
                { name: '11:00 AM', set: resData.set_1100 || '-', val: resData.val_1100 || '-', result: resData.result_1100 || '-' },
                { name: '12:00 PM', set: resData.set_1200 || '-', val: resData.val_1200 || '-', result: resData.result_1200 || '-' },
                { name: '3:00 PM', set: resData.set_300 || '-', val: resData.val_300 || '-', result: resData.result_300 || '-' },
                { name: '4:30 PM', set: resData.set_430 || '-', val: resData.val_430 || '-', result: resData.result_430 || '-' }
            ]);
        }).catch(err => console.error('Error fetching live result:', err));
    }

    function fetchSessionStatus() {
        fetch(`${baseUrl}/config/session-status`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            let rawSessions = data.data || data.sessions || data;
            let updatedStatuses = {};
            if (Array.isArray(rawSessions)) {
                rawSessions.forEach(s => {
                    if (s.session_name) {
                        let isOpen = s.is_open == 1 || s.is_open === true || s.is_open == '1';
                        updatedStatuses[s.session_name] = {
                            is_open: isOpen ? 1 : 0,
                            open_time: s.open_time,
                            close_time: s.close_time
                        };
                    }
                });
                sessionStatuses = {...sessionStatuses, ...updatedStatuses};
            }
        }).catch(e => {});
    }

    function renderSessions(sessions) {
        let container = document.getElementById('session-list');
        if (!container) return;
        container.innerHTML = '';
        
        sessions.forEach(s => {
            let sessionData = sessionStatuses[s.name] || { is_open: 1 };
            let isDbOpen = sessionData.is_open == 1 || sessionData.is_open === true;
            let openTimeStr = sessionData.open_time;
            let closeTimeStr = sessionData.close_time;
            
            let isScheduleOpen = true;
            if (isDbOpen && openTimeStr && closeTimeStr) {
                try {
                    let now = new Date();
                    let openTime = new Date(openTimeStr);
                    let closeTime = new Date(closeTimeStr);
                    if (!isNaN(openTime) && !isNaN(closeTime)) {
                        if (now < openTime || now > closeTime) {
                            isScheduleOpen = false;
                        }
                    }
                } catch (e) {}
            }

            let isOpen = isDbOpen && isScheduleOpen;

            container.innerHTML += `
                <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded border">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold text-purple">${s.name}</span>
                            <span class="badge ${isOpen ? 'bg-success' : 'bg-danger'}" style="font-size: 10px;">
                                ${isOpen ? 'ဖွင့်' : 'ပိတ်'}
                            </span>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">SET: ${s.set} | VALUE: ${s.val}</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-purple px-2 py-1 fs-6" style="background-color: #6f42c1;">${s.result}</span>
                        <button type="button" onclick="openCardSelection('${s.name}', ${isOpen}, ${isDbOpen}, ${isScheduleOpen})" class="btn btn-sm ${isOpen ? 'btn-purple text-white' : 'btn-secondary disabled'}" style="background-color: ${isOpen ? '#6f42c1' : ''}; font-size: 11px;">
                            ထိုးမည်
                        </button>
                    </div>
                </div>
            `;
        });
    }

    function buildNumberGrid() {
        let gridContainer = document.getElementById('number-grid');
        if (!gridContainer) return;
        gridContainer.innerHTML = '';

        for (let i = 0; i <= 99; i++) {
            let code = String(i).padStart(2, '0');
            gridContainer.innerHTML += `
                <div class="col-3 p-1">
                    <div class="card p-1 text-center border shadow-sm">
                        <span class="fw-bold text-purple" style="font-size: 14px;">${code}</span>
                        <input type="number" id="amt-${code}" value="${amounts[code]}" min="0" oninput="updateAmountVal('${code}', this.value)"
                            class="form-control form-control-sm text-center p-0 mt-1" style="font-size: 11px;">
                        <div class="d-flex justify-content-between mt-1">
                            <button type="button" class="btn btn-outline-danger btn-sm p-0 px-1" onclick="adjustAmount('${code}', -100)" style="font-size: 10px;">-</button>
                            <button type="button" class="btn btn-outline-success btn-sm p-0 px-1" onclick="adjustAmount('${code}', 100)" style="font-size: 10px;">+</button>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    async function submitTwoDBets() {
        if (isSubmitting) return;

        let betsToSubmit = [];
        for (let key in amounts) {
            let amt = amounts[key];
            if (amt > 0) {
                betsToSubmit.push({
                    number: key,
                    amount: amt
                });
            }
        }

        if (betsToSubmit.length === 0) {
            alert('ကျေးဇူးပြု၍ ထိုးမည့်နံပါတ်နှင့် ငွေပမာဏကို ထည့်သွင်းပါ။');
            return;
        }

        let total = 0;
        for (let key in amounts) {
            total += amounts[key];
        }

        let currentBalance = window.appConfig && window.appConfig.userBalance !== undefined ? window.appConfig.userBalance : 0;
        if (currentBalance < total) {
            alert('လက်ကျန်ငွေ မလုံလောက်ပါ။');
            return;
        }

        if (!selectedSession) {
            alert('ကျေးဇူးပြု၍ Session ကို အရင်ရွေးချယ်ပါ။');
            return;
        }

        isSubmitting = true;

        try {
            let res = await fetch(`${baseUrl}/twod/place-bet`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': window.appConfig.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    session: selectedSession,
                    bets: betsToSubmit,
                    total_amount: total
                })
            });

            let data = await res.json();

            if (res.ok && (data.status === 'success' || data.success === true)) {
                alert('2D ထိုးခြင်း အောင်မြင်ပါသည်။');
                
                for (let i = 0; i <= 99; i++) {
                    let code = String(i).padStart(2, '0');
                    amounts[code] = 0;
                    let inputEl = document.getElementById(`amt-${code}`);
                    if (inputEl) inputEl.value = 0;
                }
                calculateTwoDTotal();
                backToMain();
                fetchUserInfo();
            } else {
                alert('အမှားအယွင်းရှိသည်: ' + (data.message || 'မအောင်မြင်ပါ။'));
            }
        } catch (e) {
            console.error(e);
            alert('ဆာဗာသို့ ချိတ်ဆက်၍ မရပါ။');
        } finally {
            isSubmitting = false;
        }
    }

    function updateAmountVal(code, val) {
        let num = parseFloat(val);
        amounts[code] = isNaN(num) || num < 0 ? 0 : num;
        calculateTwoDTotal();
    }

    function adjustAmount(code, delta) {
        let current = amounts[code] || 0;
        current += delta;
        if (current < 0) current = 0;
        amounts[code] = current;
        let inputEl = document.getElementById(`amt-${code}`);
        if (inputEl) inputEl.value = current;
        calculateTwoDTotal();
    }

    function calculateTwoDTotal() {
        let total = 0;
        for (let key in amounts) {
            total += amounts[key];
        }
        let totalAmountLabel = document.getElementById('total-amount-label');
        if (totalAmountLabel) totalAmountLabel.innerText = total;
    }

    function openCardSelection(sessionName, isOpen, isDbOpen, isScheduleOpen) {
        if (!isDbOpen || !isScheduleOpen || !isOpen) {
            alert('ဤ Session မှာ လက်ရှိ ထိုး၍မရပါ။');
            return;
        }

        selectedSession = sessionName;
        let sessionTitle = document.getElementById('selected-session-title');
        if (sessionTitle) sessionTitle.innerText = `${sessionName} - (00-99) ထိုးရန်`;
        
        for (let i = 0; i <= 99; i++) {
            let code = String(i).padStart(2, '0');
            amounts[code] = 0;
            let inputEl = document.getElementById(`amt-${code}`);
            if (inputEl) inputEl.value = 0;
        }
        calculateTwoDTotal();

        let sessionList = document.getElementById('session-list');
        if (sessionList) sessionList.closest('.card').classList.add('d-none');
        let cardSelectionView = document.getElementById('card-selection-view');
        if (cardSelectionView) cardSelectionView.classList.remove('d-none');
    }

    function backToMain() {
        let sessionList = document.getElementById('session-list');
        if (sessionList) sessionList.closest('.card').classList.remove('d-none');
        let cardSelectionView = document.getElementById('card-selection-view');
        if (cardSelectionView) cardSelectionView.classList.add('d-none');
    }

    function toggleHistory() {
        switchTab('wallet', document.querySelector('.bottom-nav a:last-child'));
    }
    // Logout လုပ်ဆောင်ချက် (Token များကိုဖျက်ပြီး /register သို့ တိုက်ရိုက်ပို့ရန်)
function handleLogout() {
    // LocalStorage နှင့် Session Storage မှ token များကို ဖယ်ရှားခြင်း
    localStorage.removeItem('auth_token');
    localStorage.removeItem('token');
    sessionStorage.clear();
    
    // /register စာမျက်နှာသို့ တိုက်ရိုက် ပို့ဆောင်ခြင်း
    window.location.href = '/game-home';
}
</script>

<script>
    window.appConfig = {
        baseUrl: "{{ url('/') }}",
        userDocId: "{{ auth()->id() ?? '1' }}",
        userName: "{{ auth()->user()->name ?? 'Unknown' }}",
        userBalance: Number("{{ auth()->user()->balance ?? '0' }}"),
        csrfToken: "{{ csrf_token() }}"
    };
</script>

<script src="{{ asset('js/twod-script.js') }}"></script>

</body>
</html>