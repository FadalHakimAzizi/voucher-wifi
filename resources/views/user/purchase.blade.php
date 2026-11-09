@extends('layouts.user')

@section('title', 'Pembelian Voucher Fenyxz WiFi')

@section('content')
<div class="purchase-container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 animate__animated animate__fadeIn" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shopping-cart fa-lg me-3"></i>
                        <h2 class="h4 mb-0 fw-bold">Pembelian Voucher WiFi</h2>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <!-- Voucher Details -->
                    <div class="voucher-detail-card mb-5 p-4 rounded-3" style="background-color: #f8fafc; border: 1px solid rgba(67, 97, 238, 0.1);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="h5 mb-0 text-primary fw-bold">
                                <i class="fas fa-wifi me-2"></i>Paket Internet
                            </h3>
                            <span class="badge rounded-pill py-2 px-3" style="background: linear-gradient(135deg, #2b9348 0%, #007f5f 100%);">
                                {{ $voucher->duration_minutes }} Menit
                            </span>
                        </div>
                        
                        <div class="voucher-price text-center my-4">
                            <span class="text-muted small">Hanya</span>
                            <h2 class="display-4 fw-bold text-primary my-2" style="letter-spacing: -1px;">
                                Rp{{ number_format($voucher->price, 0, ',', '.') }}
                            </h2>
                            <small class="text-muted">Termasuk semua pajak</small>
                        </div>
                        
                        <ul class="list-group list-group-flush mb-3 rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3" style="background-color: rgba(255, 255, 255, 0.7);">
                                <span class="d-flex align-items-center">
                                    <div class="icon-sm-wrapper bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-bolt text-warning"></i>
                                    </div>
                                    Kecepatan hingga 100Mbps
                                </span>
                                <i class="fas fa-check-circle text-success"></i>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3" style="background-color: rgba(255, 255, 255, 0.7);">
                                <span class="d-flex align-items-center">
                                    <div class="icon-sm-wrapper bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-clock text-info"></i>
                                    </div>
                                    Akses 24 Jam Nonstop
                                </span>
                                <i class="fas fa-check-circle text-success"></i>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3" style="background-color: rgba(255, 255, 255, 0.7);">
                                <span class="d-flex align-items-center">
                                    <div class="icon-sm-wrapper bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-shield-alt text-success"></i>
                                    </div>
                                    Koneksi Aman & Terenkripsi
                                </span>
                                <i class="fas fa-check-circle text-success"></i>
                            </li>
                        </ul>
                        
                        @if ($voucher->promo)
                        <div class="promo-banner mt-3 p-3 rounded-3 text-center animate__animated animate__pulse animate__infinite" 
                             style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); border: 1px dashed rgba(255, 255, 255, 0.3);">
                            <h4 class="h6 mb-1 text-white fw-bold"><i class="fas fa-gift me-2"></i>PROMO SPESIAL!</h4>
                            <p class="mb-0 fw-bold text-white">
                                @if($voucher->promo->type === 'discount')
                                    Dapatkan diskon {{ $voucher->promo->value }}%!
                                @else
                                    GRATIS {{ $voucher->promo->value }} menit tambahan!
                                @endif
                            </p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Payment Form -->
                    <form method="POST" action="{{ route('user.purchase.process', $voucher->id) }}" class="needs-validation" novalidate id="paymentForm">
                        @csrf
                        
                        <h4 class="h5 mb-4 text-primary fw-bold">
                            <i class="fas fa-credit-card me-2"></i>Pilih Metode Pembayaran
                        </h4>
                        
                        <div class="payment-methods mb-5">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="payment_method" id="bank_transfer" value="bank_transfer" autocomplete="off" required>
                                    <label class="btn btn-outline-primary w-100 py-3 rounded-3" for="bank_transfer">
                                        <div class="payment-icon mb-3">
                                            <i class="fas fa-university fa-2x"></i>
                                        </div>
                                        <span class="fw-medium">Transfer Bank</span>
                                    </label>
                                </div>
                                
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="payment_method" id="qris" value="qris" autocomplete="off" required>
                                    <label class="btn btn-outline-primary w-100 py-3 rounded-3" for="qris">
                                        <div class="payment-icon mb-3">
                                            <i class="fas fa-qrcode fa-2x"></i>
                                        </div>
                                        <span class="fw-medium">QRIS</span>
                                    </label>
                                </div>
                                
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="payment_method" id="ewallet" value="ewallet" autocomplete="off" required>
                                    <label class="btn btn-outline-primary w-100 py-3 rounded-3" for="ewallet">
                                        <div class="payment-icon mb-3">
                                            <i class="fas fa-wallet fa-2x"></i>
                                        </div>
                                        <span class="fw-medium">E-Wallet</span>
                                    </label>
                                </div>
                            </div>
                            
                            @error('payment_method')
                                <div class="invalid-feedback d-block mt-2 fw-medium">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg py-3 rounded-pill fw-bold" style="box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
                                <i class="fas fa-lock me-2"></i>Bayar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light py-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-shield-alt text-primary me-3"></i>
                        <small class="text-muted">
                            Transaksi Anda aman dan terenkripsi dengan teknologi SSL
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .purchase-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .card {
        border-radius: 16px;
        overflow: hidden;
        border: none;
    }
    
    .voucher-detail-card {
        transition: all 0.3s ease;
    }
    
    .voucher-detail-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .display-4 {
        font-size: 2.75rem;
    }
    
    .list-group-item {
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(67, 97, 238, 0.03) !important;
    }
    
    .icon-sm-wrapper {
        width: 32px;
        height: 32px;
    }
    
    .payment-icon {
        transition: all 0.3s ease;
    }
    
    .btn-check:checked + .btn-outline-primary {
        background-color: rgba(67, 97, 238, 0.05);
        border-color: #4361ee;
        font-weight: 600;
    }
    
    .btn-outline-primary {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }
    
    .btn-outline-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.1);
    }
    
    .btn-check:checked + .btn-outline-primary .payment-icon {
        transform: scale(1.1);
    }
    
    .btn-success {
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        border: none;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(40, 167, 69, 0.4) !important;
    }
    
    .promo-banner {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    @media (max-width: 768px) {
        .purchase-container {
            padding: 0 15px;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .payment-methods .col-md-4 {
            margin-bottom: 1rem;
        }
    }
</style>

<script>
    // Form validation
    (function() {
        'use strict';
        
        const form = document.getElementById('paymentForm');
        
        form.addEventListener('submit', event => {
            const paymentMethod = form.querySelector('input[name="payment_method"]:checked');
            
            if (!paymentMethod) {
                event.preventDefault();
                event.stopPropagation();
                const errorMessage = form.querySelector('.payment-methods .invalid-feedback');
                if (!errorMessage) {
                    form.querySelector('.payment-methods').insertAdjacentHTML('beforeend', 
                        '<div class="invalid-feedback d-block mt-2 fw-medium"><i class="fas fa-exclamation-circle me-2"></i>Pilih metode pembayaran terlebih dahulu.</div>'
                    );
                }
            }
            
            form.classList.add('was-validated');
        }, false);

        // Remove error message when a payment method is selected
        document.querySelectorAll('.btn-check').forEach(radio => {
            radio.addEventListener('change', function() {
                const errorMessage = document.querySelector('.payment-methods .invalid-feedback');
                if (errorMessage) {
                    errorMessage.remove();
                }

                const label = document.querySelector(`label[for="${this.id}"]`);
                label.classList.add('animate__animated', 'animate__pulse');
                
                setTimeout(() => {
                    label.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            });
        });
    })();
</script>
@endsection