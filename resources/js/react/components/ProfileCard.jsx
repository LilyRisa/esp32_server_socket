import { useNavigate } from "react-router-dom";

export default function ProfileCard() {
    const navigate = useNavigate();
    return (
        <div className="col-lg-4 col-md-12 mb-3 mb-md-0">
            <div className="card glass-card text-center">
                <div className="card-body d-flex flex-column justify-content-center align-items-center">
                    <div className="avatar-box mb-3">
                        <img
                            src="https://i.pravatar.cc/300?img=11"
                            className="rounded-circle"
                        />
                    </div>

                    <h4 className="font-weight-bold mb-1">Minh</h4>
                    <p className="text-muted mb-3">bvminh101299@gmail.com</p>

                    <div className="d-flex gap-2">
                        <span className="badge badge-pill badge-light text-primary px-3 py-2 mr-2">
                            Premium+
                        </span>

                        <button
                            className="btn btn-glass-primary btn-sm"
                            onClick={() => navigate("/account/edit")}
                        >
                            <i className="fa-solid fa-pen-to-square"></i> Sửa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}