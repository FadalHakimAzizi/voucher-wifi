@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="card card-elevated">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><i class="fas fa-percentage me-2"></i>Manajemen Promosi</h3>
                    <p class="mb-0 opacity-75">Kelola semua promosi dan diskon yang tersedia</p>
                </div>
                <button class="btn btn-light btn-rounded" data-bs-toggle="modal" data-bs-target="#addPromotionModal">
                    <i class="fas fa-plus me-2"></i> Tambah Promosi
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Cari promosi...">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-tags me-1"></i> Total: {{ count($promotions) }} Promosi
                    </span>
                </div>
            </div>

            <div class="table-responsive rounded-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Promosi</th>
                            <th>Tipe</th>
                            <th>Nilai</th>
                            <th>Min. Quantity</th>
                            <th>Periode</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promotion)
                        @php
                            $today = \Carbon\Carbon::today();
                            $isActive = $today->between($promotion->start_date, $promotion->end_date);
                        @endphp
                        <tr class="promotion-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="promotion-icon me-3 bg-{{ $isActive ? 'success' : 'secondary' }}">
                                        <i class="fas fa-{{ $promotion->type === 'discount' ? 'tag' : 'ticket-alt' }}"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $promotion->name }}</h6>
                                        <small class="text-muted">
                                            @if($isActive)
                                                <span class="text-success">Aktif</span>
                                            @elseif($today->lt($promotion->start_date))
                                                <span class="text-info">Akan datang</span>
                                            @else
                                                <span class="text-danger">Kadaluarsa</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $promotion->type === 'discount' ? 'success' : 'info' }}">
                                    <i class="fas fa-{{ $promotion->type === 'discount' ? 'percent' : 'ticket-alt' }} me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $promotion->type)) }}
                                </span>
                            </td>
                            <td>
                                @if($promotion->type === 'discount')
                                <span class="text-success fw-bold">
                                    {{ $promotion->value }}%
                                </span>
                                @else
                                <span class="text-primary fw-bold">
                                    Rp {{ number_format($promotion->value, 0, ',', '.') }}
                                </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-boxes me-1"></i>
                                    {{ $promotion->min_quantity }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $promotion->start_date->format('d M Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-times me-1"></i>
                                        {{ $promotion->end_date->format('d M Y') }}
                                    </small>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-warning rounded-pill me-2" data-bs-toggle="modal" data-bs-target="#editPromotionModal{{ $promotion->id }}">
                                        <i class="fas fa-pencil-alt me-1"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Yakin ingin menghapus promosi ini?')">
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
    </div>
</div>

<!-- Add Promotion Modal -->
<div class="modal fade" id="addPromotionModal" tabindex="-1" aria-labelledby="addPromotionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="addPromotionModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Promosi Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.promotions.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Promosi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" name="name" required placeholder="Nama promosi">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Promosi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            <select class="form-select" name="type" id="typeSelect">
                                <option value="discount">Diskon</option>
                                <option value="free_voucher">Voucher Gratis</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" id="valueLabel">Nilai Diskon (%)</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-{{ $promotion->type === 'discount' ? 'percent' : 'money-bill-wave' }}"></i>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="value" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Minimum Quantity</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                            <input type="number" class="form-control" name="min_quantity" value="1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Berakhir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-times"></i></span>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
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

<!-- Edit Promotion Modals -->
@foreach($promotions as $promotion)
<div class="modal fade" id="editPromotionModal{{ $promotion->id }}" tabindex="-1" aria-labelledby="editPromotionModalLabel{{ $promotion->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-warning text-white">
                <h5 class="modal-title" id="editPromotionModalLabel{{ $promotion->id }}">
                    <i class="fas fa-edit me-2"></i>Edit Promosi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.promotions.update', $promotion->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Promosi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" name="name" value="{{ $promotion->name }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Promosi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            <select class="form-select" name="type" id="typeSelect{{ $promotion->id }}">
                                <option value="discount" {{ $promotion->type === 'discount' ? 'selected' : '' }}>Diskon</option>
                                <option value="free_voucher" {{ $promotion->type === 'free_voucher' ? 'selected' : '' }}>Voucher Gratis</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-{{ $promotion->type === 'discount' ? 'percent' : 'money-bill-wave' }}"></i>
                            </span>
                            <input type="number" step="0.01" class="form-control" name="value" value="{{ $promotion->value }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Minimum Quantity</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                            <input type="number" class="form-control" name="min_quantity" value="{{ $promotion->min_quantity }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                <input type="date" class="form-control" name="start_date" value="{{ $promotion->start_date->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Berakhir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-times"></i></span>
                                <input type="date" class="form-control" name="end_date" value="{{ $promotion->end_date->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill">
                        <i class="fas fa-sync-alt me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

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
    
    /* Promotion Icon */
    .promotion-icon {
        width: 36px;
        height: 36px;
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
    
    /* Form Styles */
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    // Dynamic label change based on promotion type
    document.getElementById('typeSelect').addEventListener('change', function() {
        const valueLabel = document.getElementById('valueLabel');
        const icon = this.parentNode.querySelector('i');
        if(this.value === 'discount') {
            valueLabel.textContent = 'Nilai Diskon (%)';
            icon.className = 'fas fa-percent';
        } else {
            valueLabel.textContent = 'Nilai Voucher';
            icon.className = 'fas fa-money-bill-wave';
        }
    });

    // Initialize same functionality for edit modals
    @foreach($promotions as $promotion)
    document.getElementById('typeSelect{{ $promotion->id }}').addEventListener('change', function() {
        const icon = this.parentNode.querySelector('i');
        if(this.value === 'discount') {
            icon.className = 'fas fa-percent';
        } else {
            icon.className = 'fas fa-money-bill-wave';
        }
    });
    @endforeach
</script>
@endpush