<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMB aduio</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @yield('style')
</head>
<body>

<div class="container">
    
    @yield('content')

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

<script>
   // Dữ liệu ứng dụng mô phỏng theo ảnh bạn gửi
    const apps = [
        { name: 'Mail', icon: 'fa-envelope', color: 'linear-gradient(#5AC8FB, #007AFF)' },
        { name: 'Danh bạ', icon: 'fa-address-book', color: 'linear-gradient(#A2A2A2, #7D7D7D)' },
        { name: 'Lịch', icon: 'fa-calendar-days', color: 'white', textColor: '#FF3B30' },
        { name: 'Ảnh', icon: 'fa-image', color: 'white', textColor: '#FFCC00' },
        { name: 'Drive', icon: 'fa-cloud', color: 'linear-gradient(#5AC8FB, #007AFF)' },
        { name: 'Ghi chú', icon: 'fa-note-sticky', color: '#FFCC00' },
        { name: 'Lời nhắc', icon: 'fa-list-ul', color: 'white', textColor: '#5AC8FB' },
        { name: 'Lời mời', icon: 'fa-envelope-open-text', color: '#FF9500' },
        { name: 'Pages', icon: 'fa-pen-nib', color: '#FF9500' },
        { name: 'Numbers', icon: 'fa-chart-bar', color: '#34C759' },
        { name: 'Keynote', icon: 'fa-desktop', color: '#5AC8FB' },
        { name: 'Tìm', icon: 'fa-location-crosshairs', color: '#34C759' }
    ];

    const devices = [
        { name: "iPhone 14", icon: "fa-mobile-screen" },
        { name: "MacBook", icon: "fa-laptop" },
        { name: "AirPods", icon: "fa-headphones" }
    ];

    const audios = [
        { name: "Mua_Thang_Sau.mp3", desc: "4.5 MB - 20/12" },
        { name: "Meeting_Audio.wav", desc: "12.0 MB - Hôm nay" }
    ];

    $(document).ready(function() {
        // Render App Grid
        let appHtml = '';
        apps.forEach(app => {
            appHtml += `
                <a href="#" class="app-item">
                    <div class="app-icon" style="background: ${app.color}; color: ${app.textColor || 'white'}">
                        <i class="fa-solid ${app.icon}"></i>
                    </div>
                    <span class="app-name">${app.name}</span>
                </a>
            `;
        });
        $('#app-grid-container').html(appHtml);

        // Render Devices
        let deviceHtml = '';
        devices.forEach(d => {
            deviceHtml += `
                <div class="col-4">
                    <div class="device-item">
                        <i class="fa-solid ${d.icon} fa-2x mb-2"></i>
                        <div class="small font-weight-bold">${d.name}</div>
                    </div>
                </div>
            `;
        });
        $('#device-container').html(deviceHtml);

        // Render Audio
        let audioHtml = '';
        audios.forEach(a => {
            audioHtml += `
                <div class="audio-item">
                    <div class="bg-danger text-white rounded p-2 mr-3"><i class="fa fa-music"></i></div>
                    <div class="flex-grow-1">
                        <div class="small font-weight-bold">${a.name}</div>
                        <div class="text-muted small">${a.desc}</div>
                    </div>
                    <i class="fa fa-play text-primary cursor-pointer"></i>
                </div>
            `;
        });
        $('#audio-container').html(audioHtml);
    });
</script>

@yield('script')

</body>
</html>