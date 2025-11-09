@extends('adminlte::page')

@section('title', 'DSP Thiết bị')

@section('content_header')
<h1>Điều chỉnh DSP Thiết bị</h1>
@stop

@section('content')
<style>
    .dsp-container {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    }

    .dsp-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
        margin-bottom: 30px;
    }

    .dsp-toolbar select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        color: rgb(126, 126, 126);
        padding: 10px 14px;
        font-weight: 500;
        min-width: 200px;
    }

    .dsp-toolbar label {
        color: #adadad;
        font-weight: 600;
    }

    .btn-save,
    .btn-stream {
        border-radius: 12px;
        font-weight: 600;
        padding: 10px 20px;
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
        color: #fff;
    }

    .btn-save {
        background: linear-gradient(145deg, #0ea5e9, #38bdf8);
        box-shadow: 0 6px 0 #0369a1, 0 0 15px rgba(14, 165, 233, 0.5);
    }

    .btn-stream {
        background: linear-gradient(145deg, #10b981, #34d399);
        box-shadow: 0 6px 0 #059669, 0 0 15px rgba(16, 185, 129, 0.5);
    }

    .eq-chart-container {
        margin-top: 30px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    canvas {
        width: 100%;
        height: 350px;
    }

    .eq-labels {
        text-align: center;
        margin-top: 10px;
        color: #94a3b8;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .eq-chart-container {
        margin-top: 25px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        padding: 10px 15px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        height: 230px;
        /* Giảm chiều cao */
    }

    canvas {
        width: 100% !important;
        height: 180px !important;
        /* Hiển thị gọn, ESP32 dễ xử lý */
    }
</style>

<div class="dsp-container">
    <div class="dsp-toolbar">
        <div>
            <label>Thiết bị:</label><br>
            <select id="deviceSelect">
                <option value="">-- Chọn thiết bị --</option>
                @foreach ($devices as $device)
                <option value="{{ $device->id }}">{{ $device->code }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Hiệu ứng mẫu:</label><br>
            <select id="templateSelect">
                <option value="flat">Âm phẳng</option>
                <option value="bassboost">Bass Boost</option>
                <option value="vocal">Giọng hát</option>
                <option value="cinema">Rạp phim</option>
            </select>
        </div>

        <div>
            <label>Hiệu ứng đã lưu:</label><br>
            <select id="presetSelect">
                <option value="">-- Chọn hiệu ứng đã lưu --</option>
            </select>
        </div>

        <div style="margin-left:auto; display:flex">
            <button id="saveBtn" class="btn btn-save" style="margin-right:5px">Lưu cấu hình</button>
            <button id="streamBtn" class="btn btn-stream">Set firmware</button>
        </div>
    </div>

    <div class="eq-chart-container">
        <canvas id="eqChart"></canvas>
        <div class="eq-labels">
            32Hz | 64Hz | 125Hz | 250Hz | 500Hz | 1kHz | 2kHz | 4kHz | 8kHz | 16kHz
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-dragdata@2.1.2/dist/chartjs-plugin-dragdata.min.js"></script>

<script>
    document.getElementById('streamBtn').addEventListener('click', () => {
    const deviceId = document.getElementById('deviceSelect').value;
    if (!deviceId) {
        alert('⚠️ Hãy chọn thiết bị trước khi stream!');
        return;
    }

    const eqData = window.eqChart.data.datasets[0].data;

    fetch('/dsp/stream', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            device_id: deviceId,
            eq_data: eqData
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Gửi cấu hình DSP thành công đến thiết bị!');
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(() => {
        alert('⚠️ Lỗi kết nối máy chủ hoặc thiết bị!');
    });
});
    
    // Khi chọn thiết bị → load preset
document.getElementById('deviceSelect').addEventListener('change', function() {
    const deviceId = this.value;
    const presetSelect = document.getElementById('presetSelect');
    presetSelect.innerHTML = '<option value="">-- Đang tải --</option>';

    if (!deviceId) {
        presetSelect.innerHTML = '<option value="">-- Chọn thiết bị trước --</option>';
        return;
    }

    fetch('/dsp/get-presets', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ device_id: deviceId })
    })
    .then(r => r.json())
    .then(presets => {
        if (presets.length === 0) {
            presetSelect.innerHTML = '<option value="">-- Chưa có hiệu ứng lưu --</option>';
            return;
        }
        presetSelect.innerHTML = '<option value="">-- Chọn hiệu ứng đã lưu --</option>';
        presets.forEach(p => {
            presetSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
        });
    });
});

// Khi chọn preset → load chi tiết EQ
document.getElementById('presetSelect').addEventListener('change', function() {
    const presetId = this.value;
    if (!presetId) return;


    fetch('/dsp/get-preset-detail', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ preset_id: presetId })
    })
    .then(r => r.json())
    .then(res => {
        if (res.success && res.data.eq_data) {
            eqChart.data.datasets[0].data = res.data.eq_data;
            eqChart.update();
            // alert('🎧 Đã tải cấu hình DSP: ' + res.data.name);
        }
    });
});

    document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('eqChart').getContext('2d');

    const freqs = [32, 64, 125, 250, 500, 1000, 2000, 4000, 8000, 16000];
    const eqData = [0,0,0,0,0,0,0,0,0,0];

    // 🔹 Plugin vẽ baseline 0 dB và các dấu tròn
    const baselinePlugin = {
        id: 'baseline',
        afterDraw(chart) {
            const {ctx, chartArea, scales: {x, y}} = chart;

            // --- baseline ---
            ctx.save();
            ctx.beginPath();
            ctx.strokeStyle = 'rgba(255,255,255,0.25)';
            ctx.lineWidth = 1.2;
            const yZero = y.getPixelForValue(0);
            ctx.moveTo(chartArea.left, yZero);
            ctx.lineTo(chartArea.right, yZero);
            ctx.stroke();

            // --- dấu tròn ---
            const points = chart.data.labels.length;
            for (let i = 0; i < points; i++) {
                const xPos = x.getPixelForValue(i);
                ctx.beginPath();
                ctx.arc(xPos, yZero, 4, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(14,165,233,0.8)';
                ctx.fill();
                ctx.lineWidth = 1;
                ctx.strokeStyle = 'rgba(255,255,255,0.2)';
                ctx.stroke();
            }
            ctx.restore();
        }
    };

    const eqChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: freqs,
            datasets: [{
                data: eqData,
                backgroundColor: 'rgba(14,165,233,0.85)',
                borderRadius: 6,
                hoverBackgroundColor: 'rgba(56,189,248,0.95)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true },
            },
            scales: {
                y: {
                    min: -12,
                    max: 12,
                    ticks: { color: '#cbd5e1', stepSize: 3 },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            }
        },
        plugins: [baselinePlugin]
    });

     window.eqChart = eqChart;

    // === Kéo chỉnh bằng chuột ===
    let isDragging = false;
    let activeIndex = null;

    const getMouseValue = (yPixel) => {
        const yScale = eqChart.scales.y;
        const val = yScale.getValueForPixel(yPixel);
        return Math.max(-12, Math.min(12, val));
    };

    const getBarIndex = (xPixel) => {
        const xScale = eqChart.scales.x;
        const xPositions = eqChart.data.labels.map((_, i) => xScale.getPixelForValue(i));
        return xPositions.reduce((closest, x, i) =>
            Math.abs(x - xPixel) < Math.abs(xPositions[closest] - xPixel) ? i : closest, 0);
    };

    ctx.canvas.addEventListener('mousedown', (e) => {
        const rect = ctx.canvas.getBoundingClientRect();
        const x = e.clientX - rect.left, y = e.clientY - rect.top;
        activeIndex = getBarIndex(x);
        isDragging = true;
        eqChart.data.datasets[0].data[activeIndex] = getMouseValue(y);
        eqChart.update();
    });

    ctx.canvas.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        const rect = ctx.canvas.getBoundingClientRect();
        const y = e.clientY - rect.top;
        eqChart.data.datasets[0].data[activeIndex] = getMouseValue(y);
        eqChart.update();
    });

    ['mouseup', 'mouseleave'].forEach(evt =>
        ctx.canvas.addEventListener(evt, () => isDragging = false)
    );

    // === Template Presets ===
    document.getElementById('templateSelect').addEventListener('change', function() {
        const val = this.value;
        const presets = {
            flat: [0,0,0,0,0,0,0,0,0,0],
            bassboost: [6,5,4,3,1,0,-1,-2,-3,-4],
            vocal: [-2,-1,0,1,2,3,4,5,4,3],
            cinema: [2,3,2,0,-1,0,1,2,3,4],
        };
        eqChart.data.datasets[0].data = presets[val] || presets.flat;
        eqChart.update();
    });

    // === SAVE ===
    document.getElementById('saveBtn').addEventListener('click', () => {
        const deviceId = document.getElementById('deviceSelect').value;
        if (!deviceId) return alert('⚠️ Vui lòng chọn thiết bị.');
        const presetName = prompt('Tên cấu hình DSP:', 'CM_Custom_' + new Date().getFullYear());
        if (!presetName) return;

        fetch('/dsp/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                device_id: deviceId,
                name: presetName,
                eq_data: eqChart.data.datasets[0].data
            })
        })
        .then(r => r.json())
        .then(res => alert(res.success ? '✅ ' + res.message : '❌ Lỗi lưu'))
        .catch(() => alert('⚠️ Lỗi máy chủ'));
    });

    // === STREAM ===
    document.getElementById('streamBtn').addEventListener('click', () => {
        console.log('📡 Gửi cấu hình sang loa:', eqChart.data.datasets[0].data);
        alert('Đang stream cấu hình sang ESP32...');
    });
});
</script>
@stop