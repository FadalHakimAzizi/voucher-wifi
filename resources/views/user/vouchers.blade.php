@extends('layouts.user')

@section('title', 'Voucher Fenyxz WiFi')

@section('content')
<div class="vouchers-container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div class="mb-3 mb-md-0">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-ticket-alt fa-lg text-primary"></i>
                </div>
                <h1 class="h3 mb-0 fw-bold">Paket Voucher WiFi</h1>
            </div>
            <p class="text-muted mt-2">Pilih paket internet sesuai kebutuhan Anda</p>
        </div>
        <a href="{{ route('user.history') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="fas fa-history me-2"></i>Riwayat Pembelian
        </a>
    </div>
    
    @if($voucherTypes->isEmpty())
        <div class="card border-0 text-center p-5" style="background-color: #f8fafc; border-radius: 16px;">
            <div class="empty-icon mb-4">
                <i class="fas fa-ticket-alt fa-4x text-muted opacity-25"></i>
            </div>
            <h3 class="h5 fw-bold mb-3">Tidak ada voucher yang tersedia</h3>
            <p class="text-muted mb-4">Silakan cek kembali nanti</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-home me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($voucherTypes as $type)
            <div class="col-lg-4 col-md-6 animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="card h-100 border-0 voucher-card">
                    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                        <h3 class="h4 mb-0 fw-bold">{{ $type->duration_minutes }} Menit</h3>
                        <div class="mt-2 small opacity-75">Akses Internet Cepat</div>
                    </div>
                    <div class="card-body text-center p-4">
                        <div class="py-3">
                            <span class="display-5 fw-bold text-primary">Rp{{ number_format($type->price, 0, ',', '.') }}</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3 d-flex align-items-center justify-content-center">
                                <div class="icon-sm-wrapper bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-wifi text-primary"></i>
                                </div>
                                <span>Kecepatan hingga 100Mbps</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center justify-content-center">
                                <div class="icon-sm-wrapper bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-clock text-primary"></i>
                                </div>
                                <span>Stabil 24 Jam</span>
                            </li>
                            <li class="d-flex align-items-center justify-content-center">
                                <div class="icon-sm-wrapper bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-shield-alt text-primary"></i>
                                </div>
                                <span>Keamanan Terjamin</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-4 px-4">
                        <a href="{{ route('user.purchase.show', $type->id) }}" class="btn btn-primary w-100 rounded-pill py-2" style="box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);">
                            <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .vouchers-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .voucher-card {
        border-radius: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }
    
    .voucher-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(67, 97, 238, 0.15) !important;
    }
    
    .icon-wrapper {
        width: 50px;
        height: 50px;
        transition: transform 0.3s ease;
    }
    
    .icon-sm-wrapper {
        width: 32px;
        height: 32px;
    }
    
    .list-unstyled li {
        padding: 4px 0;
    }
    
    .display-5 {
        font-size: 2.5rem;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(67, 97, 238, 0.4) !important;
    }
    
    .empty-icon {
        opacity: 0.5;
    }
    
    @media (max-width: 768px) {
        .vouchers-container {
            padding: 0 15px;
        }
        
        .voucher-card {
            margin-bottom: 1.5rem;
        }
    }
</style>
@endsection