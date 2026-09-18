<!-- ================= 2D TAB ================= -->
<div id="section-2d" class="content-section">
    <div class="container-fluid p-0">
        <!-- Header & History Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-purple fw-bold m-0"><i class="fa-solid fa-calculator me-1"></i> 2D ထိုးရန်နှင့် ရလဒ်များ</h5>
            <button onclick="toggleHistory()" class="btn btn-sm btn-purple text-white px-3 fw-bold shadow-sm" style="background-color: #6f42c1;">
                <i class="fas fa-history me-1"></i> မှတ်တမ်း
            </button>
        </div>

        <!-- ================= 2D BET HISTORY MODAL ================= -->
        <div id="twod-history-modal" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-purple text-white" style="background-color: #6f42c1;">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-history text-warning me-2"></i> ထိုးထားသော မှတ်တမ်းများ
                        </h5>
                        <button type="button" onclick="closeTwoDHistoryModal()" class="btn-close btn-close-white" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3" style="max-height: 65vh; overflow-y: auto;">
                        <div id="twod-history-loading" class="text-center py-4">
                            <div class="spinner-border text-purple" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div id="twod-history-list" class="vstack gap-2">
                            <!-- JavaScript ဖြင့် မှတ်တမ်း Card များကို ဤနေရာတွင် ဖော်ပြမည် -->
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" onclick="closeTwoDHistoryModal()" class="btn btn-secondary btn-sm fw-bold px-4">ပိတ်မည်</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Result Card -->
        <div class="card bg-purple text-white p-3 rounded-3 shadow-sm mb-3" style="background: linear-gradient(135deg, #6f42c1, #a855f7);">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold m-0">2D Live Result</h6>
                <button onclick="fetch2DResult()" class="btn btn-sm text-white p-0"><i class="fas fa-sync-alt"></i></button>
            </div>
            <div class="d-flex justify-content-between small text-white-50 mt-1">
                <span id="date-val">ရက်စွဲ: -</span>
                <span id="last-date-val">နောက်ဆုံးရက်: -</span>
            </div>
            <div class="text-center my-2">
                <span class="badge bg-warning text-dark fw-bold px-2 py-1" style="font-size: 10px;">LIVE</span>
                <div id="live-val" class="fs-1 fw-bold tracking-widest mt-1">-</div>
            </div>
        </div>

        <!-- Sessions List -->
        <div class="card p-3 shadow-sm mb-3 border-0 bg-light">
            <h6 class="fw-bold text-purple mb-2" style="font-size: 14px;">အချိန်အလိုက် 2D ထွက် </h6>
            <div id="session-list" class="vstack gap-2">
                <!-- Dynamic Sessions -->
            </div>

            <div class="mt-3 text-center">
                <button type="button" class="btn btn-sm btn-outline-purple w-100 fw-bold py-2 shadow-sm" style="border-color: #6f42c1; color: #6f42c1; background-color: #f8f4ff;" onclick="openOldHistoryModal()">
                    <i class="fas fa-history me-1"></i> မှတ်တမ်းဟောင်းများ
                </button>
            </div>

            <div class="mt-2 mb-4">
                <button type="button" class="btn btn-outline-purple w-100 py-2 fw-bold text-purple border-purple" onclick="openHolidayModal()" style="border-color: #6f42c1; color: #6f42c1;">
                    <i class="fas fa-calendar-alt me-1"></i> ပိတ်ရက်များ
                </button>
            </div>
        </div>

        <!-- ================= 🛑 မှတ်တမ်းဟောင်းများ Modal Box ================= -->
        <div id="oldHistoryModal" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-purple text-white" style="background-color: #6f42c1;">
                        <h5 class="modal-title fw-bold fs-6">
                            <i class="fas fa-calendar-alt text-warning me-2"></i> 📜 2D မှတ်တမ်းဟောင်းများ
                        </h5>
                        <button type="button" onclick="closeOldHistoryModal()" class="btn-close btn-close-white" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3" style="max-height: 65vh; overflow-y: auto;">
                        <div id="old-history-loading" class="text-center py-4">
                            <div class="spinner-border text-purple" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div id="old-history-list" class="vstack gap-2">
                            <!-- JavaScript ဖြင့် မှတ်တမ်းဟောင်းများကို ဤနေရာတွင် ဖော်ပြမည် -->
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" onclick="closeOldHistoryModal()" class="btn btn-secondary btn-sm fw-bold px-4">ပိတ်မည်</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ပိတ်ရက်များ ပြမည့် Modal Box -->
        <div class="modal fade" id="holidayModal" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-purple text-white" style="background-color: #6f42c1;">
                        <h5 class="modal-title fw-bold fs-6">
                            <i class="fas fa-calendar-times me-2"></i> 🛑 2D ပိတ်ရက်များ စာရင်း
                        </h5>
                        <button type="button" class="btn-close btn-close-white" onclick="closeHolidayModal()"></button>
                    </div>
                    <div class="modal-body p-3">
                        <!-- Loading -->
                        <div id="holiday-loading" class="text-center py-4">
                            <div class="spinner-border text-purple" role="status" style="color: #6f42c1;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted small mt-2">ပိတ်ရက်စာရင်းများကို ရယူနေပါသည်...</p>
                        </div>
                        <!-- Holiday List Container -->
                        <div id="holiday-list" style="max-height: 350px; overflow-y: auto;">
                            <!-- JS ဖြင့် Data ထည့်မည် -->
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 px-3 py-2">
                        <button type="button" class="btn btn-secondary btn-sm px-3 fw-bold" onclick="closeHolidayModal()">ပိတ်မည်</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 00-99 Card Grid Section -->
        <div id="card-selection-view" class="d-none card p-3 shadow-sm border-0 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button onclick="backToMain()" class="btn btn-sm btn-outline-secondary fw-bold"><i class="fas fa-arrow-left"></i>Back</button>
                <span id="selected-session-title" class="fw-bold text-purple"></span>
                <button type="button" onclick="showQuickSelectModal()" class="btn btn-sm btn-warning text-white fw-bold" style="font-size: 11px;">
                    အမြန်ရွေးမည်
                </button>
            </div>
            
            <!-- Grid 00-99 -->
            <div class="row g-1 overflow-y-auto p-1" id="number-grid" style="max-height: 450px;">
                <!-- JavaScript ဖြင့် 00 မှ 99 ထိ generate လုပ်မည် -->
            </div>

            <div class="mt-3">
                <button onclick="submitTwoDBets()" class="btn bg-purple text-white w-100 py-2 fw-bold" style="background-color: #6f42c1;">
                    2D ထိုးမည် (စုစုပေါင်း - <span id="total-amount-label">0</span> ကျပ်)
                </button>
            </div>
        </div>

        <div id="quick-select-modal" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-purple text-white" style="background-color: #6f42c1;">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-bolt text-warning me-2"></i> အမြန်ရွေးမည် (Quick Select)
                        </h5>
                        <button type="button" onclick="closeQuickSelectModal()" class="btn-close btn-close-white" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3" style="max-height: 60vh; overflow-y: auto;">
                        <div id="quick-buttons-container" class="d-flex flex-wrap gap-2">
                            <!-- Dynamic Quick Buttons -->
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" onclick="closeQuickSelectModal()" class="btn btn-secondary btn-sm fw-bold px-4">ပိတ်မည်</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
