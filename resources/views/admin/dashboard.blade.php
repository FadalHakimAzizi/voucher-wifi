@extends('layouts.admin')

@section('content')
<style>
    :root {
        --primary: #4a6bff;
        --primary-light: #6a8bff;
        --primary-dark: #2a4bdf;
        --secondary: #ff7e5f;
        --secondary-light: #ff9e7f;
        --success: #28a745;
        --success-light: #48c765;
        --info: #17a2b8;
        --warning: #ffc107;
        --warning-light: #ffe107;
        --danger: #dc3545;
        --danger-light: #fc5565;
        --light: #f8f9fa;
        --dark: #343a40;
        --gray: #6c757d;
        --gray-light: #e9ecef;
    }

    .voucher-dashboard {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 20px; /* Reduced padding for better control */
        overflow-x: hidden;
    }

    .stat-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
        z-index: 1;
        padding: 25px;
        text-align: center;
        height: 200px; /* Fixed height to prevent stretching */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: rgba(255,255,255,0.5);
    }

    .stat-card.primary { 
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); 
        color: white; 
    }
    .stat-card.success { 
        background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%); 
        color: white; 
    }
    .stat-card.danger { 
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-light) 100%); 
        color: white; 
    }

    .stat-icon {
        font-size: 3rem;
        opacity: 0.9;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
    }

    .stat-value {
        font-size: 2.2rem; /* Reduced for better fit */
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: -1px;
    }

    .stat-label {
        font-size: 1rem; /* Reduced for better fit */
        opacity: 0.9;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .chart-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-light);
        height: 400px; /* Fixed height to prevent stretching */
        position: relative;
    }

    .chart-container:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 1.3rem; /* Adjusted for consistency */
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
    }

    .chart-title i {
        margin-right: 10px;
        color: var(--primary);
    }

    .chart-period {
        background: var(--gray-light);
        border-radius: 20px;
        padding: 5px 12px; /* Reduced padding */
        font-size: 0.85rem; /* Reduced for better fit */
        font-weight: 500;
        color: var(--gray);
    }

    .voucher-table {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid var(--gray-light);
        max-height: 400px; /* Limit table height */
        overflow-y: auto;
    }

    .table thead th {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 16px 20px; /* Reduced padding */
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem; /* Adjusted for mobile */
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(74, 107, 255, 0.03);
        transform: translateX(5px);
    }

    .table tbody td {
        padding: 14px 20px; /* Reduced padding */
        vertical-align: middle;
        border-color: var(--gray-light);
    }

    .badge-voucher {
        padding: 6px 12px; /* Reduced padding */
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem; /* Adjusted for better fit */
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .badge-voucher i {
        margin-right: 5px;
        font-size: 0.75rem; /* Adjusted for consistency */
    }

    .badge-active { 
        background: rgba(40, 167, 69, 0.15); 
        color: var(--success); 
    }
    .badge-expired { 
        background: rgba(220, 53, 69, 0.15); 
        color: var(--danger); 
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-card {
        animation: fadeIn 0.6s ease-out forwards;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .voucher-dashboard {
            padding: 15px;
        }
        
        .stat-card {
            padding: 15px;
            height: 180px;
        }
        
        .stat-value {
            font-size: 1.8rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
        }
        
        .chart-container {
            height: 350px;
            padding: 15px;
        }
        
        .chart-title {
            font-size: 1.1rem;
        }
        
        .chart-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .chart-period {
            margin-top: 10px;
        }
        
        .voucher-table {
            max-height: 300px;
        }
        
        .table thead th,
        .table tbody td {
            padding: 12px 15px;
            font-size: 0.75rem;
        }
        
        .badge-voucher {
            padding: 4px 10px;
            font-size: 0.7rem;
        }
    }
</style>

<div class="voucher-dashboard">
    <div class="row">
        <!-- Stat Cards -->
        <div class="col-md-6 col-lg-4 mb-4 animate-card" style="animation-delay: 0.1s">
            <div class="stat-card primary text-center">
                <i class="stat-icon fas fa-ticket-alt"></i>
                <h3 class="stat-value">{{ $totalVouchers }}</h3>
                <p class="stat-label text-white">Total Voucher</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 animate-card" style="animation-delay: 0.2s">
            <div class="stat-card success text-center">
                <i class="stat-icon fas fa-check-circle"></i>
                <h3 class="stat-value">{{ $activeVouchers }}</h3>
                <p class="stat-label text-white">Voucher Aktif</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 animate-card" style="animation-delay: 0.3s">
            <div class="stat-card danger text-center">
                <i class="stat-icon fas fa-times-circle"></i>
                <h3 class="stat-value">{{ $expiredVouchers }}</h3>
                <p class="stat-label text-white">Kadaluarsa</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Chart -->
        <div class="col-lg-8 mb-4">
            <div class="chart-container animate-card" style="animation-delay: 0.4s">
                <div class="chart-header">
                    <h5 class="chart-title"><i class="fas fa-chart-line"></i>Penggunaan Voucher 30 Hari Terakhir</h5>
                    <span class="chart-period">Last 30 Days</span>
                </div>
                <div style="height: 300px;">
                    <canvas id="voucherUsageChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-4 mb-4">
            <div class="chart-container animate-card" style="animation-delay: 0.5s">
                <div class="chart-header">
                    <h5 class="chart-title"><i class="fas fa-chart-pie"></i>Distribusi Voucher</h5>
                    <span class="chart-period">All Time</span>
                </div>
                <div style="height: 300px;">
                    <canvas id="voucherDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Vouchers Table -->
    <div class="row">
        <div class="col-12 animate-card" style="animation-delay: 0.6s">
            <div class="voucher-table">
                <div class="chart-header p-4">
                    <h5 class="chart-title mb-0"><i class="fas fa-list"></i> Voucher Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Paket</th>
                                <th>Pembuat</th>
                                <th>Status</th>
                                <th>Digunakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentVouchers as $voucher)
                            <tr>
                                <td><strong class="text-primary">{{ $voucher->code }}</strong></td>
                                <td>{{ $voucher->duration_minutes }} Menit (Rp {{ number_format($voucher->price, 0, ',', '.') }})</td>
                                <td>{{ $voucher->creator ? $voucher->creator->name : 'Admin' }}</td>
                                <td>
                                    @if($voucher->is_redeemed)
                                        <span class="badge-voucher badge-expired"><i class="fas fa-check-circle"></i> Diredeem</span>
                                    @elseif($voucher->expires_at && now()->greaterThan($voucher->expires_at))
                                        <span class="badge-voucher badge-expired"><i class="fas fa-clock"></i> Kadaluarsa</span>
                                    @else
                                        <span class="badge-voucher badge-active"><i class="fas fa-bolt"></i> Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $voucher->usage_count ?? 0 }}/{{ $voucher->max_usage ?? 'Unlimited' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Voucher Usage Chart (Line)
    const usageCtx = document.getElementById('voucherUsageChart').getContext('2d');
    new Chart(usageCtx, {
        type: 'line',
        data: {
            labels: @json($usageChartLabels),
            datasets: [{
                label: 'Voucher Dibuat',
                data: @json($usageChartCreated),
                borderColor: '#4a6bff',
                backgroundColor: 'rgba(74, 107, 255, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#4a6bff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }, {
                label: 'Voucher Digunakan',
                data: @json($usageChartUsed),
                borderColor: '#ff7e5f',
                backgroundColor: 'rgba(255, 126, 95, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#ff7e5f',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'top',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: { 
                    mode: 'index', 
                    intersect: false,
                    backgroundColor: '#0f172a',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 12
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Voucher Distribution Chart (Doughnut)
    const distCtx = document.getElementById('voucherDistributionChart').getContext('2d');
    new Chart(distCtx, {
        type: 'doughnut',
        data: {
            labels: @json($distributionLabels),
            datasets: [{
                data: @json($distributionData),
                backgroundColor: ['#4a6bff', '#ff7e5f', '#28a745', '#ffc107'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'right',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 12,
                    callbacks: { 
                        label: function(context) { 
                            return `${context.label}: ${context.raw}%`; 
                        } 
                    }
                }
            },
            cutout: '75%'
        }
    });
});
</script>
@endsection