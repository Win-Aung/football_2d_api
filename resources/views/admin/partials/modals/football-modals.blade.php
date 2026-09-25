<!-- ဘောပွဲကြေငြာရန် Modal -->
<div class="modal fade" id="announceMatchModal" tabindex="-1" aria-labelledby="announceMatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announceMatchModalLabel">ဘောပွဲ ကြေငြာရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="announceMatchForm">
                    <div class="mb-3">
                        <label for="announceLeague" class="form-label">League</label>
                        <select class="form-select" id="announceLeague" required>
                            <option value="">League ရွေးချယ်ပါ</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="announceHomeTeam" class="form-label">အိမ်ရှင်အသင်း</label>
                            <select class="form-select" id="announceHomeTeam" required>
                                <option value="">အိမ်ရှင်အသင်း ရွေးပါ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="announceAwayTeam" class="form-label">ဧည့်သည်အသင်း</label>
                            <select class="form-select" id="announceAwayTeam" required>
                                <option value="">ဧည့်သည်အသင်း ရွေးပါ</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="announceHomeOdds" class="form-label">အိမ်ရှင်ကြေး</label>
                            <input type="text" class="form-control" id="announceHomeOdds">
                        </div>
                        <div class="col-md-6">
                            <label for="announceAwayOdds" class="form-label">ဧည့်သည်ကြေး</label>
                            <input type="text" class="form-control" id="announceAwayOdds">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="announceGoalTotal" class="form-label">ဂိုးပေါင်းကြေး (မထည့်လဲရ)</label>
                            <input type="text" class="form-control" id="announceGoalTotal">
                        </div>
                        <div class="col-md-6">
                            <label for="announceVideoLink" class="form-label">Live Video Play Link များ (မထည့်လဲရ၊ တစ်ကြောင်းလျှင် တစ်ခု (သို့) ကော်မာခံရန်)</label>
                            <textarea class="form-control" id="announceVideoLink" rows="2" placeholder="လင့်ခ်များကို အများကြီးထည့်ရန်..."></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="announceBodyOdds" class="form-label">ဘောဒီအိမ်ရှင်ကြေး</label>
                            <input type="text" class="form-control" id="announceBodyOdds">
                        </div>
                        <div class="col-md-6">
                            <label for="announceBodyAwayOdds" class="form-label">ဘောဒီဧည့်သည်ကြေး</label>
                            <input type="text" class="form-control" id="announceBodyAwayOdds">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="announceBodyGoalTotal" class="form-label">ဘောဒီဂိုးပေါင်းကြေး (မထည့်လဲရ)</label>
                        <input type="text" class="form-control" id="announceBodyGoalTotal">
                    </div>

                    <div class="mb-3">
                        <label for="announceCloseTime" class="form-label">ပိတ်မည့်အချိန် (Close Time/Date)</label>
                        <input type="datetime-local" class="form-control" id="announceCloseTime" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitAnnounceMatchBtn" onclick="submitAnnounceMatch()">ကြေငြာမည်</button>
            </div>
        </div>
    </div>
</div>

<!-- Add League Modal -->
<div class="modal fade" id="addLeagueModal" tabindex="-1" aria-labelledby="addLeagueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeagueModalLabel">League နှင့် အသင်းများ ထည့်သွင်းရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLeagueForm">
                    <div class="mb-3">
                        <label for="league_name" class="form-label">League အမည် (League Name)</label>
                        <select class="form-control" id="league_name" name="league_name" required onchange="checkNewLeague(this)">                                
                            <option value="">-- League တစ်ခု ရွေးပါ (သို့) အသစ်ထည့်ရန် --</option>
                            <option value="NEW_LEAGUE">➕ League အသစ်ထည့်မည်</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="newLeagueContainer">
                        <label for="new_league_name" class="form-label">League အမည်အသစ် ရိုက်ထည့်ရန်</label>
                        <input type="text" class="form-control" id="new_league_name" placeholder="ဥပမာ - Premier League">
                    </div>

                    <div class="mb-3">
                        <label for="teams" class="form-label">ဘောလုံးအသင်းများ (Teams - ကော်မာ , ဖြင့်ခံရန်)</label>
                        <textarea class="form-control" id="teams" name="teams" rows="3" required placeholder="Manchester United, Arsenal, Chelsea"></textarea>
                    </div>
                
                    <div class="alert alert-danger d-none" id="leagueErrorMsg"></div>
                    <div class="alert alert-success d-none" id="leagueSuccessMsg"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="submitLeagueData()">သိမ်းဆည်းမည်</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Match Modal -->
<div class="modal fade" id="editMatchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ဘောပွဲ အချက်အလက် ပြင်ဆင်ရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMatchForm">
                    <input type="hidden" id="editMatchId">
                    
                    <div class="mb-3">
                        <label class="form-label">League</label>
                        <input type="text" class="form-control" id="editLeagueName" readonly>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">အိမ်ရှင်အသင်း</label>
                            <input type="text" class="form-control" id="editHomeTeam" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ဧည့်သည်အသင်း</label>
                            <input type="text" class="form-control" id="editAwayTeam" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">အိမ်ရှင်ကြေး</label>
                            <input type="text" class="form-control" id="editHomeOdds">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ဧည့်သည်ကြေး</label>
                            <input type="text" class="form-control" id="editAwayOdds">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ဂိုးပေါင်းကြေး</label>
                            <input type="text" class="form-control" id="editGoalTotal">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Live Video Play Link များ</label>
                            <textarea class="form-control" id="editVideoLink" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ဘောဒီအိမ်ရှင်ကြေး</label>
                            <input type="text" class="form-control" id="editBodyOdds">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ဘောဒီဧည့်သည်ကြေး</label>
                            <input type="text" class="form-control" id="editBodyAwayOdds">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ဘောဒီဂိုးပေါင်းကြေး</label>
                        <input type="text" class="form-control" id="editBodyGoalTotal">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ပိတ်မည့်အချိန် (Close Time)</label>
                        <input type="datetime-local" class="form-control" id="editCloseTime">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-primary" onclick="submitEditMatch()">ပြင်ဆင်မည်</button>
            </div>
        </div>
    </div>
</div>