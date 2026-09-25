<div id="image-slider-tab" class="tab-content-section">
    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark fw-bold">Image Slider စီမံခန့်ခွဲမှု</h3>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addImageModal" onclick="resetSliderForm()">
                <i class="fa-solid fa-plus me-1"></i> ပုံအသစ်ထည့်ရန်
            </button>
        </div>

        <!-- Image Slider Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>စဉ်</th>
                                <th>ပုံ</th>
                                <th>ခေါင်းစဉ်</th>
                                <th>ဖော်ပြချက်</th>
                                <th class="text-center">အခြေအနေ (Status)</th>
                                <th>လုပ်ဆောင်ချက်</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sliders = \DB::table('sliders')->orderBy('id', 'desc')->get();
                            @endphp

                            @forelse($sliders as $index =>$slider)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($slider->image)
                                            <img src="{{ url($slider->image) }}" alt="Slider Image" class="rounded" style="width: 100px; height: 50px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">ပုံမရှိပါ</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">{{ $slider->title ?? '-' }}</td>
                                    <td>{{ $slider->description ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="sliderSwitch_{{ $slider->id }}" {{ (isset($slider->status) && $slider->status == 1) ? 'checked' : '' }} onchange="toggleSliderStatus({{ $slider->id }}, this)">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" onclick="editSlider({{ $slider->id }}, '{{ addslashes($slider->title) }}', '{{ addslashes($slider->description) }}')"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteSlider({{ $slider->id }})"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">သိမ်းဆည်းထားသော Slider ပုံများ မရှိသေးပါ။</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🟢 ပုံအသစ်ထည့်ရန် / ပြင်ဆင်ရန် Modal ဘောက်စ် -->
<div class="modal fade" id="addImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="sliderModalTitle">Image Slider ပုံအသစ်ထည့်ရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSliderForm" enctype="multipart/form-data">
                    <input type="hidden" id="sliderId" name="slider_id">
                    <div class="mb-3">
                        <label for="sliderTitle" class="form-label fw-bold">ခေါင်းစဉ် (Title)</label>
                        <input type="text" class="form-control" id="sliderTitle" name="title" placeholder="ခေါင်းစဉ်ထည့်ရန်...">
                    </div>
                    <div class="mb-3">
                        <label for="sliderImage" class="form-label fw-bold">ပုံရွေးချယ်ရန် (Image)</label>
                        <input type="file" class="form-control" id="sliderImage" name="image" accept="image/*">
                        <small class="text-muted">ပုံအသစ်မလဲလိုပါက ပုံရွေးချယ်စရာမလိုပါ။</small>
                    </div>
                    <div class="mb-3">
                        <label for="sliderDescription" class="form-label fw-bold">ဖော်ပြချက် (Description)</label>
                        <textarea class="form-control" id="sliderDescription" name="description" rows="3" placeholder="ဖော်ပြချက်ရေးရန်..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ပိတ်မည်</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="saveSliderData()">သိမ်းဆည်းမည်</button>
            </div>
        </div>
    </div>
</div>

<script>
function resetSliderForm() {
    document.getElementById('sliderModalTitle').innerText = 'Image Slider ပုံအသစ်ထည့်ရန်';
    document.getElementById('sliderId').value = '';
    document.getElementById('addSliderForm').reset();
}

function editSlider(id, title, description) {
    document.getElementById('sliderModalTitle').innerText = 'Image Slider ပုံ ပြင်ဆင်ရန်';
    document.getElementById('sliderId').value = id;
    document.getElementById('sliderTitle').value = title !== 'null' ? title : '';
    document.getElementById('sliderDescription').value = description !== 'null' ? description : '';
    document.getElementById('sliderImage').value = '';

    var myModal = new bootstrap.Modal(document.getElementById('addImageModal'));
    myModal.show();
}

function saveSliderData() {
    let id = document.getElementById('sliderId').value;
    let formElement = document.getElementById('addSliderForm');
    let formData = new FormData(formElement);

    let url = id ? 
        ((window.baseUrl ? window.baseUrl : '') + `/api/admin/slider/update/${id}`) : 
        ((window.baseUrl ? window.baseUrl : '') + '/api/admin/slider/store');

    fetch(url, {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + (window.apiToken || window.Laravel?.token || ''),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success' || data.success) {
            alert(data.message || 'အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။');
            let modalEl = document.getElementById('addImageModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            location.reload();
        } else {
            alert('အမှားအယွင်း ရှိပါသည်။: ' + (data.message || ''));
        }
    })
    .catch(error => {
        console.error('Error saving slider:', error);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    });
}

// 🟢 Switch ဖြင့် Active / Inactive ပြောင်းလဲရန် Function
function toggleSliderStatus(id, element) {
    let newStatus = element.checked ? 1 : 0;
    let url = (window.baseUrl ? window.baseUrl : '') + `/api/admin/slider/update-status/${id}`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + (window.apiToken || window.Laravel?.token || ''),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        if (!(data.status === 'success' || data.success)) {
            alert('အခြေအနေပြောင်းလဲရာတွင် အမှားအယွင်း ရှိပါသည်။');
            element.checked = !element.checked; // အမှားဖြစ်လျှင် မူလအတိုင်း ပြန်ပြောင်းရန်
        }
    })
    .catch(err => {
        console.error('Toggle Error:', err);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
        element.checked = !element.checked;
    });
}

function deleteSlider(id) {
    if (!confirm('ဤ Slider ပုံကို ဖျက်ရန် သေချာပါသလား?')) {
        return;
    }

    let url = (window.baseUrl ? window.baseUrl : '') + `/api/admin/slider/delete/${id}`;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Authorization': 'Bearer ' + (window.apiToken || window.Laravel?.token || ''),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success' || data.success) {
            alert(data.message || 'Slider ကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');
            location.reload();
        } else {
            alert('ဖျက်ဆီးရာတွင် အမှားအယွင်း ရှိပါသည်။: ' + (data.message || ''));
        }
    })
    .catch(error => {
        console.error('Error deleting slider:', error);
        alert('ဆာဗာချိတ်ဆက်မှု အဆင်မပြေပါ။');
    });
}
</script>