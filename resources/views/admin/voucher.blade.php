@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Notification Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-elevated fade show">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-3"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-elevated fade show">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-3"></i>
            <div>
                <ul class="mb-0 ps-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Voucher List -->
    @if(isset($vouchers))
    <div class="card card-elevated">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Manajemen Voucher</h3>
                    <p class="mb-0 opacity-75">Kelola semua voucher yang tersedia</p>
                </div>
                <button class="btn btn-light btn-rounded" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
                    <i class="fas fa-plus me-2"></i>Tambah Voucher
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Cari voucher...">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    <span class="badge bg-light text-dark me-2">
                        <i class="fas fa-ticket-alt me-1"></i> Total: {{ count($vouchers) }} Voucher
                    </span>
                </div>
            </div>

            <div class="table-responsive rounded-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Kode Voucher</th>
                            <th>Durasi</th>
                            <th>Harga</th>
                            <th>Promo</th>
                            <th>Kadaluarsa</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vouchers as $voucher)
                        <tr class="voucher-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="voucher-icon me-3">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block">{{ $voucher->code }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $voucher->duration_minutes }} menit
                                </span>
                            </td>
                            <td>
                                <span class="text-success fw-bold">
                                    <i class="fas fa-tag me-1"></i>
                                    Rp {{ number_format($voucher->price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                @if($voucher->promo)
                                <span class="badge bg-purple">
                                    <i class="fas fa-percentage me-1"></i>
                                    {{ $voucher->promo->name }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($voucher->expires_at)
                                <span class="text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $voucher->expires_at->format('d M Y H:i:s') }}">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $voucher->expires_at->format('d M Y') }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($voucher->is_redeemed)
                                    <span class="badge bg-danger">
                                        <i class="fas fa-check-circle me-1"></i> Diredeem
                                    </span>
                                @elseif($voucher->expires_at && \Carbon\Carbon::now()->greaterThan($voucher->expires_at))
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-exclamation-circle me-1"></i> Kadaluarsa
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <!-- Detail Button -->
                                    <button class="btn btn-sm btn-outline-warning rounded-pill me-2" data-bs-toggle="modal" data-bs-target="#detailVoucherModal{{ $voucher->id }}">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-outline-primary rounded-pill me-2" data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $voucher->id }}">
                                        <i class="fas fa-pencil-alt me-1"></i> Edit
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Yakin ingin menghapus voucher ini?')">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <!-- Pagination would go here -->
        </div>
    </div>

    <!-- Add Voucher Modal -->
    <div class="modal fade" id="addVoucherModal" tabindex="-1" aria-labelledby="addVoucherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="addVoucherModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Voucher Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.vouchers.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode Voucher</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}" required placeholder="Masukkan kode voucher">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Durasi (menit)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                <input type="number" class="form-control" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1" required placeholder="Durasi dalam menit">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="price" value="{{ old('price') }}" min="0" required placeholder="Harga voucher">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Promo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                <select class="form-select" name="promo_id">
                                    <option value="">Tanpa Promo</option>
                                    @foreach($promotions as $promo)
                                    <option value="{{ $promo->id }}" {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kadaluarsa</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                <input type="datetime-local" class="form-control" name="expires_at" value="{{ old('expires_at') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Detail Voucher Modals -->
    @foreach($vouchers as $voucher)
    <div class="modal fade" id="detailVoucherModal{{ $voucher->id }}" tabindex="-1" aria-labelledby="detailVoucherModalLabel{{ $voucher->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-gradient-warning text-white">
                    <h5 class="modal-title" id="detailVoucherModalLabel{{ $voucher->id }}">
                        <i class="fas fa-info-circle me-2"></i>Detail Voucher: {{ $voucher->code }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="voucher-detail-card mb-4">
                        <div class="voucher-code">{{ $voucher->code }}</div>
                        <div class="voucher-status">
                            @if($voucher->is_redeemed)
                                <span class="badge bg-danger">Diredeem</span>
                            @elseif($voucher->expires_at && \Carbon\Carbon::now()->greaterThan($voucher->expires_at))
                                <span class="badge bg-warning text-dark">Kadaluarsa</span>
                            @else
                                <span class="badge bg-success">Tersedia</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="voucher-details">
                        <div class="detail-item">
                            <i class="fas fa-clock text-primary"></i>
                            <div>
                                <span class="detail-label">Durasi</span>
                                <span class="detail-value">{{ $voucher->duration_minutes }} menit</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tag text-success"></i>
                            <div>
                                <span class="detail-label">Harga</span>
                                <span class="detail-value">Rp {{ number_format($voucher->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-percentage text-purple"></i>
                            <div>
                                <span class="detail-label">Promo</span>
                                <span class="detail-value">{{ $voucher->promo ? $voucher->promo->name : '-' }}</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="far fa-calendar-alt text-info"></i>
                            <div>
                                <span class="detail-label">Kadaluarsa</span>
                                <span class="detail-value">{{ $voucher->expires_at ? $voucher->expires_at->format('d M Y H:i') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Edit Voucher Modals -->
    @foreach($vouchers as $voucher)
    <div class="modal fade" id="editVoucherModal{{ $voucher->id }}" tabindex="-1" aria-labelledby="editVoucherModalLabel{{ $voucher->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="editVoucherModalLabel{{ $voucher->id }}">
                        <i class="fas fa-edit me-2"></i>Edit Voucher
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.vouchers.update', $voucher->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode Voucher</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
                                <input type="text" class="form-control" name="code" value="{{ old('code', $voucher->code) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Durasi (menit)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                <input type="number" class="form-control" name="duration_minutes" value="{{ old('duration_minutes', $voucher->duration_minutes) }}" min="1" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="price" value="{{ old('price', $voucher->price) }}" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Promo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                <select class="form-select" name="promo_id">
                                    <option value="">Tanpa Promo</option>
                                    @foreach($promotions as $promo)
                                    <option value="{{ $promo->id }}" {{ old('promo_id', $voucher->promo_id) == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kadaluarsa</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                <input type="datetime-local" class="form-control" name="expires_at" value="{{ old('expires_at', optional($voucher->expires_at)->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Redeem</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                <select class="form-select" name="is_redeemed">
                                    <option value="0" {{ old('is_redeemed', $voucher->is_redeemed) == 0 ? 'selected' : '' }}>Tersedia</option>
                                    <option value="1" {{ old('is_redeemed', $voucher->is_redeemed) == 1 ? 'selected' : '' }}>Diredeem</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

@push('styles')
<style>
    /* Card Styles */
    .card-elevated {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header.bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }
    
    .card-header.bg-gradient-warning {
        background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
    }
    
    /* Alert Styles */
    .alert-elevated {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
    }
    
    /* Search Box */
    .search-box {
        position: relative;
    }
    
    .search-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 4;
    }
    
    .search-input {
        padding-left: 40px;
        border-radius: 50px;
        border: 1px solid #e0e0e0;
        height: 44px;
    }
    
    /* Table Styles */
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        border-bottom: 2px solid #f0f0f0;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .table tbody tr:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    /* Voucher Icon */
    .voucher-icon {
        width: 36px;
        height: 36px;
        background-color: #3a7bd5;
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Badge Styles */
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
        border-radius: 50px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
    }
    
    .bg-purple {
        background-color: #6f42c1;
        color: white;
    }
    
    /* Button Styles */
    .btn-rounded {
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
    }
    
    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .modal-header {
        padding: 1.25rem 1.5rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        padding: 1rem 1.5rem;
        background-color: #f8f9fa;
    }
    
    /* Voucher Detail Card */
    .voucher-detail-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
        border: 1px dashed #dee2e6;
    }
    
    .voucher-code {
        font-size: 1.5rem;
        font-weight: bold;
        color: #3a7bd5;
        margin-bottom: 0.5rem;
    }
    
    /* Detail Items */
    .voucher-details {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .detail-item i {
        font-size: 1.25rem;
        margin-right: 1rem;
        width: 30px;
        text-align: center;
    }
    
    .detail-label {
        display: block;
        font-weight: 500;
        color: #6c757d;
        font-size: 0.85rem;
    }
    
    .detail-value {
        display: block;
        font-weight: 600;
        color: #495057;
    }
    
    /* Form Styles */
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    /* Tooltip */
    [data-bs-toggle="tooltip"] {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection