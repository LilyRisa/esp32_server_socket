import { useNavigate } from "react-router-dom";

export default function EditAccountPage() {
    const navigate = useNavigate();

    return (
        <div className="bento-edit-container">
            {/* HEADER */}
            <div className="d-flex justify-content-between align-items-end mb-4 px-2">
                <div>
                    <h1 className="be-title">Cài đặt tài khoản</h1>
                    <p className="text-white-50 small mb-0">
                        Quản lý thông tin cá nhân và bảo mật của bạn
                    </p>
                </div>

                <button className="be-btn-close" onClick={() => navigate(-1)}>
                    <i className="fa-solid fa-xmark"></i>
                </button>
            </div>

            {/* GRID */}
            <div className="be-grid">
                <div className="be-card be-profile-main">
                    <div className="be-avatar-wrapper">
                        <img
                            src="https://i.pravatar.cc/300?img=11"
                            id="be-preview-img"
                            alt="Avatar"
                        />
                        <label htmlFor="be-file-upload" className="be-upload-badge">
                            <i className="fa-solid fa-camera"></i>
                        </label>
                        <input type="file" id="be-file-upload" hidden />
                    </div>

                    <h3 className="mt-3 mb-1 font-weight-bold">Minh</h3>
                    <span className="be-badge">ID: bvminh101299@gmail.com</span>
                </div>

                <div className="be-card be-info">
                    <h5 className="be-card-title">Thông tin cá nhân</h5>
                    <div className="be-input-group">
                        <label>HỌ VÀ TÊN</label>
                        <input type="text" defaultValue="Minh" />
                    </div>
                    <div className="be-input-group">
                        <label>NGÀY SINH</label>
                        <input type="text" defaultValue="10/12/1999" />
                    </div>
                </div>

                <div className="be-card be-contact">
                    <h5 className="be-card-title">Liên hệ</h5>
                    <div className="be-input-group">
                        <label>SỐ ĐIỆN THOẠI</label>
                        <input type="text" placeholder="Thêm số điện thoại..." />
                    </div>
                    <div className="be-input-group">
                        <label>EMAIL DỰ PHÒNG</label>
                        <input type="email" defaultValue="minh.dev@icloud.com" />
                    </div>
                </div>

                <div className="be-card be-security">
                    <div className="d-flex align-items-center mb-3">
                        <div className="be-icon-box bg-primary">
                            <i className="fa-solid fa-shield-halved"></i>
                        </div>
                        <h5 className="be-card-title m-0 ml-2">Bảo mật</h5>
                    </div>
                    <p className="small text-muted">
                        Xác thực 2 yếu tố đang bật để bảo vệ tài khoản của bạn.
                    </p>
                    <button className="btn-apple w-100 py-2">
                        Thay đổi mật khẩu
                    </button>
                </div>

                <div className="be-card be-device-info">
                    <h5 className="be-card-title">Thiết bị tin cậy</h5>
                    <div className="d-flex align-items-center mt-3 p-2 bg-white-50 rounded-lg">
                        <i className="fa-solid fa-mobile-screen-button fa-2x text-primary mr-3"></i>
                        <div>
                            <div className="small font-weight-bold">iPhone 14 Pro</div>
                            <div className="text-muted" style={{ fontSize: 10 }}>
                                Thiết bị này
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* ACTION BAR */}
            <div className="be-action-bar">
                <button className="be-btn-secondary" onClick={() => navigate("/account")}>
                    Hủy bỏ
                </button>
                <button className="be-btn-primary">
                    Lưu thay đổi
                </button>
            </div>
        </div>
    );
}
