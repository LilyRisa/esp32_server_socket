@extends('adminlte::page')

@section('title', 'Danh sách thiết bị')

@section('content_header')
    <h1>Danh sách thiết bị</h1>
@stop

@section('content')
<style>
    /* Container grid */
    .device-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 32px;
        margin-top: 30px;
    }

    /* Card base */
    .device-card {
        position: relative;
        background: rgba(255, 255, 255, 0.02);
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        overflow: hidden;
        padding: 24px;
        text-align: center;
        transition: all 0.5s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        cursor: pointer;
    }

    /* Base glowing ring */
    .device-card::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 24px;
        padding: 2px;
        background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        transition: all 0.4s ease;
    }

    /* Hover glow */
    .device-card:hover::before {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8, #0ea5e9);
        box-shadow: 0 0 20px rgba(14,165,233,0.5);
    }

    /* Speaker image */
    .device-card img {
        width: 90px;
        height: 90px;
        margin: 16px auto;
        filter: drop-shadow(0 0 10px rgba(255,255,255,0.1));
        transition: all 0.5s ease;
    }

    .device-card:hover img {
        transform: scale(1.1) rotate(-2deg);
        filter: drop-shadow(0 0 15px rgba(14,165,233,0.6));
    }

    /* Device info (hidden by default) */
    .device-info {
        opacity: 0;
        transform: translateY(15px);
        transition: all 0.5s ease;
    }

    .device-card:hover .device-info {
        opacity: 1;
        transform: translateY(0);
    }

    .device-code {
        color: #0ea5e9;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 10px;
        text-shadow: 0 0 8px rgba(14,165,233,0.4);
    }

    /* DSP Button */
    .btn-dsp {
        background: linear-gradient(145deg, #0ea5e9, #38bdf8);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        box-shadow: 0 6px 0 #0284c7, 0 0 15px rgba(14,165,233,0.4);
        transition: all 0.2s ease;
        transform: translateY(0);
    }

    .btn-dsp:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 0 #0369a1, 0 0 25px rgba(14,165,233,0.7);
    }

    .btn-dsp:active {
        transform: translateY(2px);
        box-shadow: 0 4px 0 #0369a1;
    }

    /* Device name */
    .device-name {
        font-size: 1.05rem;
        color: #e2e8f0;
        font-weight: 500;
        letter-spacing: 0.3px;
        margin-top: 8px;
    }

</style>

<div class="device-grid">
    @foreach ($devices as $device)
    <div class="device-card">
        <img src="{{ asset('images/speaker.png') }}" alt="Speaker">

        <div class="device-name">Thiết bị:</div>

        <div class="device-info">
            <div class="device-code">{{ $device->code }}</div>
            <a href="{{ route('devices.dsp') }}" class="btn btn-dsp">⚙ DSP</a>
        </div>
    </div>
    @endforeach
</div>

@stop