<div id="animalbet-tab" class="tab-content-section">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-paw me-2"></i>တိရစ္ဆာန်ဂိမ်း ထိုးငွေမှတ်တမ်းများ</h5>
        <div>
            <button class="btn btn-outline-danger btn-sm me-2" onclick="deleteSelectedAnimalBets()">
                <i class="fa-solid fa-trash me-1"></i> ရွေးချယ်ထားသည်များ ဖျက်မည်
            </button>
            <button class="btn btn-outline-primary btn-sm" onclick="fetchAnimalBetsHistory()">
                <i class="fa-solid fa-rotate-right me-1"></i> Refresh
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="animal-bets-table">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 px-3" style="width: 40px;">
                            <input type="checkbox" id="selectAllAnimalBets" onclick="toggleSelectAllAnimalBets(this)">
                        </th>
                        <th class="py-3 px-3">ID</th>
                        <th class="py-3 px-3">User အမည်</th>
                        <th class="py-3 px-3">ထိုးထားသော တိရစ္ဆာန်များနှင့် ပမာဏ</th>
                        <th class="py-3 px-3">စုစုပေါင်းငွေ</th>
                        <th class="py-3 px-3">ထွက်သောကောင် (Lucky Animal)</th>
                        <th class="py-3 px-3">အခြေအနေ (Status)</th>
                        <th class="py-3 px-3">အနိုင်ရငွေ (Win)</th>
                        <th class="py-3 px-3">အချိန်</th>
                    </tr>
                </thead>
                <tbody id="animal-bets-table-body">
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">ဒေတာများကို ရယူနေပါသည်...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination Container -->
        <div id="animalBetPaginationContainer" class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetchAnimalBetsHistory();
});

let allAnimalBetsData = [];
let currentAnimalPage = 1;
const animalRowsPerPage = 10;

function fetchAnimalBetsHistory() {
    let url = `${window.baseUrl || ''}/api/animal/history`;
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + (window.apiToken || window.Laravel?.token || ''),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success' && res.data) {
            allAnimalBetsData = res.data;
            renderAnimalTablePage(currentAnimalPage);
        } else {
            let tbody = document.getElementById('animal-bets-table-body');
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4 text-muted">မှတ်တမ်း ဒေတာ မရှိသေးပါ။</td></tr>`;
            }
        }
    })
    .catch(error => {
        console.error('Error fetching animal bets history:', error);
        let tbody = document.getElementById('animal-bets-table-body');
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4 text-danger">ဒေတာဆွဲထုတ်ရာတွင် အမှားအယွင်း ရှိပါသည်။</td></tr>`;
        }
    });
}

function renderAnimalTablePage(page) {
    let tbody = document.getElementById('animal-bets-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    // Header checkbox ကို အစမှာ uncheck လုပ်ထားမယ်
    let selectAllCheckbox = document.getElementById('selectAllAnimalBets');
    if (selectAllCheckbox) selectAllCheckbox.checked = false;

    if (!allAnimalBetsData || allAnimalBetsData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4 text-muted">တိရစ္ဆာန်ဂိမ်း ထိုးငွေမှတ်တမ်းများ မရှိသေးပါ။</td></tr>`;
        renderAnimalPaginationControls(0);
        return;
    }

    let start = (page - 1) * animalRowsPerPage;
    let end = start + animalRowsPerPage;
    let paginatedItems = allAnimalBetsData.slice(start, end);

    paginatedItems.forEach(bet => {
        let statusBadge = 'bg-warning text-dark';
        let sLower = (bet.status || '').toLowerCase();
        if (sLower === 'win') {
            statusBadge = 'bg-success';
        } else if (sLower === 'lost' || sLower === 'lose') {
            statusBadge = 'bg-danger';
        }

        let betsDetailsHtml = '';
        if (Array.isArray(bet.bets_json)) {
            bet.bets_json.forEach(b => {
                let animalName = b.animal_name || b.animal || '-';
                let amount = b.amount || 0;
                let bStatus = b.status ? `(${b.status})` : '';
                betsDetailsHtml += `<div class="small">• ${animalName}: <strong>${Number(amount).toLocaleString()} ကျပ်</strong> ${bStatus}</div>`;
            });
        } else {
            betsDetailsHtml = '<span class="text-muted">-</span>';
        }

        tbody.innerHTML += `
            <tr>
                <td class="py-3 px-3">
                    <input type="checkbox" class="animal-row-checkbox" value="${bet.id}">
                </td>
                <td class="py-3 px-3 fw-semibold text-secondary">#${bet.id}</td>
                <td class="py-3 px-3 fw-bold text-dark">${bet.userName || '-'}</td>
                <td class="py-3 px-3">
                    <div style="max-height: 120px; overflow-y: auto; max-width: 280px; padding-right: 5px;">
                        ${betsDetailsHtml}
                    </div>
                </td>
                <td class="py-3 px-3 fw-bold text-primary">${Number(bet.total_amount || 0).toLocaleString()} ကျပ်</td>
                <td class="py-3 px-3 fw-bold text-danger">${bet.luckyAnimal || '<span class="text-muted">စောင့်ဆိုင်းဆဲ</span>'}</td>
                <td class="py-3 px-3"><span class="badge ${statusBadge}">${bet.status}</span></td>
                <td class="py-3 px-3 fw-bold text-success">${Number(bet.winAmount || 0).toLocaleString()} ကျပ်</td>
                <td class="py-3 px-3 text-muted small">${bet.time || '-'}</td>
            </tr>
        `;
    });

    renderAnimalPaginationControls(Math.ceil(allAnimalBetsData.length / animalRowsPerPage));
}

// အကုန်လုံးကို Select မှတ်ရန် / ဖြုတ်ရန်
function toggleSelectAllAnimalBets(masterCheckbox) {
    let checkboxes = document.querySelectorAll('.animal-row-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
    });
}

// ရွေးချယ်ထားသော ID များကို ဖျက်ရန် လုပ်ဆောင်ချက်
function deleteSelectedAnimalBets() {
    let selectedIds = [];
    document.querySelectorAll('.animal-row-checkbox:checked').forEach(cb => {
        selectedIds.push(cb.value);
    });

    if (selectedIds.length === 0) {
        alert('ကျေးဇူးပြု၍ ဖျက်ရန် အနည်းဆုံး တစ်ခုကို ရွေးချယ်ပါ။');
        return;
    }

    if (!confirm(`ရွေးချယ်ထားသော မှတ်တမ်း ${selectedIds.length} ခု ကို ဖျက်ရန် သေချာပါသလား?`)) {
        return;
    }

    let deleteUrl = `${window.baseUrl || ''}/api/animal/history/delete`;

    fetch(deleteUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + (window.apiToken || window.Laravel?.token || ''),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ ids: selectedIds })
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success' || res.success) {
            alert('အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
            fetchAnimalBetsHistory(); 
        } else {
            alert('ဖျက်ဆီးရာတွင် အမှားအယွင်း ရှိပါသည်။');
        }
    })
    .catch(error => {
        console.error('Error deleting bets:', error);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    });
}

function renderAnimalPaginationControls(totalPages) {
    let container = document.getElementById('animalBetPaginationContainer');
    if (!container) return;
    container.innerHTML = '';

    if (totalPages <= 1) return;

    let infoText = document.createElement('small');
    infoText.className = 'text-muted';
    infoText.innerText = `စာမျက်နှာ ${currentAnimalPage} / ${totalPages}`;
    container.appendChild(infoText);

    let ul = document.createElement('ul');
    ul.className = 'pagination pagination-sm m-0';

    let prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentAnimalPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<button class="page-link" onclick="changeAnimalPage(${currentAnimalPage - 1})">ရှေ့သို့</button>`;
    ul.appendChild(prevLi);

    for (let i = 1; i <= totalPages; i++) {
        let li = document.createElement('li');
        li.className = `page-item ${currentAnimalPage === i ? 'active' : ''}`;
        li.innerHTML = `<button class="page-link" onclick="changeAnimalPage(${i})">${i}</button>`;
        ul.appendChild(li);
    }

    let nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentAnimalPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<button class="page-link" onclick="changeAnimalPage(${currentAnimalPage + 1})">နောက်သို့</button>`;
    ul.appendChild(nextLi);

    container.appendChild(ul);
}

function changeAnimalPage(page) {
    let totalPages = Math.ceil(allAnimalBetsData.length / animalRowsPerPage);
    if (page < 1 || page > totalPages) return;
    currentAnimalPage = page;
    renderAnimalTablePage(currentAnimalPage);
}
</script>