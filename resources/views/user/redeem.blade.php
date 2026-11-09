@extends('layouts.user')

@section('title', 'Tebus Voucher Fenyxz WiFi')

@section('content')
<div class="redeem-container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 animate__animated animate__fadeIn" style="box-shadow: 0 10px 30px rgba(67, 97, 238, 0.15);">
                <div class="card-header py-4 text-center text-white" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-gift fa-2x me-3"></i>
                        <h2 class="h3 mb-0 fw-bold">Tebus Voucher WiFi</h2>
                    </div>
                </div>
                
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('user.redeem.process') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="mb-5 text-center">
                            <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-4">
                                <i class="fas fa-ticket-alt fa-3x text-primary"></i>
                            </div>
                            <h3 class="h4 mb-3">Mulai Internet Cepat Anda</h3>
                            <p class="text-muted">Masukkan kode voucher untuk menikmati akses internet berkecepatan tinggi</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="code" class="form-label fw-bold mb-3">Kode Voucher</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-primary"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg border-start-0 py-3" 
                                       id="code" name="code" 
                                       value="{{ old('code', request()->get('code')) }}" 
                                       placeholder="Masukkan digit kode voucher" 
                                       required
                                       style="letter-spacing: 1px;">
                                <div class="invalid-feedback fw-medium">
                                    <i class="fas fa-exclamation-circle me-2"></i>Harap masukkan kode voucher yang valid
                                </div>
                            </div>
                            <div class="form-text mt-2 text-end">
                                <i class="fas fa-lightbulb me-2 text-warning"></i>Kode biasanya terdapat di belakang voucher
                            </div>
                        </div>
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4 d-flex align-items-center" role="alert" style="border-left: 4px solid #dc3545;">
                                <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                                <div>
                                    {{ session('error') }}
                                </div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4 d-flex align-items-center" role="alert" style="border-left: 4px solid #28a745;">
                                <i class="fas fa-check-circle fa-lg me-3"></i>
                                <div>
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg py-3 rounded-pill fw-bold" style="box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);">
                                <i class="fas fa-check-circle me-2"></i>Tebus Voucher Sekarang
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light py-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-info-circle me-3 text-primary"></i>
                        <p class="mb-0 small text-muted">
                            Pastikan Anda terhubung ke jaringan <strong>Fenyxz WiFi</strong> sebelum menebus voucher
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .redeem-container {
        max-width: 900px;
        margin: 0 auto;
        min-height: calc(100vh - 120px);
        display: relative;
        align-items: center;
    }
    
    .card {
        border-radius: 16px;
        overflow: hidden;
        border: none;
    }
    
    .form-control-lg {
        padding: 1rem 1.25rem;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .form-control-lg:focus {
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        border-color: #4361ee;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    
    .icon-wrapper {
        transition: transform 0.3s ease;
    }
    
    .btn-primary {
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(67, 97, 238, 0.4) !important;
    }
    
    .alert {
        border-radius: 8px;
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .redeem-container {
            padding: 1.5rem;
        }
    }
</style>

<script>
    // Form validation
    (function() {
        'use strict'
        
        const forms = document.querySelectorAll('.needs-validation')
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
    })();

    // Auto-fill code from URL parameter
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const code = urlParams.get('code');
        if (code) {
            document.getElementById('code').value = code;
            document.getElementById('code').focus();
        }
    });
</script>
@endsection