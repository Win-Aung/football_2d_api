// 🌙 Dark Mode Toggle လုပ်ဆောင်ချက်
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    let isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('adminDarkMode', isDark ? 'enabled' : 'disabled');
    updateDarkModeIcon(isDark);
}

function updateDarkModeIcon(isDark) {
    let icon = document.getElementById('darkModeIcon');
    if (icon) {
        icon.className = isDark ? 'fa-solid fa-sun me-1' : 'fa-solid fa-moon me-1';
    }
}

// 🟢 စာမျက်နှာ Refresh ဖြစ်သည့်အခါ ယခင်ရွေးထားသော Mode အတိုင်း ဆက်လက်ရှိနေစေရန်
document.addEventListener("DOMContentLoaded", function() {
    if (localStorage.getItem('adminDarkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
        updateDarkModeIcon(true);
    }
});

// 🟢 ပထမအကြိမ် Load လုပ်ချိန်တွင် လပေါင်းများစွာကို Dropdown ထဲသို့ ထည့်သွင်းပေးခြင်း
document.addEventListener("DOMContentLoaded", function() {
    populateMonthlyDropdown();
});

function populateMonthlyDropdown() {
    let dropdown = document.getElementById('monthlyDropdown');
    if (!dropdown) return;

    dropdown.innerHTML = '';
    let currentDate = new Date();
    
    // လွန်ခဲ့သော လ ၁၂ လစာ (သို့ လိုသလောက်) ထည့်သွင်းပေးခြင်း
    for (let i = 0; i < 12; i++) {
        let d = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
        let year = d.getFullYear();
        let month = String(d.getMonth() + 1).padStart(2, '0');
        let value = `${year}-${month}`;
        
        // မြန်မာဘာသာ သို့မဟုတ် လအမည်ပြသရန် (ဥပမာ - September 2026)
        let label = d.toLocaleString('en-US', { month: 'long', year: 'numeric' });
        
        let option = document.createElement('option');
        option.value = value;
        option.textContent = label;
        dropdown.appendChild(option);
    }
}

// 🟢 Dropdown မှ လကို ပြောင်းလဲလိုက်တိုင်း API ကို ထိုလ (Month) ပါ ထည့်ခေါ်မည်
function onMonthlyDropdownChange() {
    let dropdown = document.getElementById('monthlyDropdown');
    if (!dropdown) return;
    let selectedMonth = dropdown.value;
    fetchDashboardSummary(selectedMonth);
}

// 📊 Dashboard API ကို နေ့စဉ်နှင့် ရွေးချယ်ထားသော လအလိုက် ဆွဲထုတ်ခြင်း (Modified)
function fetchDashboardSummary(month = '') {
    let url = `${window.baseUrl}/api/admin/dashboard`;
    if (month) {
        url += `?month=${month}`;
    }

    fetch(url, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success' && res.data) {
            let d = res.data;

            // 📅 ဒိုင်၏ နေ့စဥ် အနိုင် / အရှုံး စာရင်း Data Binding
            if (d.daily) {
                document.getElementById('daily-win').innerText = Number(d.daily.win || 0).toLocaleString() + ' ကျပ်';
                document.getElementById('daily-loss').innerText = Number(d.daily.loss || 0).toLocaleString() + ' ကျပ်';
                document.getElementById('daily-deposit').innerText = Number(d.daily.deposit || 0).toLocaleString() + ' ကျပ်';
                document.getElementById('daily-withdraw').innerText = Number(d.daily.withdraw || 0).toLocaleString() + ' ကျပ်';
                
                let dailyNetEl = document.getElementById('daily-net');
                if (dailyNetEl) {
                    dailyNetEl.innerText = Number(d.daily.net || 0).toLocaleString() + ' ကျပ်';
                    dailyNetEl.className = d.daily.net >= 0 ? 'text-success fw-bold' : 'text-danger fw-bold';
                }
            }

            // 🗓️ ဒိုင်၏ လစဥ် အနိုင် / အရှုံး စာရင်း Data Binding (ရွေးချယ်ထားသော လအလိုက်)
            if (d.monthly) {
                document.getElementById('monthly-win').innerText = Number(d.monthly.win || 0).toLocaleString() + ' ကျပ်';
                document.getElementById('monthly-loss').innerText = Number(d.monthly.loss || 0).toLocaleString() + ' ကျပ်';
                document.getElementById('monthly-deposit').innerText = Number(d.monthly.deposit || 0).toLocaleString() + ' ကျပ်';
                document.getElementById('monthly-withdraw').innerText = Number(d.monthly.withdraw || 0).toLocaleString() + ' ကျပ်';
                
                let monthlyNetEl = document.getElementById('monthly-net');
                if (monthlyNetEl) {
                    monthlyNetEl.innerText = Number(d.monthly.net || 0).toLocaleString() + ' ကျပ်';
                    monthlyNetEl.className = d.monthly.net >= 0 ? 'text-success fw-bold' : 'text-danger fw-bold';
                }
            }
        }
    })
    .catch(error => console.error('Error fetching dashboard summary:', error));
}

window.baseUrl = window.baseUrl || (window.Laravel ? window.Laravel.baseUrl : '');
window.apiToken = window.Laravel ? window.Laravel.token : '';

async function openPaymentSettings() {
    try {
        let res = await fetch(`${window.baseUrl}/api/config/payment`, {
            method: 'GET',
            headers: { 
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            }
        });
        
        let data = await res.json();
        
        if (res.ok && data) {
            document.getElementById('qrUrlInput').value = data.qrUrl || '';
            document.getElementById('phoneInput').value = data.phone || '';
            
            let qrImg = document.getElementById('previewQr');
            if (data.qrUrl) {
                qrImg.src = data.qrUrl;
                qrImg.style.display = 'inline-block';
            } else {
                qrImg.style.display = 'none';
            }
        }
    } catch (e) {
        console.error('Error fetching payment config:', e);
    }

    var paymentModal = new bootstrap.Modal(document.getElementById('paymentSettingsModal'));
    paymentModal.show();
}

async function savePaymentSettings() {
    let qrUrl = document.getElementById('qrUrlInput').value;
    let phone = document.getElementById('phoneInput').value;

    try {
        let res = await fetch(`${window.baseUrl}/api/config/payment/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({ 
                qrUrl: qrUrl, 
                phone: phone 
            })
        });
        
        let result = await res.json();

        if (res.ok) {
            alert('ငွေပေးချေမှု အချက်အလက်များ အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။');
            var modalEl = document.getElementById('paymentSettingsModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        } else {
            alert('သိမ်းဆည်းရာတွင် အမှားအယွင်း ရှိနေပါသည်။ (Error: ' + (result.message || res.statusText) + ')');
        }
    } catch (e) {
        console.error('Error saving payment config:', e);
    }
}

document.addEventListener("DOMContentLoaded", function() {
    fetchUsers();
    fetchAnnouncedMatches();

    setInterval(fetchAnnouncedMatches, 5000);
    
    // Refresh ဖြစ်သွားလျှင် ယခင်က နေခဲ့သော Tab ဆီသို့ ပြန်သွားရန်
    let savedTab = localStorage.getItem('activeAdminTab');
    if (savedTab) {
        switchTab(savedTab, null);
    }
});

let allUsersData = [];
let currentPage = 1;
const rowsPerPage = 10;

function fetchUsers() {
    fetch(`${window.baseUrl}/api/users`, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(users => {
        allUsersData = users || [];
        renderTablePage(currentPage);
    })
    .catch(error => console.error('Error fetching users:', error));
}

function renderTablePage(page) {
    let tbody = document.getElementById('users-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (!allUsersData || allUsersData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center py-5 text-muted"><i class="fa-solid fa-folder-open fs-3 mb-2 d-block text-secondary opacity-50"></i>မှတ်ပုံတင်ထားသော User များ မရှိသေးပါ။</td></tr>`;
        renderPaginationControls(0);
        return;
    }

    let start = (page - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    let paginatedItems = allUsersData.slice(start, end);

    paginatedItems.forEach(user => {
        let paymentVal = user.payment ?? 'KBZPay';
        let badgeColor = 'bg-secondary';
        let pLower = paymentVal.toLowerCase();

        // Payment အလိုက် အရောင်သတ်မှတ်ခြင်း
        if (pLower.includes('kbz')) {
            badgeColor = 'bg-primary'; // အပြာရောင်
        } else if (pLower.includes('aya')) {
            badgeColor = 'bg-danger'; // အနီရောင်
        } else if (pLower.includes('wave')) {
            badgeColor = 'bg-warning text-dark'; // အဝါရောင်
        }

        tbody.innerHTML += `
            <tr>
                <td class="py-3 px-3 fw-bold text-dark">${user.name ?? 'အမည်မရှိ'}</td>
                <td class="py-3 px-3 text-muted">${user.phone ?? '-'}</td>
                <td class="py-3 px-3">
                    <span class="badge ${badgeColor} px-2.5 py-1 fw-semibold">${paymentVal}</span>
                </td>
                <td class="py-3 px-3 fw-bold text-success">${Number(user.balance ?? 0).toLocaleString()} ကျပ်</td>
                <td class="py-3 px-3 text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-outline-primary btn-sm px-2 py-1" onclick="editUser(${user.id})" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm px-2 py-1" onclick="deleteUserConfirm(${user.id})" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    renderPaginationControls(Math.ceil(allUsersData.length / rowsPerPage));
}

function renderPaginationControls(totalPages) {
    let cardBody = document.querySelector('#users-tab .card-body');
    let existingPagination = document.getElementById('userPaginationContainer');
    if (existingPagination) existingPagination.remove();

    if (totalPages <= 1) return;

    let paginationDiv = document.createElement('div');
    paginationDiv.id = 'userPaginationContainer';
    paginationDiv.className = 'd-flex justify-content-between align-items-center mt-3 pt-3 border-top';

    let infoText = document.createElement('small');
    infoText.className = 'text-muted';
    infoText.innerText = `စာမျက်နှာ ${currentPage} / ${totalPages}`;
    paginationDiv.appendChild(infoText);

    let ul = document.createElement('ul');
    ul.className = 'pagination pagination-sm m-0';

    let prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<button class="page-link" onclick="changePage(${currentPage - 1})">ရှေ့သို့</button>`;
    ul.appendChild(prevLi);

    for (let i = 1; i <= totalPages; i++) {
        let li = document.createElement('li');
        li.className = `page-item ${currentPage === i ? 'active' : ''}`;
        li.innerHTML = `<button class="page-link" onclick="changePage(${i})">${i}</button>`;
        ul.appendChild(li);
    }

    let nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<button class="page-link" onclick="changePage(${currentPage + 1})">နောက်သို့</button>`;
    ul.appendChild(nextLi);

    paginationDiv.appendChild(ul);
    cardBody.appendChild(paginationDiv);
}

function changePage(page) {
    let totalPages = Math.ceil(allUsersData.length / rowsPerPage);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderTablePage(currentPage);
}

function editUser(id) {
    let user = allUsersData.find(u => u.id === id);
    if (!user) return;

    document.getElementById('editUserId').value = user.id;
    document.getElementById('editUserName').value = user.name || '';
    document.getElementById('editUserPhone').value = user.phone || '';
    document.getElementById('editUserPayment').value = user.payment || 'KBZPay';
    document.getElementById('editUserBalance').value = user.balance || 0;

    var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editModal.show();
}

async function updateUser() {
    let id = document.getElementById('editUserId').value;
    let name = document.getElementById('editUserName').value;
    let phone = document.getElementById('editUserPhone').value;
    let payment = document.getElementById('editUserPayment').value;
    let balance = document.getElementById('editUserBalance').value;

    try {
        let res = await fetch(`${window.baseUrl}/api/user/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({ userId: id, name, phone, payment, balance })
        });

        let result = await res.json();

        if (res.ok && result.status === 'success') {
            alert('အချက်အလက်များ အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
            var modalEl = document.getElementById('editUserModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            fetchUsers(); 
        } else {
            alert('ပြင်ဆင်ရာတွင် အမှားအယွင်း ရှိနေပါသည်။ (Error: ' + (result.message || res.statusText) + ')');
        }
    } catch (e) {
        console.error('Error updating user:', e);
    }
}

let deleteUserId = null;

function deleteUserConfirm(id) {
    deleteUserId = id;
    if (confirm('ဒီ User ကို ဖျက်ရန် သေချာပါသလား?')) {
        executeDeleteUser();
    }
}

async function executeDeleteUser() {
    if (!deleteUserId) return;

    try {
        let res = await fetch(`${window.baseUrl}/api/user/delete`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({ user_id: deleteUserId })
        });

        let result = await res.json();

        if (res.ok && result.status === 'success') {
            alert('User ကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
            fetchUsers(); // ဇယားကို ဒေတာအသစ်ဖြင့် ပြန်လည်ဆွဲရန်
        } else {
            alert('ဖျက်ရာတွင် အမှားအယွင်း ရှိနေပါသည်။ (Error: ' + (result.message || res.statusText) + ')');
        }
    } catch (e) {
        console.error('Error deleting user:', e);
    }
}

// Modal ပွင့်လာပါက ဒေတာဘေစ်ထဲရှိ league_name များကို Dropdown (<select>) ထဲသို့ ထည့်သွင်းခြင်း
function openAddLeagueModal() {
    document.getElementById('addLeagueForm').reset();
    document.getElementById('leagueErrorMsg').classList.add('d-none');
    document.getElementById('leagueSuccessMsg').classList.add('d-none');
    document.getElementById('newLeagueContainer').classList.add('d-none');
    
    // API မှ League များကို Fetch လုပ်ခြင်း
    fetch(`${window.baseUrl}/api/leagues`, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        let selectBox = document.getElementById('league_name');
        // ပုံမှန် Option များကိုသာ ချန်ပြီး ကျန်သည်များကို ရှင်းထုတ်မည်
        selectBox.innerHTML = `
            <option value="">-- League တစ်ခု ရွေးပါ --</option>
            <option value="NEW_LEAGUE">➕ League အသစ်ထည့်မည်</option>`;
        
        let leagues = response.data || [];
        leagues.forEach(lg => {
            let opt = document.createElement('option');
            opt.value = lg.league_name;
            opt.textContent = lg.league_name;
            selectBox.appendChild(opt);
        });
    })
    .catch(err => console.error('Error fetching leagues:', err));

    var myModal = new bootstrap.Modal(document.getElementById('addLeagueModal'));
    myModal.show();
}

// "League အသစ်ထည့်မည်" ကို ရွေးမှ Input အသစ်ပေါ်လာစေရန်
function checkNewLeague(select) {
    let container = document.getElementById('newLeagueContainer');
    if (select.value === 'NEW_LEAGUE') {
        container.classList.remove('d-none');
        document.getElementById('new_league_name').focus();
    } else {
        container.classList.add('d-none');
        document.getElementById('new_league_name').value = '';
    }
}

// ဒေတာ ပို့ဆောင်သည့်အခါ League အသစ်လား၊ ရှိပြီးသားလား စစ်ဆေးခြင်း
function submitLeagueData() {
    let leagueSelect = document.getElementById('league_name').value;
    let leagueName = leagueSelect;

    if (leagueSelect === 'NEW_LEAGUE') {
        leagueName = document.getElementById('new_league_name').value.trim();
    }
    
    let teams = document.getElementById('teams').value.trim();
    let errorBox = document.getElementById('leagueErrorMsg');
    let successBox = document.getElementById('leagueSuccessMsg');
    
    errorBox.classList.add('d-none');
    successBox.classList.add('d-none');

    if (!leagueName) {
        errorBox.innerText = 'ကျေးဇူးပြု၍ League အမည်ကို ရွေးချယ်ပါ (သို့) ထည့်သွင်းပါ။';
        errorBox.classList.remove('d-none');
        return;
    }

    fetch(`${window.baseUrl}/api/football/add-league`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        },
        body: JSON.stringify({
            league_name: leagueName,
            teams: teams
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' || data.success === true) {
            successBox.innerText = data.message || 'အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။';
            successBox.classList.remove('d-none');
            setTimeout(() => {
                var myModalEl = document.getElementById('addLeagueModal');
                var modal = bootstrap.Modal.getInstance(myModalEl);
                modal.hide();
                location.reload(); 
            }, 1500);
        } else {
            errorBox.innerText = data.message || 'အချက်အလက် ထည့်သွင်းရာတွင် အမှားရှိနေပါသည်။';
            errorBox.classList.remove('d-none');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorBox.innerText = 'ဆာဗာသို့ ချိတ်ဆက်၍ မရပါ။';
        errorBox.classList.remove('d-none');
    });
}

document.addEventListener("DOMContentLoaded", function () {
    fetchPendingRequests();

    
    // Flutter Admin Dashboard ကဲ့သို့ ၅ စက္ကန့်တစ်ကြိမ် အလိုအလျောက် Refresh လုပ်ရန်
    setInterval(fetchPendingRequests, 5000);
});

document.addEventListener('click', function() {
    let audio = document.getElementById('notificationSound');
    if (audio) {
        audio.play().then(() => {
            audio.pause();
            audio.currentTime = 0;
        }).catch(e => console.log('Audio unlock blocked:', e));
    }
}, { once: true });

let lastPendingCount = null; // ယခင်က Pending အရေအတွက်ကို မှတ်ထားရန်

function fetchPendingRequests() {
    fetch(`${window.baseUrl}/api/requests`, {
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        }
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            let requests = res.data;
            let pendingList = requests.filter(req => req.status === 'Pending');
            let currentCount = pendingList.length;

            // ပထမအကြိမ် API ခေါ်ချိန်တွင် လက်ရှိအရေအတွက်ကိုသာ မှတ်မည် (အသံမမြည်စေရန်)
            if (lastPendingCount === null) {
                lastPendingCount = currentCount;
            } 
            // ယခင်အရေအတွက်ထက် လက်ရှိ Pending အရေအတွက် ပိုများလာမှသာ (deposit အသစ်ဝင်လာမှသာ) အသံမြည်မည်
            else if (currentCount > lastPendingCount) {
                let audio = document.getElementById('notificationSound');
                if (audio) {
                    audio.play().catch(e => console.log('Audio play blocked:', e));
                }
            }
            
            // အရေအတွက် အပြောင်းအလဲရှိ든 မရှိ든 နောက်ဆုံးအခြေအနေကို ပြန်အပ်မည်
            lastPendingCount = currentCount;

            document.getElementById('pending-count').innerText = currentCount;

            let tbody = document.getElementById('pending-requests-tbody');
            tbody.innerHTML = '';

            if (pendingList.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center">အတည်ပြုရန် ကျန်ရှိနေသော တောင်းဆိုမှုများ မရှိပါ။</td></tr>`;
                return;
            }

            pendingList.forEach(req => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${req.id}</td>
                    <td>${req.user_name || (req.user ? req.user.name : '-')}</td>
                    <td><span class="badge ${req.type === 'deposit' ? 'bg-success' : 'bg-danger'}">${req.type}</span></td>
                    <td>${req.amount} ကျပ်</td>
                    <td>${req.payment}</td>
                    <td>${req.transactionId || '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="approveRequest(${req.id})">အတည်ပြုမည်</button>
                        <button class="btn btn-sm btn-danger" onclick="rejectRequest(${req.id})">ပယ်ချမည်</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    })
    .catch(error => console.error('Error fetching requests:', error));
}

async function approveRequest(requestId) {
    try {
        let response = await fetch(`${window.Laravel.baseUrl}/api/requests`, {
            headers: {
                'Authorization': `Bearer ${window.Laravel.token}`,
                'Accept': 'application/json'
            }
        });
        let result = await response.json();
        
        if (result.status === 'success') {
            // ဒေတာဘေ့စ်မှ လابလာသော စာရင်းထဲမှ လက်ရှိ ID နှင့် ကိုက်ညီသော အချက်အလက်ကို ရှာမည်
            let matchedReq = result.data.find(req => req.id == requestId);
            
            if (matchedReq) {
                document.getElementById('approveRequestId').value = matchedReq.id;
                document.getElementById('approveAmountDisplay').value = matchedReq.amount ?? '';
                document.getElementById('approveTransactionId').value = matchedReq.transactionId ?? '';
            }
        }
    } catch (error) {
        console.error('Error fetching request data:', error);
    }

    var myModal = new bootstrap.Modal(document.getElementById('approveDepositModal'));
    myModal.show();
}

async function confirmApproveDeposit() {
    let requestId = document.getElementById('approveRequestId').value;
    let transactionId = document.getElementById('approveTransactionId').value;

    try {
        let res = await fetch(`${window.baseUrl}/api/request/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({ 
                request_id: requestId,
                transaction_id: transactionId 
            })
        });

        let resJson = await res.json();
        if (res.ok && resJson.status === 'success') {
            alert(resJson.message || 'ငွေသွင်းခြင်းကို အောင်မြင်စွာ အတည်ပြုပြီး User အကောင့်သို့ ပေါင်းထည့်ပြီးပါပြီ။');
            var modalEl = document.getElementById('approveDepositModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            fetchPendingRequests();
            fetchUsers();
        } else {
            alert('အမှားအယွင်း ဖြစ်ပွားခဲ့သည်: ' + (resJson.message || ''));
        }
    } catch (e) {
        console.error('Error approving request:', e);
    }
}

function rejectRequest(requestId) {
    let reason = prompt('ပယ်ချရသည့် အကြောင်းအရင်းကို ထည့်ပါ:');
    if (reason === null) return;
    
    fetch(`${window.baseUrl}/api/request/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        },
        body: JSON.stringify({ request_id: requestId, reason: reason })
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            alert(res.message);
            fetchPendingRequests();
        } else {
            alert('အမှားအယွင်း ဖြစ်ပွားခဲ့သည်');
        }
    })
    .catch(error => console.error('Error rejecting request:', error));
}


//payment table 

let allPaymentRequestsData = [];
let currentPaymentPage = 1;
const paymentRowsPerPage = 10;
let filteredPaymentData = [];

document.addEventListener("DOMContentLoaded", function() {
    fetchPaymentRequestsTab();
});

function fetchPaymentRequestsTab() {
    fetch(`${window.baseUrl}/api/requests`, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            allPaymentRequestsData = res.data || [];
            filteredPaymentData = allPaymentRequestsData;
            renderPaymentTablePage(currentPaymentPage);
        }
    })
    .catch(error => console.error('Error fetching payment requests:', error));
}

function renderPaymentTablePage(page) {
    let tbody = document.getElementById('payment-requests-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (!filteredPaymentData || filteredPaymentData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-4 text-muted">ငွေပေးချေမှု တောင်းဆိုချက်များ မရှိသေးပါ။</td></tr>`;
        renderPaymentPaginationControls(0);
        return;
    }

    let start = (page - 1) * paymentRowsPerPage;
    let end = start + paymentRowsPerPage;
    let paginatedItems = filteredPaymentData.slice(start, end);

    paginatedItems.forEach(req => {
        let typeBadge = req.type === 'deposit' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger';
        let statusBadge = req.status === 'approved' ? 'bg-success' : (req.status === 'reject' ? 'bg-danger' : 'bg-warning text-dark');
        
        tbody.innerHTML += `
            <tr>
                <td class="py-3 px-3">
                    <input type="checkbox" class="form-check-input payment-checkbox" value="${req.id}">
                </td>
                <td class="py-3 px-3 fw-semibold text-secondary">#${req.id}</td>
                <td class="py-3 px-3 fw-bold text-dark">${req.userName || (req.user ? req.user.name : '-')}</td>
                <td class="py-3 px-3 text-muted">${req.phone || '-'}</td>
                <td class="py-3 px-3"><span class="badge ${typeBadge} px-2 py-1">${req.type}</span></td>
                <td class="py-3 px-3 fw-bold text-success">${Number(req.amount || 0).toLocaleString()} ကျပ်</td>
                <td class="py-3 px-3"><span class="badge bg-light text-dark border">${req.payment || '-'}</span></td>
                <td class="py-3 px-3 font-monospace text-muted small">${req.transactionId || '-'}</td>
                <td class="py-3 px-3"><span class="badge ${statusBadge}">${req.status}</span></td>
                <td class="py-3 px-3 text-muted small">${req.time || req.created_at || '-'}</td>
            </tr>
        `;
    });

    renderPaymentPaginationControls(Math.ceil(filteredPaymentData.length / paymentRowsPerPage));
}

function renderPaymentPaginationControls(totalPages) {
    let container = document.getElementById('paymentPaginationContainer');
    if (!container) return;
    container.innerHTML = '';

    if (totalPages <= 1) return;

    let infoText = document.createElement('small');
    infoText.className = 'text-muted';
    infoText.innerText = `စာမျက်နှာ ${currentPaymentPage} / ${totalPages}`;
    container.appendChild(infoText);

    let ul = document.createElement('ul');
    ul.className = 'pagination pagination-sm m-0';

    let prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPaymentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<button class="page-link" onclick="changePaymentPage(${currentPaymentPage - 1})">ရှေ့သို့</button>`;
    ul.appendChild(prevLi);

    for (let i = 1; i <= totalPages; i++) {
        let li = document.createElement('li');
        li.className = `page-item ${currentPaymentPage === i ? 'active' : ''}`;
        li.innerHTML = `<button class="page-link" onclick="changePaymentPage(${i})">${i}</button>`;
        ul.appendChild(li);
    }

    let nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPaymentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<button class="page-link" onclick="changePaymentPage(${currentPaymentPage + 1})">နောက်သို့</button>`;
    ul.appendChild(nextLi);

    container.appendChild(ul);
}

function changePaymentPage(page) {
    let totalPages = Math.ceil(filteredPaymentData.length / paymentRowsPerPage);
    if (page < 1 || page > totalPages) return;
    currentPaymentPage = page;
    renderPaymentTablePage(currentPaymentPage);
}

// Search Filter with Pagination Reset
document.getElementById('paymentSearchInput')?.addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    filteredPaymentData = allPaymentRequestsData.filter(req => {
        let name = (req.userName || (req.user ? req.user.name : '')).toLowerCase();
        let phone = (req.phone || '').toLowerCase();
        let tid = (req.transactionId || '').toLowerCase();
        return name.includes(filter) || phone.includes(filter) || tid.includes(filter);
    });
    currentPaymentPage = 1;
    renderPaymentTablePage(currentPaymentPage);
});


// Modal ပွင့်လာပါက League များနှင့် အသင်းများကို ဆွဲထုတ်ရန်
function openAnnounceMatchModal() {
    loadLeaguesForAnnounce();

    let modalElement = document.getElementById('announceMatchModal');
    let modal = new bootstrap.Modal(modalElement);
    modal.show();
}

let leagueTeamsMap = {};

function loadLeaguesForAnnounce() {
    fetch(`${window.baseUrl}/api/leagues`, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        let data = response.data || [];
        let leagueSelect = document.getElementById('announceLeague');
        if (!leagueSelect) return;

        leagueSelect.innerHTML = '<option value="">League ရွေးချယ်ပါ</option>';
        leagueTeamsMap = {};

        data.forEach(item => {
            let leagueName = (item.league_name || '').trim();
            let rawTeams = item.teams;
            let teamArray = [];

            if (Array.isArray(rawTeams)) {
                teamArray = rawTeams;
            } else if (typeof rawTeams === 'string' && rawTeams.trim() !== '') {
                try {
                    let parsed = JSON.parse(rawTeams);
                    if (Array.isArray(parsed)) {
                        teamArray = parsed;
                    }
                } catch (e) {
                    teamArray = rawTeams.replace(/[\[\]"]/g, '').split(',').map(t => t.trim());
                }
            }

            leagueTeamsMap[leagueName] = teamArray.map(t => String(t).trim()).filter(Boolean);

            let option = document.createElement('option');
            option.value = leagueName;
            option.textContent = leagueName;
            leagueSelect.appendChild(option);
        });

        // ဒေတာများ အပြည့်အစုံ ဝင်လာပြီးမှ ပထမဆုံး League ကို ရွေးချယ်ပေးခြင်း[cite: 28]
        if (data.length > 0) {
            let firstLeague = (data[0].league_name || '').trim();
            leagueSelect.value = firstLeague;
            updateTeamDropdowns(firstLeague);
        }

        // League Dropdown တွင် အသင်းများကို အလိုအလျောက်ပြောင်းပေးမည့် Event Listener ကို ဤနေရာတွင် ထည့်သွင်းပါ[cite: 28]
        leagueSelect.onchange = function() {
            updateTeamDropdowns(this.value);
        };
    })
    .catch(err => console.error('Error loading leagues:', err));
}

function updateTeamDropdowns(leagueName) {
    let homeSelect = document.getElementById('announceHomeTeam');
    let awaySelect = document.getElementById('announceAwayTeam');
    if (!homeSelect || !awaySelect) return;

    homeSelect.innerHTML = '<option value="">အိမ်ရှင်အသင်း ရွေးပါ</option>';
    awaySelect.innerHTML = '<option value="">ဧည့်သည်အသင်း ရွေးပါ</option>';

    let cleanLeagueName = (leagueName || '').trim();
    let teams = leagueTeamsMap[cleanLeagueName] || [];

    teams.forEach(team => {
        let opt1 = document.createElement('option');
        opt1.value = team;
        opt1.textContent = team;
        homeSelect.appendChild(opt1);

        let opt2 = document.createElement('option');
        opt2.value = team;
        opt2.textContent = team;
        awaySelect.appendChild(opt2);
    });
}

// ထပ်နေသော Event Listener များကို ဖယ်ရှားပြီး တစ်ခုတည်းသာ ထားရှိခြင်း
const announceLeagueSelect = document.getElementById('announceLeague');
if (announceLeagueSelect) {
    // ရှေ့တွင် ရှိပြီးသား Event များကို မထပ်စေရန် တစ်ခုတည်းသော Listener သုံးခြင်း
    announceLeagueSelect.onchange = function() {
        updateTeamDropdowns(this.value);
    };
}

// ဘောပွဲကြေငြာရန် ခလုတ်ကို နှိပ်သည့်အခါ ဆာဗာသို့ ပို့ရန် (တစ်ခုတည်းသော ပုံစံ)
function submitAnnounceMatch() {
    let league = document.getElementById('announceLeague').value;
    let homeTeam = document.getElementById('announceHomeTeam').value;
    let awayTeam = document.getElementById('announceAwayTeam').value;
    let homeOdds = document.getElementById('announceHomeOdds').value.trim();
    let awayOdds = document.getElementById('announceAwayOdds').value.trim();
    let goalTotal = document.getElementById('announceGoalTotal').value.trim();
    let videoLink = document.getElementById('announceVideoLink').value.trim();
    let bodyOdds = document.getElementById('announceBodyOdds').value.trim();
    let bodyAwayOdds = document.getElementById('announceBodyAwayOdds').value.trim();
    let bodyGoalTotal = document.getElementById('announceBodyGoalTotal').value.trim();
    let rawCloseTime = document.getElementById('announceCloseTime').value;

    if (!league || !homeTeam || !awayTeam || !rawCloseTime) {
        alert('League, အသင်းများ နှင့် Close Time ကို ရွေးချယ်ပါ');
        return;
    }

    let formattedCloseTime = rawCloseTime.includes('T') ? rawCloseTime.replace('T', ' ') + ':00' : rawCloseTime;

    let formData = {
        league_name: league,
        home_team: homeTeam,
        away_team: awayTeam,
        home_odds: homeOdds !== '' ? homeOdds : null,
        away_odds: awayOdds !== '' ? awayOdds : null,
        goal_total: goalTotal !== '' ? goalTotal : null,
        video_link: videoLink !== '' ? videoLink : null,
        body_odds: bodyOdds !== '' ? bodyOdds : null,
        body_away_odds: bodyAwayOdds !== '' ? bodyAwayOdds : null,
        body_goal_total: bodyGoalTotal !== '' ? bodyGoalTotal : null,
        close_time: formattedCloseTime
    };

    fetch(`${window.baseUrl}/api/football/add-match`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message || 'ဘောပွဲ ကြေငြာပြီးပါပြီ');
            let modalElement = document.getElementById('announceMatchModal');
            let modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            location.reload();
        } else {
            alert(data.message || 'Error ဖြစ်ပွားခဲ့သည်');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    });
}

// ကြေငြာထားသော ပွဲစဉ်များကို ဆွဲထုတ်ပြီး ဇယားထဲတွင် ထည့်သွင်းခြင်း
let allMatchesData = [];

function fetchAnnouncedMatches() {
    fetch(`${window.baseUrl}/api/football-matches`, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(matches => {
        if (!matches) return;
        // ID အစဉ်လိုက် (၃၆၊ ၃၇၊ ၃၈ စသည်ဖြင့်) စီရန်
        allMatchesData = matches.sort((a, b) => a.id - b.id);
        renderMatches(allMatchesData);
    })
    .catch(error => console.error('Error fetching announced matches:', error));
}

function renderMatches(matches) {
    let tbody = document.querySelector('#announced-matches-table tbody');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (!matches || matches.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted">ကြေငြာထားသော ဘောပွဲများ မရှိသေးပါ။</td></tr>`;
        return;
    }

    matches.forEach(match => {
        let bodyChecked = match.body_status == 1 ? 'checked' : '';
        let maungChecked = match.maung_status == 1 ? 'checked' : '';
        
        let homeOddsHtml = match.home_odds ? `<span class="badge bg-danger me-1">( ${match.home_odds} )</span>` : '';
        let awayOddsHtml = match.away_odds ? `<span class="badge bg-success ms-1">( ${match.away_odds} )</span>` : '';

        let bodyOddsHtml = match.body_odds ? `<span class="badge bg-danger me-1">( ${match.body_odds} )</span>` : '';
        let bodyAwayOddsHtml = match.body_away_odds ? `<span class="badge bg-success ms-1">( ${match.body_away_odds} )</span>` : '';

        tbody.innerHTML += `
            <tr>
                <td class="fw-bold text-secondary">#${match.id}</td>
                <td>${match.close_time ?? '-'}</td>
                <td>
                    <div class="fw-bold text-dark">
                        ${homeOddsHtml}${match.home_team ?? ''} vs ${match.away_team ?? ''}${awayOddsHtml}
                    </div>
                    <small class="text-muted"><i class="fa-solid fa-trophy me-1"></i>${match.league_name ?? ''}</small>
                </td>
                <td>${match.goal_total ?? '-'}</td>
                <td>
                    <div class="fw-bold text-dark">
                        ${bodyOddsHtml}${match.home_team ?? ''} vs ${match.away_team ?? ''}${bodyAwayOddsHtml}
                    </div>
                    <small class="text-muted"><i class="fa-solid fa-trophy me-1"></i>${match.league_name ?? ''}</small>
                </td>
                <td>${match.body_goal_total ?? '-'}</td>
                <td class="text-center">
                    <div class="form-check form-switch d-inline-block">
                        <input class="form-check-input" type="checkbox" role="switch" ${bodyChecked} onchange="updateMatchStatus(${match.id}, 'body_status', this.checked ? 1 : 0)">
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check form-switch d-inline-block">
                        <input class="form-check-input" type="checkbox" role="switch" ${maungChecked} onchange="updateMatchStatus(${match.id}, 'maung_status', this.checked ? 1 : 0)">
                    </div>
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-outline-primary btn-sm px-2 py-1" onclick="editMatch(${match.id})" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm px-2 py-1" onclick="deleteMatchConfirm(${match.id})" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
}

// home_team နှင့် away_team ဖြင့် ရှာဖွေသည့် ဖန်ရှင်
function filterMatches() {
    let searchValue = document.getElementById('matchSearchInput').value.toLowerCase();
    let filtered = allMatchesData.filter(match => {
        let home = (match.home_team ?? '').toLowerCase();
        let away = (match.away_team ?? '').toLowerCase();
        return home.includes(searchValue) || away.includes(searchValue);
    });
    renderMatches(filtered);
}


function updateMatchStatus(matchId, statusType, statusValue) {
    // 🛑 Endpoint ယူအာအယ်လ်ကို /api/football/update-status သို့ ပြောင်းလဲပေးခြင်း
    fetch(`${window.baseUrl}/api/football/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        },
        body: JSON.stringify({ match_id: matchId, type: statusType, status: statusValue })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Full API Response Data:", data); // Response တစ်ခုလုံးကို အသေးစိတ်ကြည့်ရန်
        console.log("data.status value:", data.status); // status တန်ဖိုးကို စစ်ရန်
        
        // ပိုမိုလွယ်ကူစေရန် condition ကို ဖြည့်စွက်ခြင်း
        if (data && (data.success === true || data.status === 'success' || data.status === true)) {
            alert('Status ပြောင်းလဲမှု အောင်မြင်ပါသည်။');
            fetchAnnouncedMatches();
        } else {
            alert('Status ပြောင်းလဲရာတွင် အမှားအယွင်း ရှိပါသည်။');
            fetchAnnouncedMatches();
        }
    })
    .catch(err => {
        console.error('Error updating status:', err);
        fetchAnnouncedMatches();
    });
}

// 🛑 ပွဲစဉ်အချက်အလက်များကို ယူ၍ Modal ပေါ်လာစေရန်
function editMatch(matchId) {
    let match = allMatchesData.find(m => m.id === matchId);
    if (!match) return;

    document.getElementById('editMatchId').value = match.id;
    document.getElementById('editLeagueName').value = match.league_name || '';
    document.getElementById('editHomeTeam').value = match.home_team || '';
    document.getElementById('editAwayTeam').value = match.away_team || '';
    document.getElementById('editHomeOdds').value = match.home_odds || '';
    document.getElementById('editAwayOdds').value = match.away_odds || '';
    document.getElementById('editGoalTotal').value = match.goal_total || '';
    document.getElementById('editVideoLink').value = match.video_link || '';
    document.getElementById('editBodyOdds').value = match.body_odds || '';
    document.getElementById('editBodyAwayOdds').value = match.body_away_odds || '';
    document.getElementById('editBodyGoalTotal').value = match.body_goal_total || '';
    
    if (match.close_time) {
        let formattedTime = match.close_time.replace(' ', 'T').substring(0, 16);
        document.getElementById('editCloseTime').value = formattedTime;
    }

    var editModal = new bootstrap.Modal(document.getElementById('editMatchModal'));
    editModal.show();
}

// 🛑 ပြင်ဆင်ပြီးသား အချက်အလက်များကို API သို့ ပို့၍ သိမ်းဆည်းရန်
function submitEditMatch() {
    let matchId = document.getElementById('editMatchId').value;
    let rawCloseTime = document.getElementById('editCloseTime').value;
    let formattedCloseTime = rawCloseTime.includes('T') ? rawCloseTime.replace('T', ' ') + ':00' : rawCloseTime;

    let formData = {
        match_id: matchId,
        league_name: document.getElementById('editLeagueName').value,
        home_team: document.getElementById('editHomeTeam').value,
        away_team: document.getElementById('editAwayTeam').value,
        home_odds: document.getElementById('editHomeOdds').value,
        away_odds: document.getElementById('editAwayOdds').value,
        goal_total: document.getElementById('editGoalTotal').value,
        video_link: document.getElementById('editVideoLink').value,
        body_odds: document.getElementById('editBodyOdds').value,
        body_away_odds: document.getElementById('editBodyAwayOdds').value,
        body_goal_total: document.getElementById('editBodyGoalTotal').value,
        close_time: formattedCloseTime
    };

   fetch(`${window.baseUrl}/api/football/update-match`, { // Route နှင့် တူညီသော URL သို့ ပြောင်းရန်
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + window.apiToken
    },
    body: JSON.stringify(formData)
})
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert('ပွဲစဉ်အချက်အလက်များကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
            let modalEl = document.getElementById('editMatchModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            fetchAnnouncedMatches();
        } else {
            alert('ပြင်ဆင်ရာတွင် အမှားအယွင်း ရှိပါသည်။');
        }
    })
    .catch(err => console.error('Error updating match:', err));
}


function deleteMatchConfirm(matchId) {
    if (confirm('ဒီဘောပွဲကို ဖျက်ရန် သေချာပါသလား?')) {
        fetch(`${window.baseUrl}/api/football/match/delete`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({ id: matchId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success || data.status === 'success') {
                alert('ဘောပွဲကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
                fetchAnnouncedMatches();
            } else {
                alert('ဖျက်ရာတွင် အမှားအယွင်း ရှိပါသည်။');
            }
        })
        .catch(err => console.error('Error deleting match:', err));
    }
}

// Select All Checkbox
function toggleSelectAllPayments(master) {
    let checkboxes = document.querySelectorAll('.payment-checkbox');
    checkboxes.forEach(cb => cb.checked = master.checked);
}


// Delete Selected Payment Requests
async function deleteSelectedPaymentRequests() {
    let selectedIds = Array.from(document.querySelectorAll('.payment-checkbox:checked')).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('ကျေးဇူးပြု၍ ဖျက်ရန် အနည်းဆုံး တစ်ခုကို ရွေးချယ်ပါ။');
        return;
    }

    if (!confirm(`ရွေးချယ်ထားသော တောင်းဆိုမှု ${selectedIds.length} ခုကို ဖျက်ရန် သေချာပါသလား?`)) {
        return;
    }

    try {
        let successCount = 0;
        for (let id of selectedIds) {
            let res = await fetch(`${window.baseUrl}/api/request/delete`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.apiToken
                },
                body: JSON.stringify({ request_id: id })
            });

            let result = await res.json();
            if (res.ok && result.status === 'success') {
                successCount++;
            }
        }

        if (successCount > 0) {
            alert('ရွေးချယ်ထားသော အချက်အလက်များကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
            fetchPaymentRequestsTab(); // ဇယားကို ဒေတာအသစ်ဖြင့် ပြန်လည်ဆွဲရန်
        } else {
            alert('ဖျက်ရာတွင် အမှားအယွင်း ရှိပါသည်။');
        }
    } catch (e) {
        console.error('Error deleting payment requests:', e);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    }
}

// 💰 ထိုးထားသော Bet များ စာရင်းကို Fetch လုပ်ပြီး Table ထဲသို့ ထည့်သွင်းခြင်း (Pagination နှင့် Delete ပါ ထည့်သွင်းထားသည်)
document.addEventListener("DOMContentLoaded", function () {
    fetchFootballBets();

    // ရှာဖွေရန် (Search) ပြုလုပ်သည့်အခါ
    const betSearchInput = document.getElementById('betSearchQuery');
    if (betSearchInput) {
        betSearchInput.addEventListener('input', function () {
            filterFootballBets(this.value);
        });
    }
});

let allFootballBets = [];
let filteredFootballBets = [];
let currentBetPage = 1;
const betRowsPerPage = 5;
let globalUserMap = {};

function fetchFootballBets() {
    Promise.all([
        fetch(`${window.baseUrl}/api/football/body-moung-bets`, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            }
        }).then(res => res.json()),
        fetch(`${window.baseUrl}/api/users`, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            }
        }).then(res => res.json())
    ])
    .then(([betsData, usersData]) => {
        let rawBets = [];
        if (Array.isArray(betsData)) {
            rawBets = betsData;
        } else if (betsData.data) {
            rawBets = betsData.data;
        } else if (betsData.bets) {
            rawBets = betsData.bets;
        }

        // 🟢 Pending ဖြစ်နေသောဟာများကို တေဘယ်ထိပ်ဆုံးသို့ အလိုအလျောက် ပို့ဆောင်ပေးခြင်း (Sort by Pending Status)
        allFootballBets = rawBets.sort((a, b) => {
            let statusA = (a.status || 'pending').toLowerCase();
            let statusB = (b.status || 'pending').toLowerCase();
            if (statusA === 'pending' && statusB !== 'pending') return -1;
            if (statusA !== 'pending' && statusB === 'pending') return 1;
            return b.id - a.id; // ID အသစ်များကိုပါ ဦးစားပေးရန်
        });

        filteredFootballBets = allFootballBets;

        let usersList = [];
        if (Array.isArray(usersData)) {
            usersList = usersData;
        } else if (usersData.data) {
            usersList = usersData.data;
        }

        usersList.forEach(u => {
            let uId = u.id ? u.id.toString() : '';
            let uName = u.name ? u.name.toString() : '';
            if (uId) {
                globalUserMap[uId] = uName;
            }
        });

        renderFootballBetsTablePage(currentBetPage);
    })
    .catch(err => console.error("Error fetching football bets:", err));
}

function renderFootballBetsTablePage(page) {
    const tbody = document.getElementById('footballBetsTableBody');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (!filteredFootballBets || filteredFootballBets.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center text-muted py-4">ရှာဖွေတွေ့ရှိသော Bet အချက်အလက်များ မရှိပါ။</td></tr>`;
        renderBetPaginationControls(0);
        return;
    }

    let start = (page - 1) * betRowsPerPage;
    let end = start + betRowsPerPage;
    let paginatedItems = filteredFootballBets.slice(start, end);

    paginatedItems.forEach(bet => {
        let parsedOptions = [];
        try {
            let rawOpt = bet.selected_option || '[]';
            if (typeof rawOpt === 'string' && rawOpt.startsWith('[')) {
                parsedOptions = JSON.parse(rawOpt);
            } else if (Array.isArray(rawOpt)) {
                parsedOptions = rawOpt;
            }
        } catch (e) {
            parsedOptions = [];
        }

        let matchCount = parsedOptions.length > 0 ? parsedOptions.length : 1;
        let userDocId = bet.user_doc_id ? bet.user_doc_id.toString() : '';
        let userName = globalUserMap[userDocId] || userDocId;
        let betType = bet.bet_type || '-';
        let isMoung = betType.toLowerCase() === 'moung' || betType.includes('မောင်း');

        let badgeClass = isMoung ? 'bg-warning text-dark' : 'bg-primary text-white';
        let statusColor = bet.status === 'win' ? 'text-success' : (bet.status === 'lose' ? 'text-danger' : 'text-warning');

        let matchesText = parsedOptions.map((opt, i) => {
            let h = opt.home_team || '-';
            let a = opt.away_team || '-';
            let c = opt.selected_team || opt.choice || opt.selected_option || '-';
            return `<div class="small mb-1"><strong>${i + 1})</strong> ${h} vs ${a} <span class="text-primary fw-bold">(${c})</span></div>`;
        }).join('');

        if (!matchesText) {
            matchesText = `<span class="text-muted">ပွဲစဉ် (${matchCount}) ပွဲ</span>`;
        }
        
        let row = `
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input football-bet-checkbox" value="${bet.id}">
                </td>
                <td>${bet.id || '-'}</td>
                <td><strong class="text-indigo">${userName}</strong></td>
                <td><span class="badge ${badgeClass}">${betType}</span></td>
                <td><div style="max-height: 100px; overflow-y: auto;">${matchesText}</div></td>      
                <td>${bet.amount || '-'}</td>
                <td><span class="fw-bold ${statusColor}">${bet.status || 'pending'}</span></td>
                <td><small>${bet.created_at || '-'}</small></td>
                <td>
                    <button class="btn btn-sm btn-primary text-white" onclick='showBetDetailModal(${JSON.stringify(bet)})'>
                        <i class="fas fa-receipt"></i> Detail &amp; ရှင်းမည်
                    </button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });

    renderBetPaginationControls(Math.ceil(filteredFootballBets.length / betRowsPerPage));
}

function renderBetPaginationControls(totalPages) {
    let container = document.getElementById('footballBetPaginationContainer');
    if (!container) {
        let tableResponsive = document.querySelector('#bets-content .table-responsive');
        if (tableResponsive) {
            container = document.createElement('div');
            container.id = 'footballBetPaginationContainer';
            container.className = 'd-flex justify-content-between align-items-center mt-3 pt-2';
            tableResponsive.parentNode.appendChild(container);
        } else {
            return;
        }
    }
    container.innerHTML = '';

    if (totalPages <= 1) return;

    let infoText = document.createElement('small');
    infoText.className = 'text-muted';
    infoText.innerText = `စာမျက်နှာ ${currentBetPage} / ${totalPages}`;
    container.appendChild(infoText);

    let ul = document.createElement('ul');
    ul.className = 'pagination pagination-sm m-0';

    let prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentBetPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<button class="page-link" onclick="changeFootballBetPage(${currentBetPage - 1})">ရှေ့သို့</button>`;
    ul.appendChild(prevLi);

    for (let i = 1; i <= totalPages; i++) {
        let li = document.createElement('li');
        li.className = `page-item ${currentBetPage === i ? 'active' : ''}`;
        li.innerHTML = `<button class="page-link" onclick="changeFootballBetPage(${i})">${i}</button>`;
        ul.appendChild(li);
    }

    let nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentBetPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<button class="page-link" onclick="changeFootballBetPage(${currentBetPage + 1})">နောက်သို့</button>`;
    ul.appendChild(nextLi);

    container.appendChild(ul);
}

function changeFootballBetPage(page) {
    let totalPages = Math.ceil(filteredFootballBets.length / betRowsPerPage);
    if (page < 1 || page > totalPages) return;
    currentBetPage = page;
    renderFootballBetsTablePage(currentBetPage);
}

function filterFootballBets(query) {
    let q = query.toLowerCase();
    filteredFootballBets = allFootballBets.filter(bet => {
        if (!q) return true;

        let betId = bet.id ? bet.id.toString().toLowerCase() : '';
        if (betId.includes(q)) return true;

        let userDocId = bet.user_doc_id ? bet.user_doc_id.toString().toLowerCase() : '';
        let userName = (globalUserMap[bet.user_doc_id] || '').toLowerCase();
        if (userDocId.includes(q) || userName.includes(q)) return true;

        try {
            let rawOpt = bet.selected_option;
            let parsedOpts = [];
            if (typeof rawOpt === 'string') {
                parsedOpts = JSON.parse(rawOpt);
            } else if (Array.isArray(rawOpt)) {
                parsedOpts = rawOpt;
            }
            for (let opt of parsedOpts) {
                let home = (opt.home_team || '').toLowerCase();
                let away = (opt.away_team || '').toLowerCase();
                let selectedTeam = (opt.selected_team || opt.choice || opt.selected_option || '').toLowerCase();
                if (home.includes(q) || away.includes(q) || selectedTeam.includes(q)) return true;
            }
        } catch (e) {}

        return false;
    });

    currentBetPage = 1;
    renderFootballBetsTablePage(currentBetPage);
}

// Select All Checkbox for Football Bets
function toggleSelectAllFootballBets(master) {
    let checkboxes = document.querySelectorAll('.football-bet-checkbox');
    checkboxes.forEach(cb => cb.checked = master.checked);
}

// Delete Selected Football Bets
async function deleteSelectedFootballBets() {
    let selectedIds = Array.from(document.querySelectorAll('.football-bet-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('ကျေးဇူးပြု၍ ဖျက်ရန် Bet အနည်းဆုံး တစ်ခုကို ရွေးချယ်ပါ။');
        return;
    }

    if (!confirm(`ရွေးချယ်ထားသော Bet စာရင်း ${selectedIds.length} ခုကို ဖျက်ရန် သေချာပါသလား?`)) {
        return;
    }

    try {
        for (let id of selectedIds) {
            await fetch(`${window.baseUrl}/api/football/bet/delete`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.apiToken
                },
                body: JSON.stringify({ id: id, bet_id: id })
            });
        }
        alert('ရွေးချယ်ထားသော Bet များကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
        fetchFootballBets();
    } catch (e) {
        console.error('Error deleting football bets:', e);
        alert('ဖျက်ရာတွင် အမှားအယွင်း ရှိပါသည်။');
    }
}



function showBetDetailModal(bet) {
    let modalEl = document.getElementById('betDetailModal');
    if (!modalEl) {
        let modalHtml = `
            <div class="modal fade" id="betDetailModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">⚽ Bet အသေးစိတ်နှင့် ငွေရှင်းမည် (Detail & Settle)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="betDetailModalBody">
                            <!-- Dynamic Content -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                        </div>
                    </div>
                </div>
            </div>`;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        modalEl = document.getElementById('betDetailModal');
    }

    let userDocId = bet.user_doc_id ? bet.user_doc_id.toString() : '';
    let userName = globalUserMap[userDocId] || userDocId;
    let betType = (bet.bet_type || '').toLowerCase();
    let isMoung = betType === 'moung' || betType === 'maung' || betType.includes('မောင်း');

    let parsedOptions = [];
    try {
        let rawOpt = bet.selected_option || '[]';
        if (typeof rawOpt === 'string' && rawOpt.startsWith('[')) {
            parsedOptions = JSON.parse(rawOpt);
        } else if (Array.isArray(rawOpt)) {
            parsedOptions = rawOpt;
        }
    } catch (e) {
        parsedOptions = [];
    }

    let optionsHtml = '';
    parsedOptions.forEach((opt, index) => {
        let homeTeam = opt.home_team || '-';
        let awayTeam = opt.away_team || '-';
        let choice = opt.selected_team || opt.choice || opt.selected_option || '-';
        let matchAmount = opt.amount !== undefined ? opt.amount : 0;
        
        // 🛑 match_id မရှိပါက index ကိုပါ ပူးတွဲပြီး သီးသန့် unique ID တစ်ခု ဖန်တီးပေးခြင်းဖြင့် ပွဲစဉ်များ ရောထွေးမှုကို ကာကွယ်မည်
        let matchId = opt.match_id !== undefined && opt.match_id !== '' ? opt.match_id : 'match_' + index; 
        
        let optStatus = opt.status || 'pending';
        let optWinAmount = opt.win_amount !== undefined ? opt.win_amount : (opt.lost !== undefined ? opt.lost : 0);

        let statusBadgeText = '';
        if (optStatus === 'win') {
            statusBadgeText = `<span class="text-success ms-1 fw-bold match-processed-badge">win-${opt.win_amount || 0}</span>`;
        } else if (optStatus === 'lose' || optStatus === 'lost') {
            statusBadgeText = `<span class="text-danger ms-1 fw-bold match-processed-badge">lost-${opt.lost || opt.win_amount || 0}</span>`;
        }

        if (!isMoung) {
            optionsHtml += `
                <div class="p-3 mb-2 border rounded bg-light match-settle-row" data-index="${index}" data-match-id="${matchId}">
                    <p class="mb-1"><strong>ပွဲစဉ် (${index + 1}):</strong> ${homeTeam} vs ${awayTeam} <span class="text-muted small">(ID: ${matchId})</span></p>
                    <p class="mb-1 text-muted small">ရွေးချယ်ထားသည့်အသင်း/ဂိုး: <span class="text-danger fw-bold">${choice}</span></p>
                    <p class="mb-2 text-success small fw-bold">ထိုးထားသည့်ငွေပမာဏ: ${Number(matchAmount).toLocaleString()} ကျပ်</p>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">ရလဒ် (Status)</label>
                            <select class="form-select form-select-sm match-status-select" ${optStatus !== 'pending' ? 'disabled' : ''}>
                                <option value="pending" ${optStatus === 'pending' ? 'selected' : ''}>Pending (စောင့်ဆိုင်းဆဲ)</option>
                                <option value="win" ${optStatus === 'win' ? 'selected' : ''}>Win (အနိုင်)</option>
                                <option value="lose" ${optStatus === 'lose' ? 'selected' : ''}>Lose (အရှုံး)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">အနိုင်ရငွေ (Win Amount) ${statusBadgeText}</label>
                            <input type="number" class="form-control form-control-sm match-win-amount" value="${optWinAmount}" placeholder="ငွေပမာဏထည့်ရန်" ${optStatus !== 'pending' ? 'readonly' : ''}>
                        </div>
                    </div>
                </div>
            `;
        } else {
            optionsHtml += `
                <div class="p-2 mb-2 border rounded bg-light" data-match-id="${matchId}">
                    <p class="mb-1"><strong>ပွဲစဉ် (${index + 1}):</strong> ${homeTeam} vs ${awayTeam}</p>
                    <p class="mb-0 text-muted small">ရွေးချယ်မှု: <span class="text-primary fw-bold">${choice}</span></p>
                </div>
            `;
        }
    });

    let settleActionHtml = '';
    if (isMoung) {
        settleActionHtml = `
            <div class="row g-2 align-items-center mt-2 p-3 border rounded bg-white">
                <div class="col-md-6">
                    <label for="moungSettleStatus" class="form-label fw-bold mb-1">မောင်း အထွေထွေ အခြေအနေ (Status)</label>
                    <select class="form-select form-select-sm" id="moungSettleStatus">
                        <option value="pending" ${bet.status === 'pending' ? 'selected' : ''}>Pending (စောင့်ဆိုင်းဆဲ)</option>
                        <option value="win" ${bet.status === 'win' ? 'selected' : ''}>Win (အနိုင်)</option>
                        <option value="lose" ${bet.status === 'lose' ? 'selected' : ''}>Lose (အရှုံး)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="moungWinAmount" class="form-label fw-bold mb-1">အနိုင်ရမည့် ငွေပမာဏ (Win Amount)</label>
                    <input type="number" class="form-control form-control-sm" id="moungWinAmount" value="${bet.win_amount || 0}" placeholder="ငွေပမာဏထည့်ရန်">
                </div>
            </div>
        `;
    }

    let bodyContent = `
        <input type="hidden" id="detailBetId" value="${bet.id}">
        <input type="hidden" id="detailUserDocId" value="${userDocId}">
        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted mb-1">User အမည်</label>
                <input type="text" class="form-control form-control-sm fw-bold" value="${userName}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted mb-1">Bet ပုံစံ (Type)</label>
                <input type="text" class="form-control form-control-sm text-uppercase" value="${bet.bet_type || '-'}" readonly>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted mb-1">စုစုပေါင်း ထိုးထားသော ပမာဏ</label>
            <input type="text" class="form-control form-control-sm text-success fw-bold" value="${bet.amount || 0} ကျပ်" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted mb-1">လောင်းထားသော ပွဲစဉ်များနှင့် ရွေးချယ်မှုများ (${parsedOptions.length} ပွဲ)</label>
            <div style="max-height: 280px; overflow-y: auto;">
                ${optionsHtml || '<p class="text-muted">ပွဲစဉ် အချက်အလက် မရှိပါ။</p>'}
            </div>
        </div>
        ${settleActionHtml}
        <div class="text-end mt-3">
            <button type="button" class="btn btn-primary btn-sm px-4" onclick='submitSettleBet(${bet.id}, "${bet.bet_type}")'>ငွေရှင်းမည် / သိမ်းဆည်းမည်</button>
        </div>
    `;

    document.getElementById('betDetailModalBody').innerHTML = bodyContent;
    var myModal = new bootstrap.Modal(modalEl);
    myModal.show();
}

async function submitSettleBet(betId, betType) {
    let userDocId = document.getElementById('detailUserDocId') ? document.getElementById('detailUserDocId').value : '';
    let isMoung = betType.toLowerCase() === 'moung' || betType.toLowerCase() === 'maung' || betType.includes('မောင်း');

    let postData = {
        bet_id: betId,
        user_doc_id: userDocId
    };

    if (isMoung) {
        let status = document.getElementById('moungSettleStatus').value;
        let winAmount = document.getElementById('moungWinAmount').value;

        postData.win_amount = winAmount;
        postData.status = status;

        let apiEndpoint = (status === 'lose') ? `${window.baseUrl}/api/bet/update-lost` : `${window.baseUrl}/api/bet/update-win`;

        try {
            let res = await fetch(apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.apiToken
                },
                body: JSON.stringify(postData)
            });
            let data = await res.json();
            if (data.success || data.status === 'success') {
                alert('မောင်း ငွေရှင်းလင်းမှု အောင်မြင်ပါသည်။');
                var modalEl = document.getElementById('betDetailModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                fetchFootballBets();
            } else {
                alert('အမှားအယွင်း ရှိပါသည်: ' + (data.message || ''));
            }
        } catch (err) {
            console.error('Error settling moung bet:', err);
        }

    } else {
        // 🟢 ဘောဒီ (BODY) ပွဲစဉ်များအတွက် ရွေးချယ်ထားသမျှ ပွဲစဉ်အားလုံးကို တစ်ခါတည်း Loop ပတ်၍ အလုပ်လုပ်စေခြင်း
        let matchRows = document.querySelectorAll('.match-settle-row');
        let processedCount = 0;

        try {
            for (let row of matchRows) {
                let statusSelect = row.querySelector('.match-status-select').value;
                if (statusSelect === 'pending') continue;

                let isAlreadyProcessed = row.querySelector('.match-status-select').disabled || row.querySelector('.match-processed-badge') !== null;
                if (isAlreadyProcessed) continue;

                let targetMatchId = row.getAttribute('data-match-id');
                let targetWinAmount = row.querySelector('.match-win-amount').value;

                let bodyData = {
                    bet_id: betId,
                    user_doc_id: userDocId,
                    match_id: targetMatchId ? targetMatchId.toString().trim() : '',
                    win_amount: Number(targetWinAmount),
                    amount: Number(targetWinAmount)
                };

                let apiEndpoint = (statusSelect === 'lose') ? `${window.baseUrl}/api/bet/update-lost` : `${window.baseUrl}/api/bet/update-win`;

                let res = await fetch(apiEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + window.apiToken
                    },
                    body: JSON.stringify(bodyData)
                });
                let data = await res.json();
                
                if (data.success || data.status === 'success') {
                    processedCount++;
                }
            }

            if (processedCount > 0) {
                alert('ဘောဒီ ပွဲစဉ်အလိုက် ငွေရှင်းလင်းမှု ပြီးစီးပါပြီ။');
                var modalEl = document.getElementById('betDetailModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                fetchFootballBets();
            } else {
                alert('ကျေးဇူးပြု၍ ငွေရှင်းရန်အတွက် Status (Win သို့မဟုတ် Lose) ကို အနည်းဆုံး တစ်ပွဲ ရွေးချယ်ပါ။');
            }
        } catch (err) {
            console.error('Error settling body match:', err);
            alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
        }
    }
}


  // 2D User Bets စာရင်းများကို ဆွဲထုတ်ခြင်း
document.addEventListener("DOMContentLoaded", function() {
    fetchTwoDBets();

    // 2D Search ပြုလုပ်သည့်အခါ
    const twodSearchInput = document.getElementById('twodBetSearchInput');
    if (twodSearchInput) {
        twodSearchInput.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase().trim();
            filteredTwoDBetsData = allTwoDBetsData.filter(bet => {
                let number = (bet.number || '').toString().toLowerCase();
                let name = (bet.user_name || bet.name || (bet.user ? bet.user.name : '')).toLowerCase();
                
                // parsed bets ထဲမှ ဂဏန်းများကိုလည်း ရှာဖွေနိုင်ရန်
                let parsedBets = [];
                try {
                    let rawBets = bet.bets || '[]';
                    parsedBets = typeof rawBets === 'string' ? JSON.parse(rawBets) : rawBets;
                } catch (e) { parsedBets = []; }
                
                let matchNumberInList = parsedBets.some(b => String(b.number || '').toLowerCase().includes(filter));

                return number.includes(filter) || name.includes(filter) || matchNumberInList;
            });
            currentTwoDBetPage = 1;
            renderTwoDBetsTablePage(currentTwoDBetPage);
        });
    }
});

  
let allTwoDBetsData = [];
let filteredTwoDBetsData = [];
let currentTwoDBetPage = 1;
const twoDBetRowsPerPage = 10;

function fetchTwoDBets() {
    fetch(`${window.baseUrl}/api/admin/2d-user-bets`, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(res => {
        allTwoDBetsData = res.bets || [];
        filteredTwoDBetsData = allTwoDBetsData;
        renderTwoDBetsTablePage(currentTwoDBetPage);
    })
    .catch(error => console.error('Error fetching 2D bets:', error));
}

// ဇယားတွင် ဒေတာနှင့် Pagination ဖော်ပြခြင်း (On-Off Switch ဖယ်ရှားပြီး၊ Checkbox ထည့်သွင်းထားသည်)
function renderTwoDBetsTablePage(page) {
    let tbody = document.getElementById('twod-bets-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (!filteredTwoDBetsData || filteredTwoDBetsData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">2D ထိုးထားသော စာရင်းများ မရှိသေးပါ။</td></tr>`;
        renderTwoDBetPaginationControls(0);
        return;
    }

    let start = (page - 1) * twoDBetRowsPerPage;
    let end = start + twoDBetRowsPerPage;
    let paginatedItems = filteredTwoDBetsData.slice(start, end);

    paginatedItems.forEach(bet => {
        let isComplete = (bet.status == 1 || bet.status === 'complete' || bet.status_text === 'complete');
        let displayStatus = isComplete ? 'complete' : (bet.status || 'pending');
        
        let statusBadge = 'bg-warning text-dark';
        if (isComplete || displayStatus === 'complete' || displayStatus === 'win') {
            statusBadge = 'bg-success';
        } else if (displayStatus === 'lose') {
            statusBadge = 'bg-danger';
        }
        
        let displayName = (bet.user_name && bet.user_name !== 'Unknown') ? bet.user_name : (bet.user ? bet.user.name : 'Unknown');
        
        let parsedBets = [];
        try {
            let rawBets = bet.bets || '[]';
            parsedBets = typeof rawBets === 'string' ? JSON.parse(rawBets) : rawBets;
        } catch (e) {
            parsedBets = [];
        }

        let numberAmountHtml = '';
        if (parsedBets.length > 0) {
            numberAmountHtml = parsedBets.map(b => {
                let num = b.number || '-';
                let amt = Number(b.amount || 0).toLocaleString();
                
                let resultDisplay = '';
                if (b.win_amount && Number(b.win_amount) > 0) {
                    resultDisplay = ` | အနိုင်ရငွေ: <span class="text-danger fw-bold">${Number(b.win_amount).toLocaleString()} ကျပ်</span>`;
                } else if (b.lost !== undefined && b.lost !== null) {
                    resultDisplay = ` | ရှုံးငွေ: <span class="text-muted">${Number(b.lost).toLocaleString()} ကျပ်</span>`;
                } else if (b.status == 1 || b.status_text === 'complete' || isComplete) {
                    resultDisplay = ` | ရှုံးငွေ: <span class="text-muted">${Number(b.amount || 0).toLocaleString()} ကျပ်</span>`;
                }

                return `<div class="small mb-1"><span class="badge bg-primary me-1">${num}</span> <strong class="text-success">${amt} ကျပ်</strong>${resultDisplay}</div>`;
            }).join('');
        } else {
            let singleResultDisplay = '';
            if (bet.win_amount && Number(bet.win_amount) > 0) {
                singleResultDisplay = ` | အနိုင်ရငွေ: <span class="text-danger fw-bold">${Number(bet.win_amount).toLocaleString()} ကျပ်</span>`;
            } else if (bet.status == 1 || bet.status_text === 'complete' || isComplete) {
                singleResultDisplay = ` | ရှုံးငွေ: <span class="text-muted">${Number(bet.amount || 0).toLocaleString()} ကျပ်</span>`;
            }
            numberAmountHtml = `<span class="badge bg-primary">${bet.number || '-'}</span> <strong class="text-success">${Number(bet.amount || 0).toLocaleString()} ကျပ်</strong>${singleResultDisplay}`;
        }

        tbody.innerHTML += `
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input twod-bet-checkbox" value="${bet.id}">
                </td>
                <td class="fw-bold text-secondary">#${bet.id}</td>
                <td class="fw-bold text-dark">${displayName}</td>
                <td><div style="max-height: 100px; overflow-y: auto;">${numberAmountHtml}</div></td>
                <td class="fw-bold text-success">${Number(bet.total_amount || bet.amount || 0).toLocaleString()} ကျပ်</td>
                <td><span class="badge bg-info text-dark">${bet.session || '-'}</span></td>
                <td><span class="badge ${statusBadge}">${displayStatus}</span></td>
            </tr>
        `;
    });

    renderTwoDBetPaginationControls(Math.ceil(filteredTwoDBetsData.length / twoDBetRowsPerPage));
}

// Pagination Controls တည်ဆောက်ခြင်း
function renderTwoDBetPaginationControls(totalPages) {
    let container = document.getElementById('twodBetPaginationContainer');
    if (!container) {
        let tableResponsive = document.querySelector('#twodbets-tab .table-responsive') || document.querySelector('#twod-bets-tab .table-responsive');
        if (tableResponsive) {
            container = document.createElement('div');
            container.id = 'twodBetPaginationContainer';
            container.className = 'd-flex justify-content-between align-items-center mt-3 pt-2';
            tableResponsive.parentNode.appendChild(container);
        } else {
            return;
        }
    }
    container.innerHTML = '';

    if (totalPages <= 1) return;

    let infoText = document.createElement('small');
    infoText.className = 'text-muted';
    infoText.innerText = `စာမျက်နှာ ${currentTwoDBetPage} / ${totalPages}`;
    container.appendChild(infoText);

    let ul = document.createElement('ul');
    ul.className = 'pagination pagination-sm m-0';

    let prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentTwoDBetPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<button class="page-link" onclick="changeTwoDBetPage(${currentTwoDBetPage - 1})">ရှေ့သို့</button>`;
    ul.appendChild(prevLi);

    for (let i = 1; i <= totalPages; i++) {
        let li = document.createElement('li');
        li.className = `page-item ${currentTwoDBetPage === i ? 'active' : ''}`;
        li.innerHTML = `<button class="page-link" onclick="changeTwoDBetPage(${i})">${i}</button>`;
        ul.appendChild(li);
    }

    let nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentTwoDBetPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<button class="page-link" onclick="changeTwoDBetPage(${currentTwoDBetPage + 1})">နောက်သို့</button>`;
    ul.appendChild(nextLi);

    container.appendChild(ul);
}

function changeTwoDBetPage(page) {
    let totalPages = Math.ceil(filteredTwoDBetsData.length / twoDBetRowsPerPage);
    if (page < 1 || page > totalPages) return;
    currentTwoDBetPage = page;
    renderTwoDBetsTablePage(currentTwoDBetPage);
}

// Select All Checkbox for 2D Bets
function toggleSelectAllTwoDBets(master) {
    let checkboxes = document.querySelectorAll('.twod-bet-checkbox');
    checkboxes.forEach(cb => cb.checked = master.checked);
}

// ရွေးချယ်ထားသော 2D Bet များကို ဖျက်ရန် Function
async function deleteSelectedTwoDBets() {
    let selectedIds = Array.from(document.querySelectorAll('.twod-bet-checkbox:checked')).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('ကျေးဇူးပြု၍ ဖျက်ရန် 2D Bet အနည်းဆုံး တစ်ခုကို ရွေးချယ်ပါ။');
        return;
    }

    if (!confirm(`ရွေးချယ်ထားသော 2D Bet စာရင်း ${selectedIds.length} ခုကို ဖျက်ရန် သေချာပါသလား?`)) {
        return;
    }

    try {
        let res = await fetch(`${window.baseUrl}/api/admin/2d-user-bets/delete`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({ ids: selectedIds })
        });

        let result = await res.json();

        if (res.ok && (result.status === 'success' || result.success === true)) {
            alert('ရွေးချယ်ထားသော 2D Bet များကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
            fetchTwoDBets(); // ဇယားကို ဒေတာအသစ်ဖြင့် ပြန်ဆွဲမည်
        } else {
            alert('ဖျက်ရာတွင် အမှားအယွင်း ရှိပါသည်။ (Error: ' + (result.message || '') + ')');
        }
    } catch (e) {
        console.error('Error deleting 2D bets:', e);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    }
}

// 2D Bet တစ်ခုချင်းစီ၏ On-Off Switch အခြေအနေကို Update လုပ်ရန် ဖန်ရှင်
function update2DBetStatus(betId, statusValue) {
    fetch(`${window.baseUrl}/api/admin/2d-bet/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        },
        body: JSON.stringify({ bet_id: betId, status: statusValue })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success && data.status !== 'success') {
            alert('On/Off အခြေအနေ ပြောင်းလဲရာတွင် အမှားအယွင်း ရှိပါသည်။');
            fetchTwoDBets();
        }
    })
    .catch(err => {
        console.error('Error updating 2D bet status:', err);
        fetchTwoDBets();
    });
}

// 2D စကက်ကျူးနှင့် အွန်လိုင်းအော့ဖ် စီမံရန်
function open2DSettings() {
    fetch(`${window.baseUrl}/api/admin/2d-settings`, {
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        let settings = data.settings || {};
        
        document.getElementById('twodOpenTime').value = settings.open_time || '';
        document.getElementById('twodCloseTime').value = settings.close_time || '';
        
        var modal = new bootstrap.Modal(document.getElementById('twodSettingsModal'));
        modal.show();
    })
    .catch(err => console.error('Error fetching 2D settings:', err));
}


// ⚙️ Session အလိုက် အချိန် (Open Time နှင့် Close Time) များကို ဆွဲထုတ်ရန်
function load2DSessionSettings() {
    let sessionName = document.getElementById('selectSessionName').value;

    fetch(`${window.baseUrl}/api/twod/session-settings?session=${encodeURIComponent(sessionName)}`, {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        // ဆာဗာမှ ရလာသော အချက်အလက်များကို Form ထဲသို့ ထည့်ခြင်း
        if (data && data.success) {
            let settings = data.data || {};
            
            // ဖွင့်မည့်အချိန် (Open Time)
            if (settings.open_time) {
                let openTimeFormatted = settings.open_time.replace(' ', 'T').substring(0, 16);
                document.getElementById('twodOpenTime').value = openTimeFormatted;
            } else {
                document.getElementById('twodOpenTime').value = '';
            }

            // ပိတ်မည့်အချိန် (Close Time)
            if (settings.close_time) {
                let closeTimeFormatted = settings.close_time.replace(' ', 'T').substring(0, 16);
                document.getElementById('twodCloseTime').value = closeTimeFormatted;
            } else {
                document.getElementById('twodCloseTime').value = '';
            }
        }
    })
    .catch(err => console.error('Error loading 2D session settings:', err));

    var modal = new bootstrap.Modal(document.getElementById('twodSettingsModal'));
    modal.show();
}

// 💾 စကက်ကျူး ဖွင့်မည့်အချိန် (Open Time) နှင့် ပိတ်မည့်အချိန် (Close Time) ကို ဒေတာဘေ့စ်သို့ သိမ်းဆည်းရန်
function save2DSessionSettings() {
    let sessionNameElement = document.getElementById('sessionNameInput') || document.getElementById('selectSessionName');
    let openTimeElement = document.getElementById('twodOpenTime') || document.getElementById('openTimeInput');
    let closeTimeElement = document.getElementById('twodCloseTime') || document.getElementById('closeTimeInput');

    let sessionName = sessionNameElement ? sessionNameElement.value : '';
    let rawOpenTime = openTimeElement ? openTimeElement.value : '';
    let rawCloseTime = closeTimeElement ? closeTimeElement.value : '';

    // datetime-local ("YYYY-MM-DDTHH:mm") ကို MySQL datetime format သို့ ပြောင်းလဲခြင်း
    let openTime = rawOpenTime.includes('T') ? rawOpenTime.replace('T', ' ') + ':00' : rawOpenTime;
    let closeTime = rawCloseTime.includes('T') ? rawCloseTime.replace('T', ' ') + ':00' : rawCloseTime;

    if (!sessionName || !openTime || !closeTime) {
        alert('ကျေးဇူးပြု၍ Session အမည်နှင့် အချိန်များကို အပြည့်အစုံ ဖြည့်သွင်းပါ။');
        return;
    }

    fetch(`${window.baseUrl}/api/twod/session-settings/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            session_name: sessionName,
            open_time: openTime,
            close_time: closeTime
        })
    })
    .then(response => response.json())
    .then(res => {
        if (res.success || res.status === 'success') {
            alert('စက်ရှင် အချိန်များကို အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။');
            let modalEl = document.getElementById('twodSettingsModal') || document.getElementById('sessionSettingsModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            if (typeof fetchTwoDBets === 'function') {
                fetchTwoDBets();
            }
        } else {
            alert(res.message || 'သိမ်းဆည်းရာတွင် အမှားအယွင်း ရှိခဲ့ပါသည်။');
        }
    })
    .catch(err => {
        console.error('Error saving session settings:', err);
        alert('ဆာဗာသို့ ချိတ်ဆက်၍မရပါ။ ကျေးဇူးပြု၍ ပြန်ကြိုးစားပါ။');
    });
}

// 2D ကြေငြာရန် Modal ဖွင့်ခြင်း
function openTwoDAnnounceModal() {
    document.getElementById('twodAnnounceForm').reset();
    document.getElementById('announceMultiplier').value = '80'; // မူလ ၈၀ ဆ ထည့်ပေးထားခြင်း
    var myModal = new bootstrap.Modal(document.getElementById('twodAnnounceModal'));
    myModal.show();
}

document.addEventListener('input', function (e) {
    if (e.target.tagName === 'INPUT' && (e.target.type === 'number' || e.target.classList.contains('number-field') || e.target.id === 'winningNumber' || e.target.id === 'announceMultiplier')) {
        const burmeseMap = {'၀': '0', '၁': '1', '၂': '2', '၃': '3', '၄': '4', '၅': '5', '၆': '6', '၇': '7', '၈': '8', '၉': '9'};
        let val = e.target.value;
        let converted = val.replace(/[၀-၉]/g, match => burmeseMap[match]);
        let numbersOnly = converted.replace(/[^0-9]/g, '');
        if (val !== numbersOnly) {
            e.target.value = numbersOnly;
        }
    }
});

// 2D ဂဏန်းကြေငြာပြီး User Bets များနှင့် တိုက်စစ်ကာ ငွေရှင်းခြင်း
function submitTwoDAnnounce() {
    let session = document.getElementById('announceSession').value;
    let multiplier = document.getElementById('announceMultiplier').value;
    let winningNumber = document.getElementById('winningNumber').value.trim();

    if (!session || !multiplier || !winningNumber) {
        alert('ကျေးဇူးပြု၍ အချက်အလက်များကို အပြည့်အစုံ ဖြည့်သွင်းပါ။');
        return;
    }

    if (winningNumber.length !== 2) {
        alert('ကျေးဇူးပြု၍ မှန်ကန်သော 2D ဂဏန်း (၂ လုံး) ထည့်သွင်းပါ။');
        return;
    }

    // Status 1 (Complete) နှင့် win_amount ကို bets ထဲတွင် စနစ်တကျ ထည့်သွင်းတွက်ချက်ရန် Payload ကို ပြင်ဆင်ခြင်း
    let payload = {
        session: session,
        multiplier: Number(multiplier),
        number: winningNumber,
        status: 1, // status 1 ဖြစ်စေရန်
        status_text: 'complete' // complete အဖြစ် သတ်မှတ်ရန်
    };

    fetch(`${window.baseUrl}/api/twod/declare-result`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message || '2D ဂဏန်းကြေငြာခြင်းနှင့် အနိုင်/အရှုံး ငွေရှင်းလင်းခြင်း အောင်မြင်ပါသည်။');
            let modalEl = document.getElementById('twodAnnounceModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            location.reload();
        } else {
            alert('အမှားအယွင်း ရှိပါသည်။: ' + (data.message || ''));
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    });
}

//is_open 
async function updateSessionOpenStatus(sessionName, isOpen) {
    try {
        let res = await fetch(`${window.baseUrl}/api/twod/session-statuses`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({
                session_name: sessionName,
                is_open: isOpen
            })
        });

        let result = await res.json();

        if (res.ok && (result.status === 'success' || result.success)) {
            console.log(`${sessionName} ၏ ဖွင့်ပိတ်အခြေအနေကို ${isOpen} သို့ အောင်မြင်စွာ ပြောင်းလဲပြီးပါပြီ။`);
        } else {
            alert('အခြေအနေပြောင်းလဲရာတွင် အမှားအယွင်း ရှိပါသည်: ' + (result.message || ''));
        }
    } catch (e) {
        console.error('Error updating session open status:', e);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    }
}



function toggleSidebar() {
    document.getElementById('appSidebar').classList.toggle('show');
}

function switchTab(tabId, event) {
    document.querySelectorAll('.tab-content-section').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.sidebar .nav-link').forEach(el => el.classList.remove('active'));
    
    let targetTab = document.getElementById(tabId + '-tab');
    if (targetTab) targetTab.classList.add('active');

    // Sidebar တွင် Active ဖြစ်ရမည့် Link ကို ရှာပြီး Class ထည့်ရန်
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    } else {
        // Refresh ဖြစ်သွားလျှင်တောင် မှတ်ထားသော Tab ကို ပြန်ရွေးပေးရန်
        let activeLink = document.querySelector(`.sidebar .nav-link[onclick*="switchTab('${tabId}'"]`);
        if (activeLink) activeLink.classList.add('active');
    }

    // LocalStorage တွင် လက်ရှိ Tab ကို မှတ်ထားမည်
    localStorage.setItem('activeAdminTab', tabId);

    if(window.innerWidth < 992) {
        toggleSidebar();
    }

    const titles = {
        'home': 'Dashboard Home',
        'users': 'Users Management',
        'twodbets': '2D User Bets',
        'animalbet': 'AnimalBet စာရင်းများ',
        'football': 'ဘောပွဲ စီမံခန့်ခွဲမှု',
        'livestream': 'Live Stream စီမံခန့်ခွဲမှု',
        'image-slider': 'Image Slider စီမံခန့်ခွဲမှု'
        
    };
    document.getElementById('current-tab-title').innerText = titles[tabId] || 'Dashboard';
}

function logout() {
    window.location.href = '/logout';
}

// Timer Settings Modal ဖွင့်ရန်
async function openTimerSettings() {
    try {
        let res = await fetch(`${window.baseUrl}/api/config/timer`, {
            method: 'GET',
            headers: { 
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            }
        });
        
        let data = await res.json();
        
        if (res.ok && data) {
            let totalSec = parseInt(data.durationSeconds || 0);
            
            // စုစုပေါင်း စက္ကန့်မှ နာရီ၊ မိနစ်၊ စက္ကန့် ခွဲထုတ်ခြင်း
            let hrs = Math.floor(totalSec / 3600);
            let mins = Math.floor((totalSec % 3600) / 60);
            let secs = totalSec % 60;

            document.getElementById('durationHours').value = hrs > 0 ? hrs : '';
            document.getElementById('durationMinutes').value = mins > 0 ? mins : '';
            document.getElementById('durationSeconds').value = secs > 0 ? secs : '';
            document.getElementById('endTimeInput').value = data.endTime ? data.endTime.replace(' ', 'T') : '';
        }
    } catch (e) {
        console.error('Error fetching timer config:', e);
    }

    var timerModal = new bootstrap.Modal(document.getElementById('timerSettingsModal'));
    timerModal.show();
}

    // Timer Settings သိမ်းဆည်းရန်
async function saveTimerSettings() {
    let hrs = parseInt(document.getElementById('durationHours').value) || 0;
    let mins = parseInt(document.getElementById('durationMinutes').value) || 0;
    let secs = parseInt(document.getElementById('durationSeconds').value) || 0;

    let totalSeconds = (hrs * 3600) + (mins * 60) + secs;
    let endTime = document.getElementById('endTimeInput').value;

    if (totalSeconds <= 0) {
        alert('ကျေးဇူးပြု၍ ကြာချိန် (Duration) ကို အနည်းဆုံး ၁ စက္ကန့် သို့မဟုတ် ထို့ထက်ပို၍ ထည့်သွင်းပါ။');
        return;
    }

    try {
        let res = await fetch(`${window.baseUrl}/api/config/timer/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + window.apiToken
            },
            body: JSON.stringify({ 
                durationSeconds: totalSeconds, 
                endTime: endTime 
            })
        });
        
        let result = await res.json();

        if (res.ok) {
            alert('Timer အချက်အလက်များ အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။');
            var modalEl = document.getElementById('timerSettingsModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        } else {
            alert('သိမ်းဆည်းရာတွင် အမှားအယွင်း ရှိနေပါသည်။ (Error: ' + (result.message || res.statusText) + ')');
        }
    } catch (e) {
        console.error('Error saving timer config:', e);
    }
} // <--- saveTimerSettings function ဤနေရာတွင် တိကျစွာ ပြီးဆုံးရပါမည်။


// ========================================================
// 🟢 Admin Chat System Logic (Global Scope သို့ တိကျစွာ ရွှေ့ပြီး)
// ========================================================

let selectedChatUserId = null;
let activeChatUserId = null;
let chatCheckInterval = null;
let lastChatCounts = {}; // User တစ်ဦးချင်းစီအလိုက် နောက်ဆုံး မက်ဆေ့ဂျ် အရေအတွက်ကို မှတ်ထားရန်

document.addEventListener("DOMContentLoaded", function() {
    fetchAdminChatUsers();
    // ၅ စက္ကန့်တစ်ကြိမ် Chat List ကို အလိုအလျောက် Refresh လုပ်ရန်နှင့် စာအသစ်ဝင်လာမလာ စစ်ဆေးရန်
    setInterval(fetchAdminChatUsers, 5000);
});

// 1. Admin Chat User စာရင်းများကို API မှ ဆွဲထုတ်ခြင်း (စာအသစ်ဝင်လာပါက သိရှိနိုင်ရန် စစ်ဆေးခြင်းအပါအဝင်)
function fetchAdminChatUsers() {
    fetch(`${window.Laravel.baseUrl}/api/admin/chat/users`, {
        headers: {
            'Authorization': 'Bearer ' + window.Laravel.token,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(res => {
        let userListContainer = document.getElementById('adminChatUserList');
        if (!userListContainer) return;

        userListContainer.innerHTML = `<div class="p-2 border-bottom fw-bold text-muted small">စကားပြောထားသော User များ</div>`;

        let users = res.users || [];
        if (!Array.isArray(users) || users.length === 0) {
            userListContainer.innerHTML += `<div class="p-3 text-center text-muted small">စကားပြောဆိုထားသော ချက်တင်များ မရှိသေးပါ။</div>`;
            return;
        }

        users.forEach(user => {
            let activeClass = selectedChatUserId == user.id ? 'bg-white border-start border-4 border-purple' : '';
            
            // 🟢 နောက်တစ်ယောက် (သို့မဟုတ် လက်ရှိပြောနေသူမဟုတ်သူများ) ထံမှ စာအသစ်ဝင်လာခြင်း ရှိမရှိ စစ်ဆေးရန်
            // (API တွင် unread_count သို့မဟုတ် last_message ပါရှိမှုကို စစ်ဆေးနိုင်သည်၊ မပါပါက UI တွင် Badge ပြရန် ဤနေရာတွင် တိုးမြှင့်နိုင်သည်)
            let hasNewMessage = user.unread_count && user.unread_count > 0;
            let unreadBadge = hasNewMessage ? `<span class="badge bg-danger float-end">စာအသစ်</span>` : '';

            userListContainer.innerHTML += `
                <div class="p-2 border-bottom user-chat-item ${activeClass}" style="cursor: pointer;" onclick="loadAdminChatMessages(${user.id}, '${user.name ?? 'User'}')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold text-dark">${user.name ?? 'အမည်မရှိ'}</div>
                        ${unreadBadge}
                    </div>
                    <small class="text-muted text-truncate d-block">${user.phone ?? user.email ?? ''}</small>
                </div>
            `;
        });
    })
    .catch(error => console.error('Error fetching chat users:', error));
}

// 2. သက်ဆိုင်ရာ User ၏ Chat Messages များကို ဆွဲထုတ်ပြသခြင်း
function loadAdminChatMessages(userId, userName) {
    selectedChatUserId = userId;
    let labelEl = document.getElementById('activeChatUserLabel');
    if (labelEl) labelEl.innerText = `${userName} နှင့် ပြောဆိုနေသည်`;

    let inputEl = document.getElementById('adminChatInput');
    let sendBtn = document.getElementById('adminSendBtn');
    if (inputEl) inputEl.disabled = false;
    if (sendBtn) sendBtn.disabled = false;

    fetch(`${window.Laravel.baseUrl}/api/admin/chat/messages/${userId}`, {
        headers: {
            'Authorization': 'Bearer ' + window.Laravel.token,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(res => {
        let chatBox = document.getElementById('adminChatBox');
        if (!chatBox) return;
        chatBox.innerHTML = '';

        let messages = res.chats || [];
        if (!Array.isArray(messages) || messages.length === 0) {
            chatBox.innerHTML = `<div class="text-center text-muted mt-5">မက်ဆေ့ဂျ်များ မရှိသေးပါ။</div>`;
            return;
        }

        messages.forEach(msg => {
            let isAdmin = msg.sender_type === 'admin' || msg.is_admin;
            let alignClass = isAdmin ? 'text-end' : 'text-start';
            let isUnread = !isAdmin && (msg.is_read === 0 || msg.is_read === false || msg.status === 'unread');
            let bgClass = isAdmin ? 'bg-purple text-white' : (isUnread ? 'bg-warning bg-opacity-25 border border-warning text-dark fw-bold' : 'bg-light text-dark');
            
            chatBox.innerHTML += `
                <div class="mb-2 ${alignClass}">
                    <div class="d-inline-block p-2 rounded-3 ${bgClass}" style="max-width: 75%; text-align: left; background-color: ${isAdmin ? '#6f42c1 !important;' : ''}">
                        <div>${msg.message || msg.body || ''}</div>
                        <small class="opacity-75" style="font-size: 10px;">${msg.created_at || ''}</small>
                    </div>
                </div>
            `;
        });
        chatBox.scrollTop = chatBox.scrollHeight;
    })
    .catch(err => console.error('Error fetching chat messages:', err));
}

// 3. မက်ဆေ့ဂျ် ပို့ဆောင်ခြင်း
function sendAdminMessage(event) {
    event.preventDefault(); 

    let input = document.getElementById('adminChatInput');
    let message = input.value.trim();
    
    if (!message) return;

    if (!selectedChatUserId) {
        alert('ကျေးဇူးပြု၍ စကားပြောမည့် User ကို အရင်ရွေးချယ်ပါ။');
        return;
    }

    fetch(`${window.baseUrl}/api/admin/chat/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + window.apiToken
        },
        body: JSON.stringify({
            user_id: selectedChatUserId,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' || data.success) {
            input.value = ''; 
            let activeLabel = document.getElementById('activeChatUserLabel').innerText;
            let userName = activeLabel.includes(' နှင့်') ? activeLabel.split(' နှင့်')[0] : 'User';
            loadAdminChatMessages(selectedChatUserId, userName);
        } else {
            alert('စာပို့ရာတွင် အမှားအယွင်း ရှိပါသည်။: ' + (data.message || ''));
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    });
}