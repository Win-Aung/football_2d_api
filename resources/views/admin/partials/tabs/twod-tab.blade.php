<div id="twodbets-tab" class="tab-content-section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-bold fs-6 mb-3">🎰 2D User Bets စာရင်းများ</h5>
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                <div class="input-group input-group-sm w-auto">
                    <select id="selectSessionName" class="form-select form-select-sm">
                        <option value="11:00 AM">11:00 AM Session</option>
                        <option value="12:00 PM">12:00 PM Session</option>
                        <option value="3:00 PM">3:00 PM Session</option>
                        <option value="4:30 PM">4:30 PM Session</option>
                    </select>
                    <button type="button" class="btn btn-outline-primary px-3" onclick="load2DSessionSettings()">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i> စကက်ကျူး သတ်မှတ်ရန်
                    </button>
                    <button type="button" class="btn btn-success px-3" onclick="openTwoDAnnounceModal()">
                        <i class="fa-solid fa-bullhorn me-1"></i> 2D ဂဏန်းကြေငြာရန်
                    </button>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="session_1100" onchange="updateSessionOpenStatus('11:00 AM', this.checked ? 1 : 0)">
                    <label class="form-check-label" for="session_1100">11:00 AM ဖွင့်/ပိတ်</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="session_1200" onchange="updateSessionOpenStatus('12:00 PM', this.checked ? 1 : 0)">
                    <label class="form-check-label" for="session_1200">12:00 PM ဖွင့်/ပိတ်</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="session_0300" onchange="updateSessionOpenStatus('3:00 PM', this.checked ? 1 : 0)">
                    <label class="form-check-label" for="session_0300">3:00 PM ဖွင့်/ပိတ်</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="session_0430" onchange="updateSessionOpenStatus('4:30 PM', this.checked ? 1 : 0)">
                    <label class="form-check-label" for="session_0430">4:30 PM ဖွင့်/ပိတ်</label>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 250px;">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                        <input type="text" id="twodBetSearchInput" class="form-control form-control-sm border-start-0 bg-light" placeholder="ဂဏန်း သို့မဟုတ် အမည်ဖြင့် ရှာရန်...">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedTwoDBets()">
                        <i class="fa-solid fa-trash me-1"></i> ရွေးချယ်ထားသမျှ ဖျက်မည်
                    </button>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered align-middle" id="2d-bets-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="text-center">
                                <input type="checkbox" class="form-check-input" id="select-all-twod" onclick="toggleSelectAllTwoDBets(this)">
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Amount</th>
                            <th>Session</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="twod-bets-table-body">
                        <!-- Data will be loaded via admin-script.js -->
                    </tbody>
                </table>
            </div>
            <div id="twodBetPaginationContainer" class="d-flex justify-content-between align-items-center mt-3 pt-2"></div>
        </div>
    </div>
</div>

<!-- 2D Modals -->
@include('admin.partials.modals.twod-modals')