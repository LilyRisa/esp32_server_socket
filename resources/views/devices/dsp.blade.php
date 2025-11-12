@extends('adminlte::page')

@section('title', 'DSP Thiết bị')

@section('content_header')
<h1 class="text-danger font-weight-bold">🎚️ Điều chỉnh DSP Thiết bị</h1>
@stop

@section('plugins.jquery', true)

@section('content')
<style>
    body {
        background: #000;
        color: #fff;
    }

    .dsp-manager {
        background: linear-gradient(180deg, #000, #1a0000);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 0 40px rgba(255, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }

    .dsp-toolbar {
        position: sticky;
        top: 0;
        z-index: 10;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
        background: rgba(0, 0, 0, 0.85);
        border-radius: 12px;
        padding: 15px 25px;
        border: 1px solid rgba(255, 0, 0, 0.3);
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.1);
        margin-bottom: 25px;
    }

    .dsp-toolbar label {
        font-weight: 600;
        color: #ffffff;
    }

    .dsp-toolbar select {
        background: #000000;
        border: 1px solid #fff;
        border-radius: 10px;
        color: #fff;
        padding: 10px 14px;
        font-weight: 500;
        min-width: 200px;
        transition: 0.2s;
    }

    .dsp-toolbar select:hover,
    .dsp-toolbar select:focus {
        border-color: red;
        box-shadow: 0 0 5px rgba(255, 0, 0, 0.6);
        outline: none;
    }

    .btn-save,
    .btn-stream {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: 0.25s ease;
        color: #fff;
        border: none;
        box-shadow: 0 6px 0 rgba(80, 0, 0, 0.6);
    }

    .btn-save {
        background: linear-gradient(145deg, #dc2626, #ef4444);
        box-shadow: 0 6px 0 #7f1d1d, 0 0 15px rgba(239, 68, 68, 0.4);
    }

    .btn-save:hover {
        background: #ef4444;
        transform: translateY(-2px);
    }

    .btn-stream {
        background: linear-gradient(145deg, #991b1b, #dc2626);
        box-shadow: 0 6px 0 #450a0a, 0 0 15px rgba(220, 38, 38, 0.5);
    }

    .btn-stream:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .eq-chart {
        background: #0d0d0d;
        color: #fff;
        font-family: "Segoe UI", sans-serif;
        display: flex;
        gap: 40px;
        padding: 40px;
    }

    /* ==== Panel trái ==== */
    .panel {
        width: 220px;
    }

    .panel label {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        font-size: 15px;
        font-weight: 500;
    }

    .panel input[type=range] {
        width: 100%;
        height: 8px;
        accent-color: #ff3355;
    }

    /* ==== Biểu đồ EQ ==== */
    .eq-container {
        flex: 1;
        background: #161616;
        border-radius: 14px;
        padding: 25px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .eq-chart-wrapper {
        width: 90%;
        height: auto;
        aspect-ratio: 3 / 1;
        max-width: 900px;
    }

    canvas {
        width: 100% !important;
        height: 100% !important;
        display: block;
        image-rendering: crisp-edges;
    }

    /* ==== Knobs ==== */
    .freq-knobs {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 14px;
        margin-top: 20px;
        width: 90%;
        max-width: 850px;
    }

    .knob-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 45px;
        flex: 1;
    }

    .knob {
        width: 32px;
        height: 32px;
        display: inline-block;
    }

    .freq-label {
        font-size: 10px;
        color: #aaa;
        margin-top: -3px;
    }
</style>

<div class="dsp-manager">
    <div class="dsp-toolbar">
        <div>
            <label>Thiết bị:</label><br>
            <select id="deviceSelect">
                <option value="">-- Chọn thiết bị --</option>
                @foreach ($devices as $device)
                <option value="{{ $device->code }}">{{ $device->code }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Hiệu ứng mẫu:</label><br>
            <select id="templateSelect">
                <option value="Garenal">Garenal</option>
                <option value="movie">Movie</option>
                <option value="tv">TV</option>
                <option value="music">Music</option>
                <option value="voice">Voice</option>
                <option value="bassboost">Bass Boost</option>
                <option value="vocal">Vocal</option>
                <option value="transcription">Transcription</option>
            </select>
        </div>

        <div>
            <label>Hiệu ứng đã lưu:</label><br>
            <select id="presetSelect">
                <option value="">-- Chọn hiệu ứng đã lưu --</option>
            </select>
        </div>

        <div style="margin-left:auto; display:flex">
            <button id="saveBtn" class="btn btn-save" style="margin-right:8px">Lưu</button>
            <button id="streamBtn" class="btn btn-stream">Stream firmware</button>
        </div>
    </div>

    <div class="eq-chart">
        <div class="panel">
            <label>Clarity <span id="clarity-val">4</span></label>
            <input type="range" id="clarity" min="0" max="10" value="4">

            <label>Ambience <span id="ambience-val">0</span></label>
            <input type="range" id="ambience" min="0" max="10" value="0">

            <label>Surround <span id="surround-val">2</span></label>
            <input type="range" id="surround" min="0" max="10" value="2">

            <label>Dynamic Boost <span id="dynamic-val">5</span></label>
            <input type="range" id="dynamic" min="0" max="10" value="5">

            <label>Bass Boost <span id="bass-val">5</span></label>
            <input type="range" id="bass" min="0" max="10" value="5">
        </div>

        <div class="eq-container">
            <div class="eq-chart-wrapper">
                <canvas id="eqChart"></canvas>
            </div>
            <div class="freq-knobs" id="freq-knobs"></div>
        </div>
    </div>
</div>

@endsection

@section('plugins.chartJs', true)


@section("js")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/gh/aterrien/jQuery-Knob/dist/jquery.knob.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
    //  Template chọn sẵn
   $('#templateSelect').on('change', function () {
        const presetName = this.value;

        const presets = {
            Garenal: {
                eq: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                clarity: 4,
                ambience: 0,
                surround: 2,
                dynamic: 5,
                bass: 5
            },
            movie: {
                eq: [0, 0, 2, 0, 2, 2, 1, -1, 0, 2],
                clarity: 5,
                ambience: 0,
                surround: 4,
                dynamic: 7,
                bass: 3
            },
            tv: {
                eq: [0, 0, 1, 0, 1, 0, 1, -1, -1, 2],
                clarity: 4,
                ambience: 2,
                surround: 4,
                dynamic: 5,
                bass: 4
            },
            music: {
                eq: [0, 2, 2, 1, 0, 0, 0, -1, 0, 0],
                clarity: 4,
                ambience: 3,
                surround: 3,
                dynamic: 2,
                bass: 5
            },
            voice: {
                eq: [0, -4, -2, 2, 4, 5, 3, 3, 5, -11],
                clarity: 6,
                ambience: 0,
                surround: 0,
                dynamic: 7,
                bass: 0
            },
            bassboost: {
                eq: [0, 3, 3, 3, 2, 1, -1, -1, -1, 0],
                clarity: 2,
                ambience: 3,
                surround: 3,
                dynamic: 2,
                bass: 6
            },
            vocal: {
                eq: [-2, -1, 0, 1, 2, 3, 4, 5, 4, 3],
                clarity: 8,
                ambience: 1,
                surround: 2,
                dynamic: 5,
                bass: 4
            },
            
            transcription: {
                eq: [0, -12, 7, 2, -1, 7, 0, 10, 3, -12],
                clarity: 8,
                ambience: 0,
                surround: 0,
                dynamic: 9,
                bass: 6
            }
        };

        applyDSPPreset(presets[presetName] || presets.flat);
    });

    //  Lưu preset
    $('#saveBtn').on('click', function () {
        const deviceId = $('#deviceSelect').val();
        if (!deviceId) return alert('⚠️ Vui lòng chọn thiết bị.');
        const presetName = prompt('Tên cấu hình DSP:', 'DSP_' + new Date().getFullYear());
        if (!presetName) return;

        $.ajax({
            url: '/dsp/save',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                device_id: deviceId,
                name: presetName,
                eq_data: outputJSON(),
                
            }),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: res => alert(res.success ? '✅ ' + res.message : '❌ Lỗi lưu'),
            error: () => alert('⚠️ Lỗi máy chủ')
        });
    });

    //  Stream tới thiết bị
    $('#streamBtn').on('click', function () {

        Swal.fire({
            title: "Bạn chắc chắn chứ?",
            text: "Hành động này sẽ nạp trực tiếp và ghi đè cấu hình EQ vào firmware của thiết bị với điều khiện thiết bị đã cấu hình kết nối internet",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Nạp EQ vào thiết bị",
            cancelButtonText: "Đóng"
        }).then((result) => {
            if (result.isConfirmed) {
                const deviceId = $('#deviceSelect').val();
                if (!deviceId) return alert('Hãy chọn thiết bị trước khi stream!');
                $.ajax({
                    url: '/dsp/stream',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        device_code: deviceId,
                        eq_data: outputJSON()
                }),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: res => alert(res.success ? 'Gửi cấu hình DSP thành công!' :  res.message),
                    error: () => alert('⚠️ Lỗi kết nối máy chủ hoặc thiết bị!')
                });
            }
        });
        
    });

     const freqs = ["62 Hz","115 Hz","250 Hz","450 Hz","630 Hz","1.25 kHz","2.7 kHz","5.3 kHz","7.5 kHz","13 kHz"];
  let gains = [0,0,1,2,0,-1,0,-1,-2,0];
  let draggingPoint = null;

  // Custom plugin để vẽ số phía trên chấm
  const drawValuePlugin = {
    id: 'drawValuePlugin',
    afterDatasetsDraw(chart) {
      const { ctx } = chart;
      chart.data.datasets.forEach((dataset, i) => {
        const meta = chart.getDatasetMeta(i);
        meta.data.forEach((point, index) => {
          const value = dataset.data[index];
          ctx.save();
          ctx.font = "11px Segoe UI";
          ctx.fillStyle = "#fff";
          ctx.textAlign = "center";
          ctx.fillText(value, point.x, point.y - 8);
          ctx.restore();
        });
      });
    }
  };

  const ctx = $("#eqChart")[0].getContext("2d");
  const eqChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: freqs,
      datasets: [{
        data: gains,
        borderColor: "#ff3355",
        backgroundColor: "#ff335522",
        pointBackgroundColor: "#ff3355",
        pointRadius: 5,
        fill: true,
        tension: 0.35
      }]
    },
    options: {
      animation: false,
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          min: -12,
          max: 12,
          ticks: {
            display: false // ❌ Ẩn số trên trục dọc
          },
          grid: {
            display: false // ❌ Ẩn đường kẻ ngang
          },
          border: { display: false }
        },
        x: {
          ticks: {
            color: "#ccc",
            font: { size: 9 }
          },
          grid: { color: "#222" }
        }
      },
      plugins: { legend: { display: false } },
      interaction: { mode: 'nearest', intersect: true },
      onHover: (e, elements) => {
        e.native.target.style.cursor = elements.length ? 'grab' : 'default';
      }
    },
    plugins: [drawValuePlugin]
  });

  // === Kéo trực tiếp điểm trên biểu đồ ===
  $("#eqChart").on("mousedown touchstart", function(e) {
    const points = eqChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, false);
    if (points.length) draggingPoint = points[0].index;
  });

  $(window).on("mouseup touchend", function() {
    draggingPoint = null;
  });

  $("#eqChart").on("mousemove touchmove", function(e) {
    if (draggingPoint === null) return;
    const yScale = eqChart.scales.y;
    const clientY = e.offsetY || (e.originalEvent.touches ? e.originalEvent.touches[0].clientY - $(this).offset().top : 0);
    const yValue = yScale.getValueForPixel(clientY);
    gains[draggingPoint] = Math.max(-12, Math.min(12, Math.round(yValue)));
    eqChart.data.datasets[0].data = gains;
    eqChart.update();
    $(".knob").eq(draggingPoint).val(gains[draggingPoint]).trigger('change');
    outputJSON();
  });

  // === Knob nhỏ gọn ===
  freqs.forEach((label, i) => {
    const $wrap = $("<div>", { class: "knob-wrapper" });
    const $knob = $("<input>", {
      type: "text",
      value: gains[i],
      class: "knob"
    });

    $wrap.append($knob).append($("<div>", { class: "freq-label", text: label }));
    $("#freq-knobs").append($wrap);

    $knob.knob({
      min: -12,
      max: 12,
      step: 1,
      width: 32,
      height: 32,
      fgColor: "#ff3355",
      bgColor: "#292929",
      thickness: 0.45,
      displayInput: false,
      angleArc: 300,
      angleOffset: -150,
      change: function(v) {
        gains[i] = parseInt(v);
        eqChart.data.datasets[0].data = gains;
        eqChart.update();
        outputJSON();
      }
    });
  });

  // === Thanh trượt trái ===
  ["clarity","ambience","surround","dynamic","bass"].forEach(id => {
    $("#" + id).on("input", function() {
      $("#" + id + "-val").text($(this).val());
      outputJSON();
    });
  });

  // === JSON Output ===
  function outputJSON() {
    const data = {
      clarity: parseInt($("#clarity").val()),
      ambience: parseInt($("#ambience").val()),
      surround: parseInt($("#surround").val()),
      dynamic_boost: parseInt($("#dynamic").val()),
      bass_boost: parseInt($("#bass").val()),
      eq: gains.slice()
    };
    console.log(JSON.stringify(data, null, 2));
    return data;
  }
function applyDSPPreset(preset) {
    if (!preset) return;

    // === Cập nhật EQ Chart ===
    if (preset.eq && Array.isArray(preset.eq)) {
        gains = preset.eq.slice();
        eqChart.data.datasets[0].data = gains;
        eqChart.update();

        // Cập nhật knob tương ứng
        $(".knob").each(function (i) {
            $(this).val(gains[i]).trigger('change');
        });
    }

    // === Cập nhật các thanh trượt bên trái ===
    const fields = ["clarity", "ambience", "surround", "dynamic", "bass"];
    fields.forEach(id => {
        if (preset[id] !== undefined) {
            $("#" + id).val(preset[id]).trigger('input');
            $("#" + id + "-val").text(preset[id]);
        }
    });

    // === Cập nhật JSON log ra console ===
    outputJSON();
}
});

</script>
@stop