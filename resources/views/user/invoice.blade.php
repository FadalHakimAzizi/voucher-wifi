@extends('layouts.user')

@section('title', 'Invoice Fenyxz WiFi')

@section('content')
<div class="invoice-container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 animate__animated animate__fadeIn" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-invoice fa-lg me-3"></i>
                            <h2 class="h5 mb-0 fw-bold">Invoice Pembelian</h2>
                        </div>
                        <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-medium">#{{ $purchase->id }}</span>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <!-- Company Info -->
                    <div class="text-center mb-5">
                        <div class="logo-wrapper d-inline-block p-3 mb-3" style="background-color: #f8f9fa; border-radius: 12px;">
                            <img src="https://via.placeholder.com/180x60?text=Fenyxz+WiFi" alt="Fenyxz WiFi" style="height: 50px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                        </div>
                        <h3 class="h4 fw-bold mb-2">Fenyxz WiFi Voucher</h3>
                        <p class="text-muted mb-0">Internet Cepat dan Stabil 24 Jam</p>
                    </div>
                    
                    <hr class="my-4" style="border-top: 2px dashed #e9ecef;">
                    
                    <!-- Invoice Info -->
                    <div class="row mb-5 g-3">
                        <div class="col-md-6">
                            <div class="p-4 rounded-3" style="background-color: #f8f9fa;">
                                <h4 class="h6 fw-bold text-primary mb-3"><i class="fas fa-user-circle me-2"></i>Detail Pelanggan</h4>
                                <p class="mb-2"><strong>{{ Auth::user()->name }}</strong></p>
                                <p class="mb-2 text-muted"><i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}</p>
                                <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3" style="background-color: #f8f9fa;">
                                <h4 class="h6 fw-bold text-primary mb-3"><i class="fas fa-receipt me-2"></i>Detail Transaksi</h4>
                                <p class="mb-2"><strong>Status:</strong> <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Berhasil</span></p>
                                <p class="mb-2 text-muted"><i class="fas fa-clock me-2"></i>{{ \Carbon\Carbon::parse($purchase->transaction_date)->format('d M Y H:i') }}</p>
                                <p class="mb-0 text-muted"><i class="fas fa-credit-card me-2"></i>{{ $purchase->payment_method }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Voucher Details -->
                    <div class="table-responsive mb-5">
                        <table class="table">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="py-3 text-uppercase small fw-bold text-muted border-0">Deskripsi</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted border-0 text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-ticket-alt text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>Voucher WiFi {{ $purchase->voucher->duration_minutes }} menit</strong>
                                                <div class="text-muted small mt-1">Kode: <span class="fw-bold">{{ $purchase->voucher->code }}</span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-end fw-bold">Rp{{ number_format($purchase->amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-end border-0"><h5 class="fw-bold mb-0">Total</h5></td>
                                    <td class="py-3 text-end border-0"><h5 class="fw-bold text-primary mb-0">Rp{{ number_format($purchase->amount, 0, ',', '.') }}</h5></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Payment Info -->
                    <div class="alert alert-info border-0 rounded-3" style="background-color: #e6f7ff; border-left: 4px solid #1890ff;">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="fas fa-info-circle fa-2x text-info mt-1"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading fw-bold mb-2">Instruksi Penggunaan</h5>
                                <ol class="mb-0 ps-3">
                                    <li class="mb-2">Hubungkan ke jaringan WiFi <strong class="text-primary">Fenyxz</strong></li>
                                    <li class="mb-2">Buka browser dan masukkan kode voucher</li>
                                    <li>Nikmati internet cepat selama <strong class="text-primary">{{ $purchase->voucher->duration_minutes }} menit</strong></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-column flex-md-row justify-content-between mt-5 gap-3">
                        <a href="{{ route('user.history') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
                        </a>
                        <button class="btn btn-primary rounded-pill px-4 py-2" onclick="window.print()" style="box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);">
                            <i class="fas fa-print me-2"></i>Cetak Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .invoice-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .card {
        border-radius: 16px;
        overflow: hidden;
        border: none;
    }
    
    .table {
        --bs-table-hover-bg: transparent;
    }
    
    .table th {
        letter-spacing: 0.5px;
    }
    
    .badge {
        font-weight: 500;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
    
    .btn-primary {
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }
    
    .btn-primary:hover {
        box-shadow: 0 7px 20px rgba(67, 97, 238, 0.4);
    }
    
    .alert {
        border-left-width: 4px;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-container, .invoice-container * {
            visibility: visible;
        }
        .invoice-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
        }
        .btn {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }
    
    @media (max-width: 768px) {
        .invoice-container {
            padding: 15px;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .logo-wrapper {
            padding: 1rem !important;
        }
    }
</style>
@endsection