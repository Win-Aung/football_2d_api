<!-- ================= 4. WALLET & HISTORY TAB ================= -->
<div id="section-wallet" class="content-section">
    <div class="card bg-purple text-white mb-3 shadow">
        <div class="card-body">
            <h5 id="user-name-display" class="fw-bold">User Name</h5>
            <p id="user-phone-display" class="text-white-50 small mb-2">Phone</p>
            <hr class="border-white opacity-25">
            <div class="d-flex justify-content-between align-items-center">
                <span>လက်ကျန်ငွေ (Balance):</span>
                <h3 id="user-balance-display" class="text-warning fw-bold m-0">0 ကျပ်</h3>
            </div>
            <div class="row mt-3 g-2">
                <div class="col-6">
                    <button type="button" class="btn btn-success w-100 btn-sm" onclick="showTransactionModal('deposit')">
                        <i class="fa-solid fa-plus"></i> ငွေဖြည့်
                    </button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-warning text-white w-100 btn-sm" onclick="showTransactionModal('withdraw')">
                        <i class="fa-solid fa-minus"></i> ငွေထုတ်
                    </button>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-danger w-100 btn-sm" onclick="handleLogout()">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout (အကောင့်ထွက်ရန်)
                </button>
            </div>
        </div>
    </div>

    <!-- ငွေသွင်း / ငွေထုတ် မှတ်တမ်း ခလုတ်များ -->
    <div class="row g-2 mb-3">
        <div class="col-6">
            <button class="btn btn-secondary w-100 btn-sm" onclick="fetchHistory('deposit')">ငွေသွင်းမှတ်တမ်း</button>
        </div>
        <div class="col-6">
            <button class="btn btn-dark w-100 btn-sm" onclick="fetchHistory('withdraw')">ငွေထုတ်မှတ်တမ်း</button>
        </div>
    </div>

    <!-- ================= 5. CHAT SECTION (ငွေမှတ်တမ်းများအောက်တွင် ချိတ်ဆက်ရန်) ================= -->
    <div class="card shadow-sm border-0 mb-5" style="border-radius: 12px; overflow: hidden;">
        <div class="p-2 bg-purple text-white text-center fw-bold small" style="background-color: #6f42c1;">
            <i class="fa-solid fa-headset"></i> Admin နှင့် တိုက်ရိုက်ဆွေးနွေးရန်
        </div>
        <!-- Chat Messages Area -->
        <div class="chat-box p-2" id="chat-box" style="height: 250px; overflow-y: auto; background: #f9f6ff;">
            <!-- မက်ဆေ့ဂျ်များ ဝင်ရောက်လာမည် -->
        </div>
        <!-- Input Area -->
        <div class="chat-input-area p-2 bg-white border-top">
            <form id="chat-form" class="input-group input-group-sm" onsubmit="event.preventDefault(); sendChatMessage();">
                <input type="text" id="chat-input" class="form-control" placeholder="မက်ဆေ့ဂျ် ရေးရန်..." required>
                <button class="btn btn-purple text-white" type="submit" style="background-color: #6f42c1;">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- ================= END CHAT SECTION ================= -->

</div>

<!-- Transaction Modal (ငွေဖြည့် / ငွေထုတ် အတွက် Pop-up) -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalTitle">ငွေဖြည့်ရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="deposit-info-container" class="text-center mb-3">
                    <p class="fw-bold fs-6">ငွေလွှဲရန် QR Code နှင့် ဖုန်းနံပါတ်</p>
                    <img id="admin-qr-img" src="" alt="QR Code" class="img-fluid mb-2" style="max-height: 150px; display:none;">
                    <div class="alert alert-light p-2 text-dark border">
                        <i class="fa-solid fa-phone"></i> ဖုန်းနံပါတ်: <span id="admin-phone-val" class="fw-bold">-</span>
                    </div>
                </div>

                <form id="transactionForm" onsubmit="event.preventDefault(); submitTransaction();">
                    <input type="hidden" id="transaction-type" name="type">
                    <div class="mb-3">
                        <label class="form-label">ငွေပမာဏ (ကျပ်)</label>
                        <input type="number" id="transaction-amount" class="form-control" required min="100">
                    </div>
                    <div class="mb-3" id="tx-id-container">
                        <label class="form-label">လုပ်ငန်းစဥ်နံပါတ် (Transaction ID / Last 6 digits)</label>
                        <input type="text" id="transaction-id" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-purple text-white btn-sm" onclick="submitTransaction()" style="background-color: #6f42c1;">တင်သွင်းမည်</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ငွေဖြည့် သို့မဟုတ် ငွေထုတ် Modal ဖွင့်ရန်
    async function showTransactionModal(type) {
        let titleEl = document.getElementById('transactionModalTitle');
        let typeInput = document.getElementById('transaction-type');
        let depositInfoContainer = document.getElementById('deposit-info-container');
        let txIdContainer = document.getElementById('tx-id-container');
        
        typeInput.value = type.toLowerCase();
        
        document.getElementById('transaction-amount').value = '';
        document.getElementById('transaction-id').value = '';

        if (type.toLowerCase() === 'deposit') {
            titleEl.innerText = 'ငွေဖြည့်ရန် (Deposit)';
            depositInfoContainer.style.display = 'block';
            txIdContainer.style.display = 'block';

            try {
                let res = await fetch(`${baseUrl}/config/payment`, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                let data = await res.json();
                
                if (data) {
                    let qrImg = document.getElementById('admin-qr-img');
                    let qrVal = data.qrUrl || data.qr_url || data.qr_code;
                    if (qrVal) {
                        qrImg.src = qrVal;
                        qrImg.style.display = 'inline-block';
                    } else {
                        qrImg.style.display = 'none';
                    }
                    document.getElementById('admin-phone-val').innerText = data.phone || data.payment_phone || 'မရှိပါ။';
                }
            } catch (e) {
                console.error('Error fetching payment config:', e);
            }

        } else {
            titleEl.innerText = 'ငွေထုတ်ရန် (Withdraw)';
            depositInfoContainer.style.display = 'none';
            txIdContainer.style.display = 'none'; 
        }

        let modalElement = document.getElementById('transactionModal');
        let myModal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        myModal.show();
    }

    // ငွေသွင်း/ငွေထုတ် တောင်းဆိုချက်ကို Laravel API သို့ ပို့ရန်
    async function submitTransaction() {
        let type = document.getElementById('transaction-type').value;
        let amount = document.getElementById('transaction-amount').value;
        let transactionId = document.getElementById('transaction-id').value;

        if (!amount || amount <= 0) {
            alert('ကျေးဇူးပြု၍ မှန်ကန်သော ငွေပမာဏ ထည့်ပါ');
            return;
        }

        if (type === 'deposit' && !transactionId) {
            alert('ကျေးဇူးပြု၍ လုပ်ငန်းစဥ်နံပါတ် (Transaction ID) ထည့်ပါ။');
            return;
        }

        try {
            let res = await fetch(`${baseUrl}/submit-request`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    type: type,
                    amount: parseFloat(amount),
                    transaction_id: transactionId
                })
            });

            let data = await res.json();

            if (res.ok && (data.status === 'success' || data.success === true)) {
                alert(`${type === 'deposit' ? 'ငွေဖြည့်' : 'ငွေထုတ်'} တောင်းဆိုမှု အောင်မြင်ပါသည်။ Admin အတည်ပြုချက်ကို စောင့်ပါ။`);
                
                let modalEl = document.getElementById('transactionModal');
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if(typeof fetchUserInfo === 'function') fetchUserInfo();
            } else {
                alert(data.message || 'တောင်းဆိုမှု တင်၍ မရပါ');
            }
        } catch (e) {
            console.error('Transaction submit error:', e);
            alert('ချိတ်ဆက်မှု အမှားအယွင်း ရှိနေပါသည်။');
        }
    }

    // ငွေသွင်းမှတ်တမ်း သို့မဟုတ် ငွေထုတ်မှတ်တမ်း ရယူရန်
    async function fetchHistory(type) {
        let titleText = type === 'deposit' ? 'ငွေသွင်းမှတ်တမ်းများ' : 'ငွေထုတ်မှတ်တမ်းများ';
        
        let loadingModalEl = document.createElement('div');
        loadingModalEl.className = 'modal fade show';
        loadingModalEl.style.display = 'block';
        loadingModalEl.style.backgroundColor = 'rgba(0,0,0,0.5)';
        loadingModalEl.innerHTML = `
            <div class="modal-dialog modal-dialog-centered text-center">
                <div class="modal-content bg-transparent border-0 text-white">
                    <div class="spinner-border text-light mx-auto" role="status"></div>
                    <p class="mt-2">ရှာဖွေနေသည်...</p>
                </div>
            </div>
        `;
        document.body.appendChild(loadingModalEl);

        try {
            let res = await fetch(`${baseUrl}/user/requests`, {
                headers: { 
                    'Authorization': `Bearer ${token}`, 
                    'Accept': 'application/json' 
                }
            });
            
            loadingModalEl.remove();

            if (res.ok) {
                let decodedData = await res.json();
                let reqs = [];

                if (decodedData && typeof decodedData === 'object') {
                    if (Array.isArray(decodedData.requests)) {
                        reqs = decodedData.requests;
                    } else if (Array.isArray(decodedData)) {
                        reqs = decodedData;
                    }
                }

                let filteredRequests = reqs.filter(r => 
                    r && r.type && r.type.toLowerCase() === type.toLowerCase()
                );

                showTransactionListModal(titleText, filteredRequests);
            } else {
                alert('မှတ်တမ်းများ ရယူ၍ မရပါ');
            }
        } catch (e) {
            loadingModalEl.remove();
            console.error('Error fetching history:', e);
            alert('ချိတ်ဆက်မှု အမှားအယွင်း ရှိနေပါသည်။');
        }
    }

    // ရရှိလာသော မှတ်တမ်းများကို Modal ဖြင့် ပြသရန်
    function showTransactionListModal(title, transactionList) {
        let existingModal = document.getElementById('transactionListModal');
        if (existingModal) {
            existingModal.remove();
        }

        let modalHTML = `
            <div class="modal fade" id="transactionListModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ${
                                transactionList.length === 0 
                                ? `<p class="text-center text-muted my-4">မှတ်တမ်း မရှိသေးပါ</p>`
                                : `<div class="list-group">
                                    ${transactionList.map(data => {
                                        let amount = parseFloat(data.amount || 0);
                                        let status = data.status || 'Pending';
                                        let lowerStatus = status.toLowerCase();
                                        let txId = data.transactionId || data.transaction_id || '';
                                        let rawTime = data.time || data.created_at || '';
                                        let timeStr = rawTime.length >= 16 ? rawTime.substring(0, 16) : rawTime;

                                        let statusBg = 'bg-warning text-dark';
                                        if (lowerStatus === 'approved') {
                                            statusBg = 'bg-success text-white';
                                        } else if (lowerStatus === 'rejected') {
                                            statusBg = 'bg-danger text-white';
                                        }

                                        return `
                                            <div class="list-group-item mb-2 border rounded shadow-sm">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-bold fs-6">${amount.toLocaleString()} ကျပ်</span>
                                                    <span class="badge ${statusBg}">${status}</span>
                                                </div>
                                                ${txId ? `<small class="text-muted d-block">ID: ${txId}</small>` : ''}
                                                <small class="text-muted d-block">အချိန်: ${timeStr}</small>
                                            </div>
                                        `;
                                    }).join('')}
                                   </div>`
                            }
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);

        let modalElement = document.getElementById('transactionListModal');
        let myModal = new bootstrap.Modal(modalElement);
        myModal.show();
    }

    // ================= CHAT JAVASCRIPT FUNCTIONS =================
    const chatBoxEl = document.getElementById('chat-box');

    async function loadChatMessages() {
        if (!chatBoxEl) return;
        try {
            let response = await fetch(`${baseUrl}/chat/messages`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            let res = await response.json();
            if(res.status === 'success' && Array.isArray(res.chats)) {
                let currentScrollTop = chatBoxEl.scrollTop;
                let isAtBottom = chatBoxEl.scrollHeight - chatBoxEl.clientHeight <= currentScrollTop + 50;
                
                chatBoxEl.innerHTML = '';
                res.chats.forEach(chat => {
                    let senderClass = chat.sender_type === 'user' ? 'user' : 'admin';
                    let bubbleBg = chat.sender_type === 'user' ? 'background-color: #6f42c1; color: white;' : 'background-color: #e2d9f3; color: #333;';
                    let alignStyle = chat.sender_type === 'user' ? 'justify-content: flex-end;' : 'justify-content: flex-starl;';
                    
                    chatBoxEl.innerHTML += `
                        <div class="message mb-2 d-flex" style="${chat.sender_type === 'user' ? 'justify-content: flex-end;' : 'justify-content: flex-start;'}">
                            <div class="bubble px-3 py-2 rounded-3 shadow-sm" style="max-width: 75%; font-size: 13px; ${bubbleBg}">
                                ${escapeHtml(chat.message)}
                            </div>
                        </div>
                    `;
                });
                
                if (isAtBottom || res.chats.length <= 5) {
                    chatBoxEl.scrollTop = chatBoxEl.scrollHeight;
                }
            }
        } catch (err) {
            console.error('Error loading chat messages:', err);
        }
    }

    async function sendChatMessage() {
        let inputField = document.getElementById('chat-input');
        let message = inputField.value.trim();
        if(!message) return;

        try {
            let response = await fetch(`${baseUrl}/chat/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });
            let res = await response.json();
            if(res.status === 'success') {
                inputField.value = '';
                loadChatMessages();
            } else {
                alert(res.message || 'မက်ဆေ့ဂျ် ပို့၍ မရပါ');
            }
        } catch (err) {
            console.error('Error sending chat message:', err);
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        let map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Chat စာမျက်နှာ စတင်ဖွင့်ချိန်နှင့် ၃ စက္ကန့်တစ်ကြိမ် မက်ဆေ့ဂျ်အသစ် ရှိမရှိ စစ်ဆေးရန် (Polling)
    loadChatMessages();
    setInterval(loadChatMessages, 3000);
</script>