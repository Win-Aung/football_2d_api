<div id="livestream-tab" class="tab-content-section">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <!-- သိမ်းဆည်းမည် ခလုတ် -->
            <button type="button" class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#liveStreamModal" onclick="resetLiveStreamForm()">သိမ်းဆည်းမည်</button>
        </div>
    </div>

    <!-- 🟢 သိမ်းဆည်းထားသော လင့်ခ်များကို ဇယားဖြင့် ပြသရန် -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="fa-solid fa-video me-2"></i>Live Stream လင့်ခ်များ စာရင်း
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">စဉ်</th>
                            <th>ပြိုင်ပွဲအမျိုးအစား / ပွဲစဉ်</th>
                            <th>ကစားမည့် ရက်စွဲနှင့် အချိန်</th>
                            <th>Stream URL (m3u8)</th>
                            <th class="text-center" style="width: 100px;">အခြေအနေ</th>
                            <th class="text-center" style="width: 90px;">ပြင်ဆင်ရန်</th>
                        </tr>
                    </thead>
                    <tbody id="live-streams-table-body">
                        <!-- API ဖြင့် ဒေတာများ ဝင်ရောက်လာမည် -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 🟢 Live Stream Modal (Add / Edit အတွက် သုံးရန်) -->
<div class="modal fade" id="liveStreamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">Live Stream အချက်အလက်များ သိမ်းဆည်းရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="streamId">
                <div class="mb-3">
                    <label for="streamUrlTextarea" class="form-label fw-bold">Stream URL (သို့) Link ထည့်ရန်</label>
                    <textarea class="form-control" id="streamUrlTextarea" rows="3" placeholder="လင့်ခ်များကို ဤနေရာတွင် ထည့်ပါ..."></textarea>
                </div>

                <!-- 🟢 h_logo အတွက် ထည့်သွင်းပေးသော Input Field -->
                <div class="mb-3">
                    <label for="hLogoTextarea" class="form-label fw-bold">h_logo (Home Team Logo Link)</label>
                    <textarea class="form-control" id="hLogoTextarea" rows="2" placeholder="h_logo လင့်ခ်ထည့်ရန်..."></textarea>
                </div>

                <!-- 🟢 w_logo အတွက် ထည့်သွင်းပေးသော Input Field -->
                <div class="mb-3">
                    <label for="wLogoTextarea" class="form-label fw-bold">w_logo (Away Team Logo Link)</label>
                    <textarea class="form-control" id="wLogoTextarea" rows="2" placeholder="w_logo လင့်ခ်ထည့်ရန်..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="streamDescriptionTextarea" class="form-label fw-bold">ဖော်ပြချက် (သို့) မှတ်စုများ ထည့်ရန်</label>
                    <textarea class="form-control" id="streamDescriptionTextarea" rows="3" placeholder="အသေးစိတ် အချက်အလက်များကို ဤနေရာတွင် ထည့်ပါ..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="streamStatus" class="form-label fw-bold">Status (အခြေအနေ)</label>
                    <select class="form-select" id="streamStatus">
                        <option value="1" selected>Active (ဖွင့်မည်)</option>
                        <option value="0">Inactive (ပိတ်မည်)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="saveLiveStreamData()">သိမ်းဆည်းမည်</button>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
let allStreamsData = []; // 🟢 ဒေတာများကို သိမ်းဆည်းထားရန် Global Array

document.addEventListener("DOMContentLoaded", function() {
    fetchLiveStreams();
});

function fetchLiveStreams() {
    let apiUrl = (window.baseUrl ? window.baseUrl : '') + '/api/admin/livestream/list';
    
    fetch(apiUrl, {
        headers: {
            'Authorization': 'Bearer ' + (window.apiToken || ''),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        let streams = [];
        if (Array.isArray(response)) {
            streams = response;
        } else if (response.data && Array.isArray(response.data)) {
            streams = response.data;
        } else if (response.streams && Array.isArray(response.streams)) {
            streams = response.streams;
        }

        allStreamsData = streams; // 🟢 Edit လုပ်ရန်အတွက် ဒေတာများကို သိမ်းထားခြင်း
        let tbody = document.getElementById('live-streams-table-body');
        if (!tbody) return;
        tbody.innerHTML = '';

        if (streams.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">သိမ်းဆည်းထားသော Live Stream လင့်ခ်များ မရှိသေးပါ။</td></tr>`;
            return;
        }

        streams.forEach((item, index) => {
            let streamSlug = item.stream_url || '';
            let streamUrl = item.description || ''; 
            let status = item.status;
            let hLogo = item.h_logo || ''; 
            let wLogo = item.w_logo || ''; 
            let itemId = item.id;

            let cleanSlug = streamSlug.replace(/^\/truc-tiep\//, '');
            let regex = /^(.*?)-luc-(\d{4})-ngay-(\d{2}-\d{2}-\d{4})-([a-z0-9]+)$/;
            let matchParts = cleanSlug.match(regex);

            let matchName = '';
            let matchTime = '';
            let matchDate = '';

            if (matchParts) {
                matchName = matchParts[1].replace(/-/g, ' ').toUpperCase();
                let rawTime = matchParts[2]; 
                matchTime = rawTime.slice(0, 2) + ':' + rawTime.slice(2) + ' နာရီ'; 
                matchDate = matchParts[3]; 
            } else {
                matchName = cleanSlug.replace(/-/g, ' ').toUpperCase();
                matchTime = '-';
                matchDate = '-';
            }
            
            // 🟢 အခြေအနေကို Switch ခလုတ် (Toggle) အဖြစ် ဖန်တီးခြင်း
            let isChecked = status == 1 ? 'checked' : '';
            let statusSwitch = `
                <div class="form-check form-switch d-flex justify-content-center">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch_${itemId}" ${isChecked} onchange="toggleStreamStatus(${itemId}, this)">
                </div>
            `;

            // 🟢 အိမ်ရှင်နှင့် ဧည့်သည် Logo များကို ပုံစံတကျ ပေါ်လာစေရန် HTML တည်ဆောက်ခြင်း
            let teamsDisplay = `
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center gap-1">
                        ${hLogo ? `<img src="${hLogo}" alt="H Logo" style="width: 24px; height: 24px; object-fit: contain;">` : ''}
                        <span class="fw-bold text-dark">${matchName.split(' VS ')[0] || matchName}</span>
                    </div>
                    <span class="text-muted fw-semibold">VS</span>
                    <div class="d-flex align-items-center gap-1">
                        <span class="fw-bold text-dark">${matchName.split(' VS ')[1] || ''}</span>
                        ${wLogo ? `<img src="${wLogo}" alt="W Logo" style="width: 24px; height: 24px; object-fit: contain;">` : ''}
                    </div>
                </div>
            `;

            tbody.innerHTML += `
                <tr>
                    <td class="text-center fw-bold text-secondary">#${index + 1}</td>
                    <td>${teamsDisplay}</td>
                    <td>
                        <div class="text-primary fw-bold"><i class="fa-regular fa-calendar-days me-1"></i>${matchDate}</div>
                        <small class="text-danger fw-semibold"><i class="fa-regular fa-clock me-1"></i>${matchTime}</small>
                    </td>
                    <td>
                        <a href="${streamUrl}" target="_blank" class="text-decoration-none text-primary small text-truncate d-inline-block" style="max-width: 250px;">
                            <i class="fa-solid fa-video me-1"></i>${streamUrl}
                        </a>
                    </td>
                    <td class="text-center">
                        ${statusSwitch}
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-primary px-2 py-1" onclick="editStream(${itemId})">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                    </td>
                </tr>
            `;
        });
    })
    .catch(err => {
        console.error('Error fetching live streams:', err);
        let tbody = document.getElementById('live-streams-table-body');
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-danger">ဒေတာဆွဲထုတ်ရာတွင် အမှားအယွင်းရှိနေပါသည်။</td></tr>`;
        }
    });
}

// 🟢 ဖောင်အသစ်ထည့်ရန် Reset လုပ်ခြင်း
function resetLiveStreamForm() {
    document.getElementById('modalTitle').innerText = 'Live Stream အချက်အလက်များ သိမ်းဆည်းရန်';
    document.getElementById('streamId').value = '';
    document.getElementById('streamUrlTextarea').value = '';
    document.getElementById('hLogoTextarea').value = '';
    document.getElementById('wLogoTextarea').value = '';
    document.getElementById('streamDescriptionTextarea').value = '';
    document.getElementById('streamStatus').value = '1';
}

// 🟢 Edit ခလုတ်နှိပ်သည့်အခါ ဒေတာများကို Modal ထဲသို့ ထည့်ပေးခြင်း
function editStream(id) {
    let item = allStreamsData.find(s => s.id == id);
    if (!item) return;

    document.getElementById('modalTitle').innerText = 'Live Stream အချက်အလက်များ ပြင်ဆင်ရန်';
    document.getElementById('streamId').value = item.id;
    document.getElementById('streamUrlTextarea').value = item.stream_url || '';
    document.getElementById('hLogoTextarea').value = item.h_logo || '';
    document.getElementById('wLogoTextarea').value = item.w_logo || '';
    document.getElementById('streamDescriptionTextarea').value = item.description || '';
    document.getElementById('streamStatus').value = item.status !== undefined ? item.status : 1;

    let myModal = new bootstrap.Modal(document.getElementById('liveStreamModal'));
    myModal.show();
}

// 🟢 Switch ဖြင့် အခြေအနေ (Status) ပြောင်းလဲခြင်း
function toggleStreamStatus(id, element) {
    let newStatus = element.checked ? 1 : 0;
    let updateUrl = (window.baseUrl ? window.baseUrl : '') + `/api/admin/livestream/update-status/${id}`;

    let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    let apiToken = window.apiToken || localStorage.getItem('token') || '';

    fetch(updateUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + apiToken,
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'include', // Session cookies များကိုပါ ပူးတွဲပို့ပေးရန်
        body: JSON.stringify({ status: newStatus })
    })
    .then(async res => {
        let data;
        try {
            data = await res.json();
        } catch (e) {
            data = { status: 'error', message: 'Invalid JSON response from server' };
        }

        if (!res.ok) {
            throw new Error(data.message || `Server Error: ${res.status}`);
        }
        
        return data;
    })
    .then(data => {
        if (!(data.status === 'success' || data.success)) {
            alert('အခြေအနေပြောင်းလဲရာတွင် အမှားအယွင်းရှိပါသည်: ' + (data.message || ''));
            element.checked = !element.checked; // အမှားဖြစ်လျှင် မူလအတိုင်း ပြန်ပြောင်းရန်
        }
    })
    .catch(err => {
        console.error('Toggle Error:', err);
        alert('ချိတ်ဆက်မှု အမှား: ' + err.message);
        element.checked = !element.checked; // အမှားဖြစ်လျှင် မူလအတိုင်း ပြန်ပြောင်းရန်
    });
}

// 🟢 ဒေတာ သိမ်းဆည်းရန် (သို့) Update လုပ်ရန် Function
function saveLiveStreamData() {
    let id = document.getElementById('streamId').value;
    let streamUrl = document.getElementById('streamUrlTextarea').value;
    let hLogo = document.getElementById('hLogoTextarea').value;
    let wLogo = document.getElementById('wLogoTextarea').value;
    let description = document.getElementById('streamDescriptionTextarea').value;
    let status = document.getElementById('streamStatus').value;

    let url = (window.baseUrl ? window.baseUrl : '') + (id ? `/api/admin/livestream/update/${id}` : '/api/admin/livestream/store');

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + (window.apiToken || ''),
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
            stream_url: streamUrl,
            h_logo: hLogo,
            w_logo: wLogo,
            description: description,
            status: status
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success' || data.success) {
            alert('အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။');
            location.reload();
        } else {
            alert('အမှားအယွင်းရှိပါသည်: ' + (data.message || ''));
        }
    })
    .catch(err => console.error('Error:', err));
}
</script>