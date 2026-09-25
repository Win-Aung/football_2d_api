<div class="modal fade" id="paymentSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">ငွေပေးချေမှု အချက်အလက်များ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentSettingsForm">
                    <div class="mb-3 text-center">
                        <img id="previewQr" src="" alt="QR Code" class="img-fluid mb-2" style="max-height: 200px; display: none;">
                        <input type="text" class="form-control" id="qrUrlInput" name="qrUrl" placeholder="QR Image URL ထည့်ရန်">
                    </div>
                    <div class="mb-3">
                        <label for="phoneInput" class="form-label">လက်ခံမည့် ဖုန်းနံပါတ်</label>
                        <input type="text" class="form-control" id="phoneInput" name="phone" placeholder="ဥပမာ - 09xxxxxxxxx">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="savePaymentSettings()">သိမ်းမည်</button>
            </div>
        </div>
    </div>
</div>