<div id="users-tab" class="tab-content-section">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <h5 class="card-title fw-bold text-dark m-0">
                    <i class="fa-solid fa-users-gear text-primary me-2"></i> Registered Users List & Balances
                </h5>
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                    <input type="text" id="userSearchInput" class="form-control form-control-sm border-start-0 bg-light" placeholder="နာမည် သို့မဟုတ် ဖုန်းဖြင့် ရှာရန်...">
                </div>
            </div>
            
            <ul class="nav nav-tabs mb-3" id="usersTabNav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="users-list-subtab" data-bs-toggle="tab" data-bs-target="#users-list-content" type="button">👥 User စာရင်းများ</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="users-payment-subtab" data-bs-toggle="tab" data-bs-target="#users-payment-content" type="button">💳 Payment</button>
                </li>
            </ul>

            <div class="tab-content p-3 bg-white border border-top-0 rounded-bottom shadow-sm">
                <!-- 1st Sub-tab: Users List -->
                <div class="tab-pane fade show active" id="users-list-content">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="usersTable">
                            <thead class="table-light text-secondary text-uppercase fs-7">
                                <tr>
                                    <th class="py-3 px-3">အမည် (Name)</th>
                                    <th class="py-3 px-3">ဖုန်းနံပါတ် (Phone)</th>
                                    <th class="py-3 px-3">ငွေလက်ခံသည့် ပုံစံ (Payment)</th>
                                    <th class="py-3 px-3">လက်ကျန်ငွေ (Balance)</th>
                                    <th class="py-3 px-3 text-center" style="width: 180px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body">
                                @forelse($users as $user)
                                    <tr>
                                        <td class="py-3 px-3 fw-bold text-dark">{{ $user->name ?? 'အမည်မရှိ (Admin)' }}</td>
                                        <td class="py-3 px-3 text-muted">{{ $user->phone ?? '-' }}</td>
                                        <td class="py-3 px-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 fw-semibold">
                                                {{ $user->payment ?? 'KBZPay' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 fw-bold text-success">{{ number_format($user->balance ?? 0) }} ကျပ်</td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" class="btn btn-sm btn-primary px-2 py-1" onclick="editUser({{ $user->id }})">
                                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger px-2 py-1" onclick="deleteUserConfirm({{ $user->id }})">
                                                    <i class="fa-solid fa-trash me-1"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-folder-open fs-3 mb-2 d-block text-secondary opacity-50"></i>
                                            မှတ်ပုံတင်ထားသော User များ မရှိသေးပါ။
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2nd Sub-tab: Payment -->
                <div class="tab-pane fade" id="users-payment-content">
                    <div class="py-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                            <h6 class="fw-bold mb-0 text-dark">
                                <i class="fa-solid fa-receipt text-primary me-2"></i> ငွေပေးချေမှု တောင်းဆိုချက်များ (Payment Requests)
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="max-width: 250px;">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                                    <input type="text" id="paymentSearchInput" class="form-control form-control-sm border-start-0 bg-light" placeholder="နာမည် သို့မဟုတ် ဖုန်းဖြင့် ရှာရန်...">
                                </div>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedPaymentRequests()">
                                    <i class="fa-solid fa-trash me-1"></i> ရွေးချယ်ထားသမျှ ဖျက်မည်
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive border rounded-3 bg-white shadow-sm">
                            <table class="table table-hover align-middle mb-0" id="paymentRequestsTable">
                                <thead class="table-light text-secondary text-uppercase fs-7">
                                    <tr>
                                        <th class="py-3 px-3" style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAllPaymentCheckbox" onclick="toggleSelectAllPayments(this)">
                                        </th>
                                        <th class="py-3 px-3">ID</th>
                                        <th class="py-3 px-3">User Name</th>
                                        <th class="py-3 px-3">Phone</th>
                                        <th class="py-3 px-3">Type</th>
                                        <th class="py-3 px-3">Amount</th>
                                        <th class="py-3 px-3">Payment</th>
                                        <th class="py-3 px-3">Transaction ID</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3">Time</th>
                                    </tr>
                                </thead>
                                <tbody id="payment-requests-table-body">
                                    <!-- Dynamic Data -->
                                </tbody>
                            </table>
                        </div>
                        <div id="paymentPaginationContainer" class="d-flex justify-content-between align-items-center mt-3 pt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('userSearchInput')?.addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#users-table-body tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

<!-- Edit User Modal -->
@include('admin.partials.modals.edit-user')