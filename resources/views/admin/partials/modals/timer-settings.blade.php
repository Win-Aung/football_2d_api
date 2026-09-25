<div class="modal fade" id="timerSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white px-4 py-3" style="background-color: #6f42c1;">
                <h5 class="modal-title fw-bold fs-5 d-flex align-items-center">
                    <i class="fa-solid fa-clock text-warning me-2 fs-4"></i> အချိန် (Timer) သတ်မှတ်ရန်
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <form id="timerSettingsForm">
                    <div class="mb-4 text-center bg-white p-3 rounded-3 shadow-sm border">
                        <label class="form-label fw-bold text-secondary mb-2 d-flex align-items-center justify-content-center gap-1">
                            <i class="fa-solid fa-stopwatch text-purple"></i> Duration (နာရီ၊ မိနစ်၊ စက္ကန့်)
                        </label>
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            <div class="input-group shadow-sm rounded" style="max-width: 280px; border: 1px solid #dcd6f7;">
                                <span class="input-group-text bg-white text-purple border-0 px-2 fs-5">
                                    <i class="fa-regular fa-clock"></i>
                                </span>
                                <input type="number" class="form-control text-center fw-bold fs-5 border-0 p-1" id="durationHours" placeholder="00" min="0" style="color: #6f42c1; background-color: #f8f4ff;" title="နာရီ">
                                <span class="input-group-text bg-transparent border-0 px-0 text-muted">:</span>
                                <input type="number" class="form-control text-center fw-bold fs-5 border-0 p-1" id="durationMinutes" placeholder="05" min="0" max="59" style="color: #6f42c1; background-color: #f8f4ff;" title="မိနစ်">
                                <span class="input-group-text bg-transparent border-0 px-0 text-muted">:</span>
                                <input type="number" class="form-control text-center fw-bold fs-5 border-0 p-1" id="durationSeconds" placeholder="00" min="0" max="59" style="color: #6f42c1; background-color: #f8f4ff;" title="စက္ကန့်">
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block" style="font-size: 12px;">နာရီ၊ မိနစ် နှင့် စက္ကန့်များကို လိုအပ်သလို အတိအကျ ချိန်ညှိပါ။</small>
                    </div>

                    <div class="mb-2 bg-white p-3 rounded-3 shadow-sm border">
                        <label for="endTimeInput" class="form-label fw-bold text-secondary mb-2 d-flex align-items-center gap-1">
                            <i class="fa-solid fa-calendar-days text-purple"></i> End Time (ပြီးဆုံးမည့်အချိန်)
                        </label>
                        <input type="datetime-local" class="form-control shadow-sm border-0 bg-light py-2" id="endTimeInput" name="endTime">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-white px-4 py-3">
                <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold rounded-pill" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-sm px-4 fw-bold text-white rounded-pill shadow-sm" style="background-color: #6f42c1;" onclick="saveTimerSettings()">သိမ်းမည်</button>
            </div>
        </div>
    </div>
</div>