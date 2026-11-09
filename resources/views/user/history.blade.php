@extends('layouts.user')

@section('title', 'Riwayat Fenyxz WiFi')

@section('content')
<div class="history-container py-4">
    <!-- Pembelian Section -->
    <div class="card border-0 mb-5 animate__animated animate__fadeIn" style="box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
        <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
            <div class="d-flex align-items-center">
                <i class="fas fa-shopping-cart fa-lg me-3"></i>
                <h2 class="h5 mb-0 fw-bold">Riwayat Pembelian</h2>
            </div>
        </div>
        <div class="card-body p-4">
            @if($purchases->isEmpty())
                <div class="empty-state text-center p-5 rounded-3" style="background-color: #f8fafc;">
                    <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-4">
                        <i class="fas fa-receipt fa-2x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Belum Ada Riwayat</h4>
                    <p class="text-muted mb-4">Anda belum memiliki riwayat pembelian voucher</p>
                    <a href="{{ route('user.vouchers.index') }}" class="btn btn-primary px-4 rounded-pill">
                        <i class="fas fa-plus me-2"></i>Beli Voucher Sekarang
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background-color: #f8fafc;">
                            <tr>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Kode Voucher</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Jumlah</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Tanggal</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($purchases as $purchase)
                            <tr class="border-bottom">
                                <td class="py-3 fw-bold text-primary">{{ $purchase->voucher->code }}</td>
                                <td class="py-3">Rp{{ number_format($purchase->amount, 0, ',', '.') }}</td>
                                <td class="py-3">{{ \Carbon\Carbon::parse($purchase->transaction_date)->format('d M Y H:i') }}</td>
                                <td class="py-3 text-end">
                                    <a href="{{ route('user.invoice.show', $purchase->id) }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                                        <i class="fas fa-file-invoice me-2"></i>Invoice
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Penggunaan Section -->
    <div class="card border-0 animate__animated animate__fadeIn" style="box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
        <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #2b9348 0%, #007f5f 100%);">
            <div class="d-flex align-items-center">
                <i class="fas fa-wifi fa-lg me-3"></i>
                <h2 class="h5 mb-0 fw-bold">Riwayat Penggunaan</h2>
            </div>
        </div>
        <div class="card-body p-4">
            @if($usages->isEmpty())
                <div class="empty-state text-center p-5 rounded-3" style="background-color: #f8fafc;">
                    <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-4">
                        <i class="fas fa-history fa-2x text-success"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Belum Ada Riwayat</h4>
                    <p class="text-muted mb-0">Anda belum memiliki riwayat penggunaan voucher</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background-color: #f8fafc;">
                            <tr>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Kode Voucher</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Mulai Digunakan</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0">Durasi</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted border-0 text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($usages as $usage)
                            <?php
                                $expiresAt = \Carbon\Carbon::parse($usage->expires_at);
                                $isExpired = \Carbon\Carbon::now()->greaterThan($expiresAt);
                            ?>
                            <tr class="border-bottom">
                                <td class="py-3 fw-bold text-success">{{ $usage->voucher->code }}</td>
                                <td class="py-3">{{ \Carbon\Carbon::parse($usage->start_time)->format('d M Y H:i') }}</td>
                                <td class="py-3">{{ $usage->voucher->duration_minutes }} menit</td>
                                <td class="py-3 text-end">
                                    @if($isExpired)
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger py-2 px-3">
                                        <i class="fas fa-hourglass-end me-1"></i>Kedaluwarsa
                                    </span>
                                    @else
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success py-2 px-3">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .history-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .card {
        border-radius: 16px;
        overflow: hidden;
        border: none;
    }
    
    .table {
        --bs-table-hover-bg: rgba(67, 97, 238, 0.03);
    }
    
    .table th {
        letter-spacing: 0.5px;
    }
    
    .table tr {
        transition: all 0.2s ease;
    }
    
    .table tr:hover {
        transform: translateX(2px);
    }
    
    .badge {
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-outline-primary {
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background-color: #4361ee;
        color: white !important;
    }
    
    .empty-state {
        transition: all 0.3s ease;
    }
    
    .empty-state:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
    }
    
    .icon-wrapper {
        transition: transform 0.3s ease;
    }
    
    .empty-state:hover .icon-wrapper {
        transform: scale(1.1);
    }
    
    @media (max-width: 768px) {
        .history-container {
            padding: 0 15px;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .empty-state {
            padding: 2rem !important;
        }
    }
</style>
@endsection