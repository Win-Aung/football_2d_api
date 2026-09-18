// အမြန်ရွေးချယ်မှု Modal ဖွင့်ရန်
function showQuickSelectModal() {
    let modal = document.getElementById('quick-select-modal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.classList.add('modal-open');
        
        // နောက်ခံ Backdrop ဖန်တီးရန် (မရှိသေးပါက)
        if (!document.querySelector('.modal-backdrop')) {
            let backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
    }
    renderQuickSelectButtons();
}

// အမြန်ရွေးချယ်မှု Modal ပိတ်ရန်
function closeQuickSelectModal() {
    let modal = document.getElementById('quick-select-modal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
        
        let backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }
}

// Flutter ဘက်ကကဲ့သို့ အမြန်ရွေးခလုတ်များကို တည်ဆောက်ခြင်း
function renderQuickSelectButtons() {
    let container = document.getElementById('quick-buttons-container');
    if (!container) return;
    
    // ခလုတ်အမျိုးအစားများနှင့် သက်ဆိုင်ရာ ဂဏန်းများစာရင်း
    const quickOptions = [
        { label: 'ကြီး', numbers: generateRange(55, 99) },
        { label: 'ငယ်', numbers: generateRange(0, 49) },
        { label: 'မ', numbers: ['01','03','05','07','09','11','13','15','17','19','21','23','25','27','29','31','33','35','37','39','41','43','45','47','49','51','57','59','61','63','65','67','69','71','73','75','77','79','81','83','85','87','89','91','93','95','97','99'] },
        { label: 'စုံ', numbers: ['00','02','04','06','08','10','12','14','16','18','20','22','24','26','28','30','32','34','36','38','40','42','44','46','48','50','52','54','56','58','60','62','64','66','68','70','72','74','76','78','80','82','84','86','88','90','92','94','96','98'] },
        { label: 'စုံစုံ', numbers: ['00','02','04','06','08','20','22','24','26','28','40','42','44','46','48','60','62','64','66','68','80','82','84','86','88'] },
        { label: 'စုံမ', numbers: ['01','03','05','07','09','21','23','25','27','29','41','43','45','47','49','61','63','65','67','69','81','83','85','87','89'] },
        { label: 'မစုံ', numbers: ['10','12','14','16','18','30','32','34','36','38','50','52','54','56','58','70','72','74','76','78','90','92','94','96','98'] },
        { label: 'မမ', numbers: ['11','13','15','17','19','31','33','35','37','39','51','53','55','57','59','71','73','75','77','79','91','93','95','97','99'] },
        { label: 'အပူး', numbers: ['11','22','33','44','55','66','77','88','99'] },
        { label: '0ထိပ်', numbers: generatePrefix(0) },
        { label: '1ထိပ်', numbers: generatePrefix(1) },
        { label: '2ထိပ်', numbers: generatePrefix(2) },
        { label: '3ထိပ်', numbers: generatePrefix(3) },
        { label: '4ထိပ်', numbers: generatePrefix(4) },
        { label: '5ထိပ်', numbers: generatePrefix(5) },
        { label: '6ထိပ်', numbers: generatePrefix(6) },
        { label: '7ထိပ်', numbers: ['70','71','72','73','74','75','77','78','79'] },
        { label: '8ထိပ်', numbers: ['80','81','82','83','84','85','86','87','88','89'] },
        { label: '9ထိပ်', numbers: generatePrefix(9) },
        { label: '0နောက်ပိတ်', numbers: generateSuffix(0) },
        { label: '1နောက်ပိတ်', numbers: generateSuffix(1) },
        { label: '2နောက်ပိတ်', numbers: generateSuffix(2) },
        { label: '3နောက်ပိတ်', numbers: generateSuffix(3) },
        { label: '4နောက်ပိတ်', numbers: generateSuffix(4) },
        { label: '5နောက်ပိတ်', numbers: generateSuffix(5) },
        { label: '6နောက်ပိတ်', numbers: generateSuffix(6) },
        { label: '7နောက်ပိတ်', numbers: generateSuffix(7) },
        { label: '8နောက်ပိတ်', numbers: generateSuffix(8) },
        { label: '9နောက်ပိတ်', numbers: generateSuffix(9) },
        { label: 'Constellation', numbers: ['07', '18', '24', '35', '69'] },
        { label: 'Constellation-R', numbers: ['79', '81', '42', '53', '96'] },
        { label: 'Power', numbers: ['05', '16', '27', '38', '49'] },
        { label: 'Power-R', numbers: ['50', '61', '72', '83', '94'] }
    ];

    let html = '';
    quickOptions.forEach(opt => {
        // Safe stringify for passing array into onclick function
        let jsonNums = JSON.stringify(opt.numbers).replace(/"/g, '&quot;');
        html += `
            <button type="button" class="btn btn-sm btn-outline-purple fw-bold px-3 py-1" 
                    style="border-color: #6f42c1; color: #6f42c1; background-color: #f8f4ff;"
                    onclick="applyQuickSelection(${jsonNums})">
                ${opt.label}
            </button>
        `;
    });
    container.innerHTML = html;
}

// ထူထောင်ရန် helper functions များ
function generateRange(start, end) {
    let arr = [];
    for (let i = start; i <= end; i++) {
        arr.push(String(i).padStart(2, '0'));
    }
    return arr;
}

function generatePrefix(digit) {
    let arr = [];
    for (let i = 0; i <= 9; i++) {
        arr.push(`${digit}${i}`);
    }
    return arr;
}

function generateSuffix(digit) {
    let arr = [];
    for (let i = 0; i <= 9; i++) {
        arr.push(`${i}${digit}`);
    }
    return arr;
}

// အမြန်ရွေးချယ်မှုကို နှိပ်လိုက်သည့်အခါ လက်ရှိ amounts များကို ၁၀၀ ကျပ်စီ ပေါင်းထည့်ပေးရန်
function applyQuickSelection(numbers) {
    numbers.forEach(numStr => {
        if (amounts.hasOwnProperty(numStr)) {
            amounts[numStr] = (parseInt(amounts[numStr]) || 0) + 100;
            let inputEl = document.getElementById(`amt-${numStr}`);
            if (inputEl) {
                inputEl.value = amounts[numStr];
            }
        }
    });
    calculateTwoDTotal();
    closeQuickSelectModal();
}

// Global variable for raw history data
let allTwoDHistoryList = [];

// မှတ်တမ်းခလုတ်ကို နှိပ်သည့်အခါ Modal ပေါ်လာစေရန်နှင့် API မှတ်တမ်းဆွဲရန်
function toggleHistory() {
    let modalEl = document.getElementById('twod-history-modal');
    if (modalEl) {
        modalEl.style.display = 'block';
        modalEl.classList.add('show');
    }
    
    let loadingEl = document.getElementById('twod-history-loading');
    let listEl = document.getElementById('twod-history-list');
    
    if (loadingEl) loadingEl.style.display = 'block';
    if (listEl) listEl.innerHTML = '';

    // Backend API မှတ်တမ်းခေါ်ယူခြင်း
    fetch(`${baseUrl}/twod/history`, {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(resData => {
        if (loadingEl) loadingEl.style.display = 'none';
        
        let historyList = [];
        if (Array.isArray(resData)) {
            historyList = resData;
        } else if (resData.data && Array.isArray(resData.data)) {
            historyList = resData.data;
        } else if (resData.bets && Array.isArray(resData.bets)) {
            historyList = resData.bets;
        }

        allTwoDHistoryList = historyList;
        renderDateFilterAndHistory(historyList);
    })
    .catch(err => {
        console.error('History Fetch Error:', err);
        if (loadingEl) loadingEl.style.display = 'none';
        if (listEl) {
            listEl.innerHTML = `<p class="text-center text-danger small">မှတ်တမ်း ရယူ၍ မရပါ။</p>`;
        }
    });
}

// ရက်စွဲအလိုက် စစ်ထုတ်ရန် Select Dropdown နှင့် List တည်ဆောက်ခြင်း
function renderDateFilterAndHistory(historyList) {
    let modalBody = document.querySelector('#twod-history-modal .modal-body');
    if (!modalBody) return;

    // ရက်စွဲများ (dates) ကို စုဆောင်းခြင်း
    let datesSet = new Set();
    historyList.forEach(item => {
        let fullDateStr = item.time || item.created_at || '';
        let dateOnly = fullDateStr.split(' ')[0]; // YYYY-MM-DD
        if (dateOnly) datesSet.add(dateOnly);
    });

    let datesArray = Array.from(datesSet).sort().reverse(); // အသစ်ဆုံးရက်ကို ရှေ့ဆုံးတင်ရန်

    // Filter UI Container ရှာရန် သို့မဟုတ် ဖန်တီးရန်
    let filterContainer = document.getElementById('twod-date-filter-container');
    if (!filterContainer) {
        filterContainer = document.createElement('div');
        filterContainer.id = 'twod-date-filter-container';
        filterContainer.className = 'mb-3';
        modalBody.insertBefore(filterContainer, document.getElementById('twod-history-loading'));
    }

    let optionsHtml = `<option value="all">အားလုံးပြရန်</option>`;
    datesArray.forEach(d => {
        optionsHtml += `<option value="${d}">${d}</option>`;
    });

    filterContainer.innerHTML = `
        <div class="d-flex align-items-center justify-content-between bg-light p-2 rounded border">
            <label class="fw-bold text-purple small mb-0"><i class="fas fa-calendar-alt me-1"></i> ရက်အလိုက်ကြည့်ရန်:</label>
            <select id="twod-date-select" class="form-select form-select-sm w-auto fw-bold" onchange="filterTwoDHistoryByDate(this.value)">
                ${optionsHtml}
            </select>
        </div>
    `;

    // ပထမအကြိမ်တွင် နောက်ဆုံးရက် (သို့မဟုတ် အားလုံး) ဖြင့် ပြရန်
    renderTwoDBetHistoryModalList(historyList);
}

// ရွေးချယ်ထားသော ရက်စွဲအလိုက် စစ်ထုတ်ပြသခြင်း
function filterTwoDHistoryByDate(selectedDate) {
    if (selectedDate === 'all') {
        renderTwoDBetHistoryModalList(allTwoDHistoryList);
    } else {
        let filtered = allTwoDHistoryList.filter(item => {
            let fullDateStr = item.time || item.created_at || '';
            return fullDateStr.startsWith(selectedDate);
        });
        renderTwoDBetHistoryModalList(filtered);
    }
}

// Modal ပိတ်ရန် Function
function closeTwoDHistoryModal() {
    let modalEl = document.getElementById('twod-history-modal');
    if (modalEl) {
        modalEl.style.display = 'none';
        modalEl.classList.remove('show');
    }
}

// မှတ်တမ်းစာရင်းများကို Modal အတွင်း HTML ဖြင့် တည်ဆောက်ခြင်း
function renderTwoDBetHistoryModalList(historyList) {
    let listEl = document.getElementById('twod-history-list');
    if (!listEl) return;

    if (historyList.length === 0) {
        listEl.innerHTML = `<p class="text-center text-muted small my-3">မှတ်တမ်း မရှိသေးပါ။</p>`;
        return;
    }

    let html = '';
    historyList.forEach(item => {
        let bets = [];
        try {
            let rawBets = item.bets;
            if (typeof rawBets === 'string') {
                let decoded = JSON.parse(rawBets);
                if (typeof decoded === 'string') decoded = JSON.parse(decoded);
                if (Array.isArray(decoded)) bets = decoded;
            } else if (Array.isArray(rawBets)) {
                bets = rawBets;
            }
        } catch (e) {
            console.error('Bet parse error:', e);
        }

        let winningNumber = item.winning_number ? String(item.winning_number) : '';
        let totalWinAmount = 0;

        bets.forEach(bet => {
            if (bet && bet.win_amount) {
                totalWinAmount += parseFloat(bet.win_amount) || 0;
            }
        });

        if (totalWinAmount === 0 && item.win_amount) {
            totalWinAmount = parseFloat(item.win_amount) || 0;
        }

        let betsHtml = '';
        bets.forEach(bet => {
            if (!bet) return;
            let betNum = bet.number ? String(bet.number) : '';
            let betStatus = bet.status ? String(bet.status) : '';
            let betWinAmount = parseFloat(bet.win_amount || 0);

            let isWinningBet = (betStatus === 'win' || betWinAmount > 0) || (winningNumber !== '' && betNum === winningNumber);
            
            let badgeBg = isWinningBet ? '#d1e7dd' : '#f8f4ff';
            let borderColor = isWinningBet ? '#198754' : '#dcd6f7';
            let textColor = isWinningBet ? '#0f5132' : '#212529';
            let borderWidth = isWinningBet ? '1.5px' : '1px';

            let betText = betWinAmount > 0 
                ? `${betNum} (${bet.amount}ကျပ်) - နိုင်ငွေ: ${Math.floor(betWinAmount)}ကျပ်`
                : `${betNum} (${bet.amount}ကျပ်)`;

            betsHtml += `
                <span class="badge" style="background-color: ${badgeBg}; border: ${borderWidth} solid ${borderColor}; color: ${textColor}; font-size: 12px; padding: 5px 8px; font-weight: bold;">
                    ${betText}
                </span>
            `;
        });

        html += `
            <div class="card shadow-sm border rounded-3 p-2 mb-2 bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge px-2 py-1" style="background-color: #6f42c1; font-size: 12px;">
                        ချိန်: ${item.session || '-'}
                    </span>
                    <span class="fw-bold text-success" style="font-size: 13px;">
                        စုစုပေါင်း: ${item.total_amount || 0} ကျပ်
                    </span>
                </div>
                <hr class="my-1 text-muted opacity-25">
                <div class="d-flex justify-content-between align-items-center small text-muted mb-1" style="font-size: 11px;">
                    <span>ရက်စွဲ: ${item.time || item.created_at || ''}</span>
                    ${totalWinAmount > 0 ? `<span class="fw-bold text-success">နိုင်ငွေ: ${totalWinAmount} ကျပ်</span>` : ''}
                </div>
                <div class="d-flex flex-wrap gap-1 mt-1">
                    ${betsHtml}
                </div>
            </div>
        `;
    });

    listEl.innerHTML = html;
}

// မှတ်တမ်းဟောင်းများ Modal ဖွင့်ရန် (နောက်ဆုံးရလာဒ် ၁၀ ခု)
function openOldHistoryModal() {
    let modalEl = document.getElementById('oldHistoryModal');
    if (modalEl) {
        modalEl.style.display = 'block';
        modalEl.classList.add('show');
        document.body.classList.add('modal-open');
    }

    let loadingEl = document.getElementById('old-history-loading');
    let listEl = document.getElementById('old-history-list');

    if (loadingEl) loadingEl.style.display = 'block';
    if (listEl) listEl.innerHTML = '';

    // အမှန်တကယ်အသုံးပြုရမည့် API လိပ်စာ
    fetch('https://api.2dboss.com/api/lv/bkk_towd_result', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(resData => {
        if (loadingEl) loadingEl.style.display = 'none';

        // API မှ ရလာသော data (သို့မဟုတ် result) ဇယားကို ယူခြင်း
        let payload = resData.data || resData.result || resData;
        let historyList = [];

        if (Array.isArray(payload)) {
            historyList = payload;
        } else if (payload && typeof payload === 'object') {
            if (Array.isArray(payload.history)) {
                historyList = payload.history;
            } else if (Array.isArray(payload.list)) {
                historyList = payload.list;
            } else {
                // အကယ်၍ အော့ဘဂျက်ဖြစ်နေပါက အကောင်အထည်ဖော်ရန်
                historyList = Object.values(payload);
            }
        }

        // 🛑 နောက်ဆုံးရလာဒ် အများဆုံး ၁၀ ခု (Last 10 results) သာ ကန့်သတ်ယူရန်
        historyList = historyList.slice(0, 10);

        renderOldHistoryListByDate(historyList);
    })
    .catch(err => {
        console.error('Old History Fetch Error:', err);
        if (loadingEl) loadingEl.style.display = 'none';
        if (listEl) {
            listEl.innerHTML = `<p class="text-center text-danger small">မှတ်တမ်းဟောင်းများ ရယူ၍ မရပါ။</p>`;
        }
    });
}

// မှတ်တမ်းဟောင်းများ Modal ပိတ်ရန်
function closeOldHistoryModal() {
    let modalEl = document.getElementById('oldHistoryModal');
    if (modalEl) {
        modalEl.style.display = 'none';
        modalEl.classList.remove('show');
        document.body.classList.remove('modal-open');
    }
}

// ရက်စွဲအလိုက် Session ၄ ခုစီပါသော ကပ်ဒ်များ တည်ဆောက်ခြင်း (အများဆုံး ၁၀ ခု)
function renderOldHistoryListByDate(historyList) {
    let listEl = document.getElementById('old-history-list');
    if (!listEl) return;

    if (!historyList || historyList.length === 0) {
        listEl.innerHTML = `<p class="text-center text-muted small my-3">မှတ်တမ်းဟောင်းများ မရှိသေးပါ။</p>`;
        return;
    }

    let html = '';
    historyList.forEach(item => {
        let dateStr = item.date || item.last_date || item.created_at || 'ရက်စွဲမရှိ';

        // Session ၄ ခုစာ အချက်အလက်များကို ထုတ်ယူခြင်း
        let sessions = [
            { name: '11:00 AM', set: item.set_1100 || '-', val: item.val_1100 || '-', result: item.result_1100 || '-' },
            { name: '12:00 PM', set: item.set_1200 || '-', val: item.val_1200 || '-', result: item.result_1200 || '-' },
            { name: '3:00 PM', set: item.set_300 || '-', val: item.val_300 || '-', result: item.result_300 || '-' },
            { name: '4:30 PM', set: item.set_430 || '-', val: item.val_430 || '-', result: item.result_430 || '-' }
        ];

        let sessionsHtml = '';
        sessions.forEach(sess => {
            sessionsHtml += `
                <div class="d-flex justify-content-between align-items-center p-2 mb-1 bg-light rounded border-start border-4 border-purple" style="border-left-color: #6f42c1 !important;">
                    <div>
                        <span class="fw-bold text-purple" style="font-size: 13px;">${sess.name}</span>
                        <div class="text-muted" style="font-size: 10px;">SET: ${sess.set} | VALUE: ${sess.val}</div>
                    </div>
                    <span class="badge bg-purple px-2 py-1" style="background-color: #6f42c1; font-size: 13px;">${sess.result}</span>
                </div>
            `;
        });

        html += `
            <div class="card shadow-sm border rounded-3 p-3 mb-3 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                    <span class="fw-bold text-dark" style="font-size: 13px;">
                        <i class="fas fa-calendar-day text-purple me-1"></i> ရက်စွဲ: ${dateStr}
                    </span>
                </div>
                <div class="vstack gap-1">
                    ${sessionsHtml}
                </div>
            </div>
        `;
    });

    listEl.innerHTML = html;
}

// ပိတ်ရက်များ Modal ဖွင့်ရန်
function openHolidayModal() {
    let modalEl = document.getElementById('holidayModal');
    if (modalEl) {
        modalEl.style.display = 'block';
        modalEl.classList.add('show');
        document.body.classList.add('modal-open');
    }

    let loadingEl = document.getElementById('holiday-loading');
    let listEl = document.getElementById('holiday-list');

    if (loadingEl) loadingEl.style.display = 'block';
    if (listEl) listEl.innerHTML = '';

    // API မှ ပိတ်ရက်စာရင်းများ ယူခြင်း
    fetch('https://api.2dboss.com/api/lv/holiday_list', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(resData => {
        if (loadingEl) loadingEl.style.display = 'none';

        let payload = resData.data || resData.result || resData;
        let holidayList = [];

        if (Array.isArray(payload)) {
            holidayList = payload;
        } else if (payload && typeof payload === 'object') {
            if (Array.isArray(payload.holidays)) {
                holidayList = payload.holidays;
            } else if (Array.isArray(payload.list)) {
                holidayList = payload.list;
            } else {
                holidayList = Object.values(payload);
            }
        }

        renderHolidayList(holidayList);
    })
    .catch(err => {
        console.error('Holiday Fetch Error:', err);
        if (loadingEl) loadingEl.style.display = 'none';
        if (listEl) {
            listEl.innerHTML = `<p class="text-center text-danger small py-3">ပိတ်ရက်စာရင်းများ ရယူ၍ မရပါ။</p>`;
        }
    });
}

// ပိတ်ရက်များ Modal ပိတ်ရန်
function closeHolidayModal() {
    let modalEl = document.getElementById('holidayModal');
    if (modalEl) {
        modalEl.style.display = 'none';
        modalEl.classList.remove('show');
        document.body.classList.remove('modal-open');
    }
}

// ပိတ်ရက်စာရင်းများကို Modal ထဲတွင် ကပ်ဒ်ပုံစံဖြင့် ထည့်သွင်းခြင်း
function renderHolidayList(holidayList) {
    let listEl = document.getElementById('holiday-list');
    if (!listEl) return;

    if (!holidayList || holidayList.length === 0) {
        listEl.innerHTML = `<p class="text-center text-muted small py-3">ပိတ်ရက်စာရင်းများ မရှိသေးပါ။</p>`;
        return;
    }

    let html = '';
    holidayList.forEach((item, index) => {
        let dateStr = item.date || item.holiday_date || item.start_date || 'ရက်စွဲမရှိ';
        let descStr = item.description || item.title || item.reason || item.name || 'အကြောင်းအရာ မရှိပါ';

        html += `
            <div class="card shadow-sm border rounded-3 p-2.5 mb-2 bg-light border-start border-4 border-danger" style="border-left-color: #dc3545 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fw-bold text-dark" style="font-size: 13px;">
                            <i class="fas fa-calendar-day text-danger me-1"></i> ${dateStr}
                        </span>
                        <div class="text-muted small mt-1" style="font-size: 12px;">${descStr}</div>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1" style="font-size: 11px;">ပိတ်ရက်</span>
                </div>
            </div>
        `;
    });

    listEl.innerHTML = html;
}