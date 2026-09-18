<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Game - Login & Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body { 
        background-color: #f3e8ff; 
        font-family: sans-serif; 
        height: 100vh; 
        margin: 0; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
    }
    .main-container { 
        width: 100%;
        max-width: 450px; 
        background: white; 
        padding: 25px; 
        border-radius: 12px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
    }
    .btn-purple { background-color: #6f42c1; color: white; }
    .btn-purple:hover { background-color: #59339d; color: white; }
    .text-purple { color: #6f42c1; }
</style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="main-container">
        
        <!-- ================= 1. LOGIN SCREEN ================= -->
        <div id="login-section">
            <div class="text-center mb-4">
                <i class="fa-solid fa-games fa-3x text-purple" style="font-size: 50px;"></i>
                <h3 class="mt-3 text-purple fw-bold">ဂိမ်းသို့ ဝင်ရန် Login လုပ်ပါ</h3>
            </div>
            
            <div id="login-alert"></div>

            <form id="login-form">
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-person"></i></span>
                        <input type="text" id="login-phone" class="form-control" placeholder="Phone Number" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" id="login-pass" class="form-control" placeholder="Password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-purple w-100 py-2 mb-3" style="font-size: 16px;">Login</button>
                
                <div class="text-center">
                    <button type="button" class="btn btn-link text-decoration-none" onclick="toggleScreen('register')">
                        Account မရှိသေးဘူးလား? Register လုပ်ရန်
                    </button>
                </div>
            </form>
        </div>

        <!-- ================= 3. REGISTER SCREEN ================= -->
        <div id="register-section" style="display: none;">
            <div class="text-center mb-4">
                <h3 class="mt-3 text-purple fw-bold">User Register</h3>
            </div>

            <div id="register-alert"></div>

            <form id="register-form">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" id="reg-name" class="form-control" placeholder="Name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" id="reg-phone" class="form-control" placeholder="Phone Number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" id="reg-pass" class="form-control" placeholder="Password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Payment Method:</label>
                    <select id="reg-payment" class="form-select">
                        <option value="KBZPay">KBZPay</option>
                        <option value="AYA Pay">AYA Pay</option>
                        <option value="Wave Money">Wave Money</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-purple w-100 py-2 mb-3" id="reg-btn" style="font-size: 16px;">Register Now</button>
                
                <div class="text-center">
                    <button type="button" class="btn btn-link text-decoration-none" onclick="toggleScreen('login')">
                        Already have an account? Login
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    const baseUrl = "{{ url('/api') }}";

    function toggleScreen(screen) {
        document.getElementById('login-alert').innerHTML = '';
        document.getElementById('register-alert').innerHTML = '';
        
        if(screen === 'register') {
            document.getElementById('login-section').style.display = 'none';
            document.getElementById('register-section').style.display = 'block';
        } else {
            document.getElementById('register-section').style.display = 'none';
            document.getElementById('login-section').style.display = 'block';
        }
    }

    // Login Handler Logic
    document.getElementById('login-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        let phone = document.getElementById('login-phone').value.trim();
        let pass = document.getElementById('login-pass').value.trim();
        let alertBox = document.getElementById('login-alert');

        if(phone === '' || pass === '') {
            alertBox.innerHTML = `<div class="alert alert-danger">ကျေးဇူးပြု၍ ဖုန်းနံပါတ်နှင့် Password ဖြည့်ပါ</div>`;
            return;
        }

        try {
            let response = await fetch(`${baseUrl}/login`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ username: phone, password: pass })
            });
            let res = await response.json();

            if (response.ok && res.status === 'success') {
                if (res.token) {
                    localStorage.setItem('auth_token', res.token);
                    localStorage.setItem('token', res.token);
                }
                let userName = (res.user && res.user.name) ? res.user.name : 'User';
                alert('Welcome back, ' + userName + '!');
                window.location.href = "{{ url('/game-home') }}";
            } else {
                alertBox.innerHTML = `<div class="alert alert-danger">${res.message || 'Password သို့မဟုတ် Account မှားယွင်းနေပါသည်'}</div>`;
            }
        } catch (err) {
            alertBox.innerHTML = `<div class="alert alert-danger">Error: ${err}</div>`;
        }
    });


    // Register Handler Logic
    document.getElementById('register-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        let name = document.getElementById('reg-name').value.trim();
        let phone = document.getElementById('reg-phone').value.trim();
        let password = document.getElementById('reg-pass').value.trim();
        let payment = document.getElementById('reg-payment').value;
        let alertBox = document.getElementById('register-alert');

        if(name === '' || phone === '' || password === '') {
            alertBox.innerHTML = `<div class="alert alert-danger">အချက်အလက်အားလုံး ဖြည့်စွက်ပေးပါ</div>`;
            return;
        }

        let regBtn = document.getElementById('reg-btn');
        regBtn.disabled = true;
        regBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`;

        try {
            let response = await fetch(`${baseUrl}/register`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json'
                },
                // 🟢 password ကို 'pass' key ဖြင့် ပို့ဆောင်စေရန် ပြင်ဆင်ထားသည်
                body: JSON.stringify({ name, phone, pass: password, payment })
            });
            let res = await response.json();
            
            regBtn.disabled = false;
            regBtn.innerText = 'Register Now';

            if (response.ok && res.status === 'success') {
                alert('Registration Successful! Please Login.');
                toggleScreen('login');
            } else {
                alertBox.innerHTML = `<div class="alert alert-danger">${res.message || 'Register လုပ်ခြင်း မအောင်မြင်ပါ'}</div>`;
            }
        } catch (err) {
            regBtn.disabled = false;
            regBtn.innerText = 'Register Now';
            alertBox.innerHTML = `<div class="alert alert-danger">Error: ${err}</div>`;
        }
    });
</script>

</body>
</html>