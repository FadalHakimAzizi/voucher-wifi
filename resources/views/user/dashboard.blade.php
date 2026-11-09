@extends('layouts.user')

@section('title', 'Dashboard Fenyxz WiFi')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Card -->
    <div class="welcome-card animate__animated animate__fadeIn">
        <div class="card border-0" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-wifi fa-2x me-3"></i>
                    <h2 class="card-title fw-bold mb-0">Selamat Datang di Fenyxz WiFi</h2>
                </div>
                
                <p class="lead mb-4">Halo, <span class="fw-bold">{{ Auth::user()->name }}</span>! Anda login sebagai pelanggan Fenyxz WiFi.</p>
                
                <div class="quick-actions d-flex flex-wrap gap-3">
                    <a href="{{ route('user.vouchers.index') }}" class="btn btn-light btn-lg rounded-pill px-4">
                        <i class="fas fa-plus-circle me-2"></i>Beli Voucher Baru
                    </a>
                    <a href="{{ route('user.redeem.form') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="fas fa-ticket-alt me-2"></i>Tebus Voucher
                    </a>
                    <a href="{{ route('user.history') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="fas fa-history me-2"></i>Riwayat Voucher
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section mt-4">
        <div class="row g-3">
            <div class="col-md-4 animate__animated animate__fadeInLeft">
                <div class="card border-0 h-100" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-clock fa-lg text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $totalMinutes ?? 0 }} menit</h3>
                        <p class="text-muted mb-0">Total Durasi Voucher</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 animate__animated animate__fadeInUp">
                <div class="card border-0 h-100" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-ticket-alt fa-lg text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $vouchers->count() }}</h3>
                        <p class="text-muted mb-0">Voucher Aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 animate__animated animate__fadeInRight">
                <div class="card border-0 h-100" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-check-circle fa-lg text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $redeemedCount ?? 0 }}</h3>
                        <p class="text-muted mb-0">Voucher Terpakai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Vouchers Section with Cards -->
    <div class="vouchers-section mt-4 animate__animated animate__fadeInUp">
        <div class="card border-0">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-ticket-alt fa-lg text-white me-3"></i>
                    <h3 class="card-title mb-0 text-white">Voucher Aktif Anda</h3>
                </div>
            </div>
            
            <div class="card-body p-4">
                @if($vouchers->isEmpty())
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-ticket-alt fa-4x text-muted opacity-25"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Belum ada voucher aktif</h4>
                        <p class="text-muted mb-4">Anda belum memiliki voucher yang aktif saat ini.</p>
                        <a href="{{ route('user.vouchers.index') }}" class="btn btn-primary btn-lg px-4 rounded-pill">
                            <i class="fas fa-shopping-cart me-2"></i>Beli Voucher Sekarang
                        </a>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($vouchers as $purchase)
                        <?php
                            $expiresAt = \Carbon\Carbon::parse($purchase->transaction_date)->addMinutes($purchase->voucher->duration_minutes);
                            $now = \Carbon\Carbon::now();
                            $isExpired = $now->greaterThan($expiresAt);
                            $timeLeft = $expiresAt->diff($now)->format('%H:%I:%S');
                        ?>
                        <div class="col-md-4 animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="card h-100 border-0 voucher-card">
                                <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                                    <h3 class="h5 mb-0">{{ $purchase->voucher->duration_minutes }} Menit</h3>
                                </div>
                                <div class="card-body text-center p-4">
                                    <div class="py-3">
                                        <span class="display-5 fw-bold text-primary">Rp{{ number_format($purchase->voucher->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="voucher-code mb-4 p-2 rounded" style="background-color: #f8f9fa;">
                                        <span class="text-muted">Kode:</span>
                                        <span class="fw-bold text-dark">{{ $purchase->voucher->code }}</span>
                                    </div>
                                    <ul class="list-unstyled mb-4">
                                        <li class="mb-3 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-wifi text-primary me-3 fa-lg"></i>
                                            <span>Internet Cepat</span>
                                        </li>
                                        <li class="mb-3 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-clock text-primary me-3 fa-lg"></i>
                                            <span>Stabil 24 Jam</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-shield-alt text-primary me-3 fa-lg"></i>
                                            <span>Aman & Terjaga</span>
                                        </li>
                                    </ul>
                                    @if(!$isExpired)
                                    <div class="countdown-wrapper p-3 rounded mb-3" style="background-color: #fff3cd;">
                                        <p class="text-warning mb-0" id="countdown-active-{{ $purchase->id }}">
                                            <i class="fas fa-hourglass-half me-2"></i>Sisa Waktu: <span id="time-left-active-{{ $purchase->id }}" class="fw-bold">{{ $timeLeft }}</span>
                                        </p>
                                    </div>
                                    <script>
                                        function startActiveCountdown(voucherId, expiresAt) {
                                            const endTime = new Date(expiresAt).getTime();
                                            const countdownElement = document.getElementById('time-left-active-' + voucherId);
                                            const redeemButton = document.getElementById('redeem-button-' + voucherId);

                                            const interval = setInterval(() => {
                                                const now = new Date().getTime();
                                                const distance = endTime - now;

                                                if (distance < 0) {
                                                    clearInterval(interval);
                                                    countdownElement.innerHTML = 'Waktu Habis';
                                                    document.getElementById('countdown-active-' + voucherId).classList.add('text-danger');
                                                    document.getElementById('countdown-active-' + voucherId).parentElement.style.backgroundColor = '#f8d7da';
                                                    redeemButton.classList.add('disabled');
                                                    redeemButton.setAttribute('aria-disabled', 'true');
                                                    return;
                                                }

                                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                countdownElement.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                                            }, 1000);
                                        }

                                        // Mulai countdown untuk voucher aktif
                                        startActiveCountdown({{ $purchase->id }}, '{{ $expiresAt->toISOString() }}');
                                    </script>
                                    @else
                                    <div class="countdown-wrapper p-3 rounded mb-3" style="background-color: #f8d7da;">
                                        <p class="text-danger mb-0">
                                            <i class="fas fa-hourglass-end me-2"></i>Kadaluwarsa
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent border-0 text-center pb-3 px-4">
                                    <a href="{{ route('user.redeem.form', ['code' => $purchase->voucher->code]) }}" 
                                       class="btn btn-primary w-100 rounded-pill py-2 @if($isExpired) disabled @endif" 
                                       id="redeem-button-{{ $purchase->id }}" 
                                       @if($isExpired) aria-disabled="true" @endif>
                                        <i class="fas fa-check-circle me-2"></i>Tebus Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Redeemed Vouchers Section with Countdown -->
    @if(!empty($redeemedVouchers) && $redeemedVouchers->isNotEmpty())
    <div class="vouchers-section mt-4 animate__animated animate__fadeInUp">
        <div class="card border-0">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #2b9348 0%, #007f5f 100%);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-ticket-alt fa-lg text-white me-3"></i>
                    <h3 class="card-title mb-0 text-white">Voucher yang Diredeem</h3>
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="row g-4">
                    @foreach($redeemedVouchers as $history)
                    <?php
                        $expiresAt = \Carbon\Carbon::parse($history->expires_at);
                        $now = \Carbon\Carbon::now();
                        $isExpired = $now->greaterThan($expiresAt);
                        $timeLeft = $expiresAt->diff($now)->format('%H:%I:%S');
                    ?>
                    <div class="col-md-4 animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="card h-100 border-0 voucher-card">
                            <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #2b9348 0%, #007f5f 100%);">
                                <h3 class="h5 mb-0">{{ $history->voucher->duration_minutes }} Menit</h3>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="py-3">
                                    <span class="display-5 fw-bold text-success">Rp{{ number_format($history->voucher->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="voucher-code mb-4 p-2 rounded" style="background-color: #f8f9fa;">
                                    <span class="text-muted">Kode:</span>
                                    <span class="fw-bold text-dark">{{ $history->voucher->code }}</span>
                                </div>
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-3 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-wifi text-success me-3 fa-lg"></i>
                                        <span>Internet Cepat</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-clock text-success me-3 fa-lg"></i>
                                        <span>Stabil 24 Jam</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-shield-alt text-success me-3 fa-lg"></i>
                                        <span>Aman & Terjaga</span>
                                    </li>
                                </ul>
                                @if(!$isExpired)
                                <div class="countdown-wrapper p-3 rounded mb-3" style="background-color: #fff3cd;">
                                    <p class="text-warning mb-0" id="countdown-{{ $history->id }}">
                                        <i class="fas fa-hourglass-half me-2"></i>Sisa Waktu: <span id="time-left-{{ $history->id }}" class="fw-bold">{{ $timeLeft }}</span>
                                    </p>
                                </div>
                                <script>
                                    function startRedeemedCountdown(historyId, expiresAt) {
                                        const endTime = new Date(expiresAt).getTime();
                                        const countdownElement = document.getElementById('time-left-' + historyId);

                                        const interval = setInterval(() => {
                                            const now = new Date().getTime();
                                            const distance = endTime - now;

                                            if (distance < 0) {
                                                clearInterval(interval);
                                                countdownElement.innerHTML = 'Waktu Habis';
                                                document.getElementById('countdown-' + historyId).classList.add('text-danger');
                                                document.getElementById('countdown-' + historyId).parentElement.style.backgroundColor = '#f8d7da';
                                                return;
                                            }

                                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                            countdownElement.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                                        }, 1000);
                                    }

                                    // Mulai countdown untuk setiap voucher yang diredeem
                                    startRedeemedCountdown({{ $history->id }}, '{{ $expiresAt->toISOString() }}');
                                </script>
                                @else
                                <div class="countdown-wrapper p-3 rounded mb-3" style="background-color: #f8d7da;">
                                    <p class="text-danger mb-0">
                                        <i class="fas fa-hourglass-end me-2"></i>Waktu Habis
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($totalRemainingTime != '00:00:00')
                <div class="mt-4 text-center">
                    <div class="total-countdown-wrapper p-3 rounded d-inline-block" style="background-color: #d1e7dd;">
                        <h4 class="text-success mb-0" id="total-countdown">
                            <i class="fas fa-clock me-2"></i>Total Sisa Waktu: <span id="total-time-left" class="fw-bold">{{ $totalRemainingTime }}</span>
                        </h4>
                    </div>
                    <script>
                        function startTotalCountdown(initialTime) {
                            const [hours, minutes, seconds] = initialTime.split(':').map(Number);
                            let totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
                            const countdownElement = document.getElementById('total-time-left');

                            const interval = setInterval(() => {
                                if (totalSeconds <= 0) {
                                    clearInterval(interval);
                                    countdownElement.innerHTML = 'Waktu Habis';
                                    document.getElementById('total-countdown').classList.add('text-danger');
                                    document.getElementById('total-countdown').parentElement.style.backgroundColor = '#f8d7da';
                                    return;
                                }

                                totalSeconds--;
                                const hours = Math.floor(totalSeconds / 3600);
                                const minutes = Math.floor((totalSeconds % 3600) / 60);
                                const seconds = totalSeconds % 60;
                                countdownElement.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                            }, 1000);
                        }

                        // Mulai countdown untuk total sisa waktu
                        startTotalCountdown('{{ $totalRemainingTime }}');
                    </script>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .welcome-card .card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(67, 97, 238, 0.2);
    }
    
    .vouchers-section .card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .voucher-card {
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .voucher-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    
    .list-unstyled li {
        padding: 4px 0;
    }
    
    .display-5 {
        font-size: 2.5rem;
    }
    
    .empty-icon {
        opacity: 0.5;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
    
    .countdown-wrapper {
        transition: all 0.3s ease;
    }
    
    .icon-wrapper {
        transition: transform 0.3s ease;
    }
    
    .stats-section .card:hover .icon-wrapper {
        transform: scale(1.1);
    }
    
    @media (max-width: 768px) {
        .welcome-card .card-body {
            padding: 1.5rem;
        }
        
        .quick-actions {
            flex-direction: column;
            gap: 1rem !important;
        }
        
        .quick-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection