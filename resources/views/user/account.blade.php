<div class="bento-edit-container">
    <div class="d-flex justify-content-between align-items-end mb-4 px-2">
        <div>
            <h1 class="be-title">Cài đặt tài khoản</h1>
            <p class="text-white-50 small mb-0">Quản lý thông tin cá nhân và bảo mật của bạn</p>
        </div>
        <button class="be-btn-close" onclick="spaBack()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="be-grid">
        
        <div class="be-card be-profile-main">
            <div class="be-avatar-wrapper">
                <img src="https://i.pravatar.cc/300?img=11" id="be-preview-img" alt="Avatar">
                <label for="be-file-upload" class="be-upload-badge">
                    <i class="fa-solid fa-camera"></i>
                </label>
                <input type="file" id="be-file-upload" hidden accept="image/*">
            </div>
            <h3 class="mt-3 mb-1 font-weight-bold">{{ $user->name }}</h3>
            <span class="be-badge">ID: {{ $user->email }}</span>
        </div>

        <div class="be-card be-info">
            <h5 class="be-card-title">Thông tin cá nhân</h5>
            <div class="be-input-group">
                <label>HỌ VÀ TÊN</label>
                <input type="text" value="{{ $user->name }}">
            </div>
            <div class="be-input-group">
                <label>NGÀY SINH</label>
                <input type="text" value="10/12/1999">
            </div>
        </div>

        <div class="be-card be-contact">
            <h5 class="be-card-title">Liên hệ</h5>
            <div class="be-input-group">
                <label>SỐ ĐIỆN THOẠI</label>
                <input type="text" placeholder="Thêm số điện thoại...">
            </div>
            <div class="be-input-group">
                <label>EMAIL DỰ PHÒNG</label>
                <input type="email" value="minh.dev@icloud.com">
            </div>
        </div>

        <div class="be-card be-security">
            <div class="d-flex align-items-center mb-3">
                <div class="be-icon-box bg-primary"><i class="fa-solid fa-shield-halved"></i></div>
                <h5 class="be-card-title m-0 ml-2">Bảo mật</h5>
            </div>
            <p class="small text-muted">Xác thực 2 yếu tố đang bật để bảo vệ tài khoản của bạn.</p>
            <button class="btn-apple w-100 py-2">Thay đổi mật khẩu</button>
        </div>

        <div class="be-card be-device-info">
            <h5 class="be-card-title">Thiết bị tin cậy</h5>
            <div class="d-flex align-items-center mt-3 p-2 bg-white-50 rounded-lg">
                <i class="fa-solid fa-mobile-screen-button fa-2x text-primary mr-3"></i>
                <div>
                    <div class="small font-weight-bold">iPhone 14 Pro</div>
                    <div class="text-muted" style="font-size: 10px;">Thiết bị này</div>
                </div>
            </div>
        </div>

    </div>

    <div class="be-action-bar">
        <button class="be-btn-secondary" onclick="window.history.back()">Hủy bỏ</button>
        <button class="be-btn-primary" onclick="showLoading('Đang lưu...')">Lưu thay đổi</button>
    </div>
</div>