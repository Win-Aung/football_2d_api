<!-- 2D Session Settings Modal -->
<div class="modal fade" id="twodSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">⚙️ Session အလိုက် အချိန် စီမံရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="twodSettingsForm">
                    <div class="mb-3">
                        <label for="twodOpenTime" class="form-label fw-bold">ဖွင့်မည့်အချိန် (Open Time)</label>
                        <input type="datetime-local" class="form-control" id="twodOpenTime">
                    </div>
                    <div class="mb-3">
                        <label for="twodCloseTime" class="form-label fw-bold">ပိတ်မည့်အချိန် (Close Time)</label>
                        <input type="datetime-local" class="form-control" id="twodCloseTime">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="save2DSessionSettings()">သိမ်းမည်</button>
            </div>
        </div>
    </div>
</div>

<!-- 2D Announcement & Settle Modal -->
<div class="modal fade" id="twodAnnounceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">🎲 2D ဂဏန်းကြေငြာခြင်းနှင့် အနိုင်စစ်ဆေးရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="twodAnnounceForm">
                    <div class="mb-3">
                        <label for="announceSession" class="form-label fw-bold">Session ရွေးရန်</label>
                        <select class="form-select" id="announceSession" name="session" required>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="12:00 PM">12:00 PM</option>
                            <option value="3:00 PM">3:00 PM</option>
                            <option value="4:30 PM">4:30 PM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="winningNumber" class="form-label fw-bold">ထွက်မည့် 2D ဂဏန်း (Winning Number)</label>
                        <input type="text" class="form-control" id="winningNumber" maxlength="2" placeholder="ဥပမာ - 34" required>
                    </div>
                    <div class="mb-3">
                        <label for="announceMultiplier" class="form-label fw-bold">အဆပေါင်း (Multiplier)</label>
                        <input type="number" class="form-control" id="announceMultiplier" value="80" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-success btn-sm" onclick="submitTwoDAnnounce()">ကြေငြာမည် & ငွေရှင်းမည်</button>
            </div>
        </div>
    </div>
</div>