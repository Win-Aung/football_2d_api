<div id="football-tab" class="tab-content-section">
    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
        <button class="btn btn-success btn-sm px-3" onclick="openAnnounceMatchModal()"><i class="fa-solid fa-bullhorn me-1"></i> ဘောပွဲကြေငြာရန်</button>
        <button class="btn btn-success btn-sm px-3" onclick="openAddLeagueModal()">
            <i class="fa-solid fa-bullhorn me-1"></i> +League နှင့် အသင်းများ ထည့်ရန်
        </button>
    </div>

    <ul class="nav nav-tabs" id="footballTabNav" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="matches-subtab" data-bs-toggle="tab" data-bs-target="#matches-content" type="button">⚽ ကြေငြာထားသော ပွဲစဉ်များ</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="bets-subtab" data-bs-toggle="tab" data-bs-target="#bets-content" type="button">💰 ထိုးထားသော Bet များ</button>
        </li>
    </ul>

    <div class="tab-content p-3 bg-white border border-top-0 rounded-bottom shadow-sm">
        <div class="tab-pane fade show active" id="matches-content">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="announced-matches-table">
                    <div class="mb-3">
                        <input type="text" id="matchSearchInput" class="form-control w-25" placeholder="အသင်းအမည်ဖြင့် ရှာရန်..." onkeyup="filterMatches()">
                    </div>
                    <thead class="table-light text-secondary">
                        <tr>
                            <th style="background-color: #e3f2fd; color: #0d6efd;">ID</th>
                            <th style="background-color: #e3f2fd; color: #fd0d0d;">ပိတ်ချိန်</th>
                            <th style="background-color: #e3f2fd; color: #09fd09;">အိမ်ရှင် vs ဧည့်သည်</th>
                            <th style="background-color: #e3f2fd; color: #fd0d55;">မောင်းဂိုးပေါင်း</th>
                            <th style="background-color: #e3f2fd; color: #250dfd;">Bအိမ်ရှင် vs Bဧည့်သည်</th>
                            <th style="background-color: #e3f2fd; color: #fd0d0d;">ဘော်ဒီဂိုးပေါင်း</th>
                            <th style="background-color: #e3f2fd; color: #e10dfd;">ဘောဒီ Status</th>
                            <th style="background-color: #e3f2fd; color: #e10dfd;">မောင်း Status</th>
                            <th style="background-color: #e3f2fd; color: #fd0d0d;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Data -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="bets-content">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="betSearchQuery" class="form-control" placeholder="Bet ID (သို့) အသင်းနာမည်ဖြင့် ရှာရန်...">
                </div>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedFootballBets()">
                    <i class="fa-solid fa-trash me-1"></i> ရွေးချယ်ထားသမျှ ဖျက်မည်
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="text-center">
                                <input type="checkbox" class="form-check-input" id="selectAllFootballBetsCheckbox" onclick="toggleSelectAllFootballBets(this)">
                            </th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Bet Type</th>
                            <th>ရွေးချယ်မှု (Selected Options)</th>
                            <th>စုစုပေါင်းပမာဏ</th>
                            <th>Status</th>
                            <th>အချိန်</th>
                            <th>အရေးယူဆောင်ရွက်ရန်</th>
                        </tr>
                    </thead>
                    <tbody id="footballBetsTableBody">
                        <!-- JavaScript ဖြင့် Data များကို ဤနေရာတွင် ထည့်သွင်းမည် -->
                    </tbody>
                </table>
            </div>                                       
        </div>
    </div>
</div>

<!-- Football Modals -->
@include('admin.partials.modals.football-modals')