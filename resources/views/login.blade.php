<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AquaVault - Premium Access</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --ocean-primary: #0f172a;
            --ocean-secondary: #1e293b;
            --ocean-accent: #0ea5e9;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --shadow-premium: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            overflow: hidden;
            background: radial-gradient(ellipse at bottom, #1e293b 0%, #0f172a 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dynamic Ocean Background */
        .ocean-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .depth-layer {
            position: absolute;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
            opacity: 0.1;
        }

        .depth-layer:nth-child(1) {
            background: radial-gradient(circle, #0ea5e9 0%, transparent 70%);
            top: 10%;
            left: -10%;
            animation-delay: 0s;
            animation-duration: 25s;
        }

        .depth-layer:nth-child(2) {
            background: radial-gradient(circle, #06b6d4 0%, transparent 70%);
            bottom: 10%;
            right: -10%;
            animation-delay: -8s;
            animation-duration: 30s;
        }

        .depth-layer:nth-child(3) {
            background: radial-gradient(circle, #8b5cf6 0%, transparent 70%);
            top: 50%;
            left: 30%;
            animation-delay: -15s;
            animation-duration: 35s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg) scale(1);
            }

            25% {
                transform: translate(-20px, -30px) rotate(1deg) scale(1.05);
            }

            50% {
                transform: translate(30px, 20px) rotate(-1deg) scale(0.95);
            }

            75% {
                transform: translate(-10px, 40px) rotate(0.5deg) scale(1.02);
            }
        }

        /* Particle System */
        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #0ea5e9;
            border-radius: 50%;
            opacity: 0;
            animation: particle-float 15s linear infinite;
        }

        @keyframes particle-float {
            0% {
                opacity: 0;
                transform: translateY(100vh) translateX(0) scale(0);
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(-100px) translateX(100px) scale(1);
            }
        }

        /* Premium Login Container */
        .login-container {
            width: 440px;
            padding: 64px 48px;
            background: var(--glass-bg);
            backdrop-filter: blur(40px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            box-shadow: var(--shadow-premium), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            z-index: 100;
            position: relative;
            transform: translateY(0);
            animation: containerEntrance 1.2s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        @keyframes containerEntrance {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
                filter: blur(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 32px;
            padding: 1px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.02));
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: xor;
            -webkit-mask-composite: xor;
            pointer-events: none;
        }

        /* Header Section */
        .login-header {
            text-align: center;
            margin-bottom: 48px;
            animation: headerSlide 1.2s cubic-bezier(0.4, 0, 0.2, 1) both 0.2s;
        }

        @keyframes headerSlide {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            color: white;
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.3);
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-3px) rotate(2deg);
            }
        }

        .login-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            font-size: 18px;
            color: var(--text-secondary);
            font-weight: 400;
            line-height: 1.4;
        }

        /* Form Styling */
        .login-form {
            animation: formSlide 1.2s cubic-bezier(0.4, 0, 0.2, 1) both 0.4s;
        }

        @keyframes formSlide {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 28px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 12px;
            transition: color 0.3s ease;
        }

        .input-container {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.1), transparent);
            transition: left 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        .input-container.focused::before {
            left: 100%;
        }

        .form-input {
            width: 100%;
            height: 64px;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 0 24px;
            font-size: 17px;
            color: var(--text-primary);
            outline: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1), 0 8px 32px rgba(14, 165, 233, 0.15);
            background: rgba(255, 255, 255, 0.06);
            transform: translateY(-1px);
        }

        .form-input:focus::placeholder {
            color: rgba(255, 255, 255, 0.6);
            transform: translateX(4px);
        }

        /* Premium Button */
        .login-button {
            width: 100%;
            height: 64px;
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            border: none;
            border-radius: 16px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px rgba(14, 165, 233, 0.3);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(14, 165, 233, 0.4);
            background: linear-gradient(135deg, #0284c7, #0891b2);
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:active {
            transform: translateY(-1px);
            transition-duration: 0.1s;
        }

        .button-content {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .loading-spinner {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 12px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Additional Options */
        .additional-options {
            text-align: center;
            animation: optionsSlide 1.2s cubic-bezier(0.4, 0, 0.2, 1) both 0.6s;
        }

        @keyframes optionsSlide {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .forgot-password {
            display: inline-block;
            color: #0ea5e9;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 12px 24px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .sign_up {
            display: inline-block;
            color: #0ea5e9;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 12px 24px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .forgot-password::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 12px;
            transform: scale(0);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }

        .forgot-password:hover::before {
            transform: scale(1);
        }

        .forgot-password:hover {
            color: #0284c7;
            transform: translateY(-1px);
        }

        /* Success Animation */
        .success-check {
            display: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #10b981;
            margin-right: 12px;
            position: relative;
            animation: successPop 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .success-check::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        @keyframes successPop {
            0% {
                transform: scale(0) rotate(-180deg);
            }

            100% {
                transform: scale(1) rotate(0deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 520px) {
            .login-container {
                width: 90%;
                margin: 0 20px;
                padding: 48px 32px;
            }

            .login-title {
                font-size: 28px;
            }

            .brand-logo {
                width: 56px;
                height: 56px;
                font-size: 24px;
            }
        }

        @media (max-height: 700px) {
            .login-container {
                padding: 40px 48px;
            }

            .login-header {
                margin-bottom: 32px;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Focus indicators for accessibility */
        .login-button:focus,
        .forgot-password:focus {
            outline: 2px solid #0ea5e9;
            outline-offset: 2px;
        }

        #registerForm {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #registerForm.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }


        .fade-slide {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        .fade-slide.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .switch-link {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="ocean-container">
        <div class="depth-layer"></div>
        <div class="depth-layer"></div>
        <div class="depth-layer"></div>
    </div>

    <!-- Khối Login/Register -->
    <div class="login-container">
        <div class="login-header">
            <div class="brand-logo">CM</div>
            <h1 class="login-title">CÔNG MINH AUDIO</h1>
            <p class="login-subtitle">Đăng nhập hoặc tạo tài khoản</p>
        </div>

        <!-- FORM ĐĂNG NHẬP -->
        <form class="login-form fade-slide active" id="loginForm">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-container">
                    <input type="email" id="email" class="form-input" placeholder="Nhập email của bạn" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Mật khẩu</label>
                <div class="input-container">
                    <input type="password" id="password" class="form-input" placeholder="Nhập mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="login-button">
                <div class="button-content">
                    <div class="loading-spinner"></div>
                    <div class="success-check"></div>
                    <span class="button-text">Đăng nhập</span>
                </div>
            </button>

            <div class="additional-options">
                <a class="sign_up switch-link">Chưa có tài khoản? Đăng ký</a>
            </div>

            <div class="additional-options">
                <a href="#" class="forgot-password">Quên mật khẩu?</a>
            </div>
        </form>

        <!-- FORM ĐĂNG KÝ -->
        <form class="login-form fade-slide" id="registerForm">
            <div class="form-group">
                <label class="form-label" for="reg_name">Tên</label>
                <div class="input-container">
                    <input id="reg_name" class="form-input" placeholder="Nhập tên của bạn" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="reg_email">Email</label>
                <div class="input-container">
                    <input type="email" id="reg_email" class="form-input" placeholder="Nhập email của bạn" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="reg_password">Mật khẩu</label>
                <div class="input-container">
                    <input type="password" id="reg_password" class="form-input" placeholder="Nhập mật khẩu" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="reg_confirm">Xác nhận mật khẩu</label>
                <div class="input-container">
                    <input type="password" id="reg_confirm" class="form-input" placeholder="Nhập lại mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="login-button">
                <div class="button-content">
                    <div class="loading-spinner"></div>
                    <div class="success-check"></div>
                    <span class="button-text">Đăng ký</span>
                </div>
            </button>

            <div class="additional-options">
                <a class="forgot-password switch-link">Đã có tài khoản? Đăng nhập</a>
            </div>
        </form>
    </div>

    <script>
        // --- Giữ nguyên particle system & hiệu ứng ocean ---
        function createParticle() {
            const particle = document.createElement('div');
            particle.className = 'particle';
            const size = Math.random() * 3 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * window.innerWidth + 'px';
            particle.style.animationDelay = Math.random() * 2 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            const colors = ['#0ea5e9', '#06b6d4', '#8b5cf6'];
            particle.style.background = colors[Math.floor(Math.random() * colors.length)];
            document.querySelector('.ocean-container').appendChild(particle);
            setTimeout(() => particle.remove(), 15000);
        }
        setInterval(createParticle, 1500);
        window.addEventListener('load', () => { for (let i = 0; i < 8; i++) setTimeout(createParticle, i * 200); });

        // --- Chuyển form đăng nhập <-> đăng ký ---
        // Khai báo form
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');

// Mặc định chỉ hiện form đăng nhập
registerForm.style.display = "none";

// Bắt sự kiện chuyển form
document.querySelectorAll('.switch-link').forEach(link => {
    link.addEventListener('click', () => {
        if (loginForm.classList.contains('active')) {
            // Ẩn login, hiện register
            loginForm.classList.remove('active');
            setTimeout(() => {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                setTimeout(() => registerForm.classList.add('active'), 50);
            }, 300);
        } else {
            // Ẩn register, hiện login
            registerForm.classList.remove('active');
            setTimeout(() => {
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
                setTimeout(() => loginForm.classList.add('active'), 50);
            }, 300);
        }
    });
});

        // --- AJAX ĐĂNG NHẬP ---
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const button = this.querySelector('.login-button');
            const buttonText = button.querySelector('.button-text');
            const spinner = button.querySelector('.loading-spinner');
            const successCheck = button.querySelector('.success-check');

            buttonText.textContent = 'Đang đăng nhập...';
            spinner.style.display = 'block';
            button.disabled = true;
            button.style.background = 'linear-gradient(135deg, #64748b, #475569)';

            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email, password })
            })
                .then(res => res.json())
                .then(data => {
                    spinner.style.display = 'none';
                    if (data.success) {
                        successCheck.style.display = 'block';
                        buttonText.textContent = 'Thành công!';
                        button.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                        showNotification('✅ ' + data.message);
                        setTimeout(() => window.location.href = '/dashboard', 1500);
                    } else {
                        buttonText.textContent = 'Đăng nhập';
                        button.style.background = 'linear-gradient(135deg, #dc2626, #b91c1c)';
                        showNotification('❌ ' + data.message);
                        setTimeout(() => {
                            button.style.background = 'linear-gradient(135deg, #0ea5e9, #06b6d4)';
                            button.disabled = false;
                        }, 1500);
                    }
                })
                .catch(() => {
                    spinner.style.display = 'none';
                    showNotification('⚠️ Lỗi kết nối máy chủ!');
                    buttonText.textContent = 'Thử lại';
                    button.style.background = 'linear-gradient(135deg, #dc2626, #b91c1c)';
                    setTimeout(() => {
                        buttonText.textContent = 'Đăng nhập';
                        button.style.background = 'linear-gradient(135deg, #0ea5e9, #06b6d4)';
                        button.disabled = false;
                    }, 2000);
                });
        });

        // --- AJAX ĐĂNG KÝ ---
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('reg_email').value.trim();
            const password = document.getElementById('reg_password').value.trim();
            const confirm = document.getElementById('reg_confirm').value.trim();
            const name = document.getElementById('reg_name').value.trim();

            const button = this.querySelector('.login-button');
            const buttonText = button.querySelector('.button-text');
            const spinner = button.querySelector('.loading-spinner');
            const successCheck = button.querySelector('.success-check');

            if (password !== confirm) {
                showNotification('⚠️ Mật khẩu không khớp!');
                return;
            }

            buttonText.textContent = 'Đang đăng ký...';
            spinner.style.display = 'block';
            button.disabled = true;
            button.style.background = 'linear-gradient(135deg, #64748b, #475569)';

            fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email, password, name })
            })
                .then(res => res.json())
                .then(data => {
                    spinner.style.display = 'none';
                    if (data.success) {
                        successCheck.style.display = 'block';
                        buttonText.textContent = 'Đăng ký thành công!';
                        button.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                        showNotification('✅ ' + data.message);
                        setTimeout(() => {
                            location.href = "/dashboard"
                        }, 1500);
                    } else {
                        buttonText.textContent = 'Đăng ký';
                        button.style.background = 'linear-gradient(135deg, #dc2626, #b91c1c)';
                        showNotification('❌ ' + data.message);
                        setTimeout(() => {
                            button.style.background = 'linear-gradient(135deg, #0ea5e9, #06b6d4)';
                            button.disabled = false;
                        }, 1500);
                    }
                })
                .catch(() => {
                    spinner.style.display = 'none';
                    showNotification('⚠️ Lỗi kết nối máy chủ!');
                    buttonText.textContent = 'Thử lại';
                    button.style.background = 'linear-gradient(135deg, #dc2626, #b91c1c)';
                    setTimeout(() => {
                        buttonText.textContent = 'Đăng ký';
                        button.style.background = 'linear-gradient(135deg, #0ea5e9, #06b6d4)';
                        button.disabled = false;
                    }, 2000);
                });
        });

        // --- Thông báo mượt ---
        function showNotification(message) {
            const n = document.createElement('div');
            n.style.cssText = `
                position: fixed; top: 30px; right: 30px;
                background: rgba(16, 185, 129, 0.9);
                backdrop-filter: blur(20px);
                color: white; padding: 16px 24px;
                border-radius: 12px; font-weight: 500;
                box-shadow: 0 10px 40px rgba(0,0,0,0.3);
                transform: translateX(400px);
                transition: transform .5s cubic-bezier(0.4,0,0.2,1);
                z-index: 1000;
            `;
            n.textContent = message;
            document.body.appendChild(n);
            setTimeout(() => n.style.transform = 'translateX(0)', 100);
            setTimeout(() => { n.style.transform = 'translateX(400px)'; setTimeout(() => n.remove(), 500); }, 3000);
        }
    </script>




</body>