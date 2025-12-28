@extends('layout')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-4 col-md-5 mb-3 mb-md-0">
            <div class="card glass-card text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="avatar-box mb-3">
                        <img src="https://i.pravatar.cc/300?img=11" class="rounded-circle" id="userAvatar">
                    </div>
                    <h4 class="font-weight-bold mb-1" id="userName">Đang tải...</h4>
                    <p class="text-muted mb-3" id="userEmail">...</p>
                    
                    <div class="d-flex gap-2">
                        <span class="badge badge-pill badge-light text-primary px-3 py-2 mr-2">iCloud+</span>
                        <button class="btn btn-glass-primary btn-sm" data-toggle="modal" data-target="#editUserModal">
                            <i class="fa-solid fa-pen-to-square"></i> Sửa
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <div class="card glass-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="font-weight-bold m-0"><i class="fa-solid fa-laptop-mobile text-primary mr-2"></i>Thiết bị</h5>
                        <button class="btn btn-glass-secondary btn-sm" onclick="alert('Mở trang quản lý thiết bị')">
                            <i class="fa-solid fa-gear"></i> Quản lý
                        </button>
                    </div>

                    <div class="row" id="deviceListContainer">
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
            <div class="card glass-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="font-weight-bold m-0"><i class="fa-solid fa-music text-danger mr-2"></i>Audio Uploads</h5>
                        <div>
                            <button class="btn btn-glass-primary btn-sm mr-1">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Upload
                            </button>
                            <button class="btn btn-glass-secondary btn-sm">
                                <i class="fa-solid fa-list-check"></i> QL File
                            </button>
                        </div>
                    </div>

                    <div class="list-group list-group-flush" id="audioListContainer">
                         </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-5">
            <div class="card glass-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="font-weight-bold m-0"><i class="fa-solid fa-sliders text-success mr-2"></i>EQ Device</h5>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="eqSwitch" checked>
                            <label class="custom-control-label" for="eqSwitch"></label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-end h-100">
                        <div class="text-center">
                            <div class="eq-slider-wrapper"><input type="range" min="0" max="100" value="70" orient="vertical"></div>
                            <small class="font-weight-bold text-muted mt-2 d-block">BASS</small>
                        </div>
                        <div class="text-center">
                            <div class="eq-slider-wrapper"><input type="range" min="0" max="100" value="40" orient="vertical"></div>
                            <small class="font-weight-bold text-muted mt-2 d-block">MID</small>
                        </div>
                        <div class="text-center">
                            <div class="eq-slider-wrapper"><input type="range" min="0" max="100" value="80" orient="vertical"></div>
                            <small class="font-weight-bold text-muted mt-2 d-block">TREB</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection