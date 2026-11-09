@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="card card-elevated">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Penggunaan</h3>
                    <p class="mb-0 opacity-75">Daftar penggunaan voucher oleh pengguna</p>
                </div>
                <button class="btn btn-light btn-rounded" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Cari riwayat...">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-list me-1"></i> Total: {{ $histories->total() }} Riwayat
                    </span>
                </div>
            </div>

            <div class="table-responsive rounded-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Pengguna</th>
                            <th>Voucher</th>
                            <th>Waktu Mulai</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                        <tr class="history-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <span>{{ strtoupper(substr($history->user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $history->user->name }}</h6>
                                        <small class="text-muted">{{ $history->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="voucher-badge">
                                    <i class="fas fa-ticket-alt me-2"></i>
                                    <code>{{ $history->voucher->code }}</code>
                                </span>
                            </td>
                            <td>
                                <span class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $history->start_time->format('d M Y H:i:s') }}">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $history->start_time->format('H:i') }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $history->created_at->format('d M Y') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    {{ $histories->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>

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
    
    /* Avatar Circle */
    .avatar-circle {
        width: 36px;
        height: 36px;
        background-color: #3a7bd5;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    /* Voucher Badge */
    .voucher-badge {
        display: inline-flex;
        align-items: center;
        background-color: #f8f9fa;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
    }
    
    code {
        font-family: monospace;
        background: transparent;
        padding: 0;
        color: #495057;
        font-weight: 500;
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
    
    /* Pagination */
    .pagination .page-item.active .page-link {
        background-color: #3a7bd5;
        border-color: #3a7bd5;
    }
    
    .pagination .page-link {
        color: #3a7bd5;
    }
</style>
@endpush

@push('scripts')
@if(request()->anyFilled(['start_date', 'end_date', 'user_id', 'voucher_id']))
<script>
    $(document).ready(function(){
        $('#filterModal').modal('show');
    });
</script>
@endif

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