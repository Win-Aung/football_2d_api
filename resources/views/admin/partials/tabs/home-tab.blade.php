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
                <div class="col-md-4 border-end overflow-auto bg-light" id="adminChatUserList" style="height: 100%;">
                    <div class="p-2 border-bottom fw-bold text-muted small">စကားပြောထားသော User များ</div>
                    <span class="badge bg-danger rounded-pill" id="totalUnreadBadge" style="display: none;">0</span>
                </div>
                <div class="col-md-8 d-flex flex-column" style="height: 100%;">
                    <div class="flex-grow-1 p-3 overflow-auto bg-white" id="adminChatBox" style="height: calc(100% - 60px);">
                        <div class="text-center text-muted mt-5">ကျေးဇူးပြု၍ ဘယ်ဘက်မှ User တစ်ဦးကို ရွေးချယ်ပါ။</div>
                    </div>
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