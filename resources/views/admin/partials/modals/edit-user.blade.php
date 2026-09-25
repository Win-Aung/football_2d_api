<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">User အချက်အလက် ပြင်ဆင်ရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId">
                    <div class="mb-3">
                        <label for="editUserName" class="form-label">အမည် (Name)</label>
                        <input type="text" class="form-control" id="editUserName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserPhone" class="form-label">ဖုန်းနံပါတ် (Phone)</label>
                        <input type="text" class="form-control" id="editUserPhone">
                    </div>
                    <div class="mb-3">
                        <label for="editUserPayment" class="form-label">ငွေပေးချေသည့် ပုံစံ (Payment)</label>
                        <select class="form-control" id="editUserPayment">
                            <option value="KBZPay">KBZPay</option>
                            <option value="AYA Pay">AYA Pay</option>
                            <option value="Wave Money">Wave Money</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUserBalance" class="form-label">လက်ကျန်ငွေ (Balance)</label>
                        <input type="number" class="form-control" id="editUserBalance">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="updateUser()">အပြောင်းအလဲ သိမ်းမည်</button>
            </div>
        </div>
    </div>
</div>