@extends('layouts.admin')

     @section('content')
     <div class="container-fluid px-4">
         <div class="card card-elevated" style="max-height: 90vh; overflow-y: auto;">
             <div class="card-header bg-gradient-primary text-white">
                 <div class="d-flex justify-content-between align-items-center">
                     <div>
                         <h3 class="mb-0"><i class="fas fa-chart-line me-2"></i>Analisis Arus Kas</h3>
                         <p class="mb-0 opacity-75">Ringkasan keuangan dan transaksi terkini</p>
                     </div>
                 </div>
             </div>
             <div class="card-body">
                 {{-- Stat Cards --}}
                 <div class="row mb-4 g-4">
                     <div class="col-md-12">
                         <div class="stat-card primary">
                             <div class="stat-icon">
                                 <i class="fas fa-wallet"></i>
                             </div>
                             <div class="stat-value">@currency($totalRevenue)</div>
                             <div class="stat-label">Total Pendapatan</div>
                         </div>
                     </div>
                 </div>

                 {{-- Charts --}}
                 <div class="row mb-4 g-4">
                     <div class="col-lg-8">
                         <div class="card card-elevated">
                             <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                 <h5 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Arus Kas Bulanan</h5>
                                 <div class="dropdown">
                                     <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                         Tahun {{ date('Y') }}
                                     </button>
                                     <ul class="dropdown-menu" aria-labelledby="chartDropdown">
                                         <li><a class="dropdown-item" href="#">2023</a></li>
                                         <li><a class="dropdown-item" href="#">2022</a></li>
                                     </ul>
                                 </div>
                             </div>
                             <div class="card-body" style="height: 300px;">
                                 <canvas id="cashflowChart"></canvas>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4">
                         <div class="card card-elevated">
                             <div class="card-header bg-light">
                                 <h5 class="mb-0"><i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran</h5>
                             </div>
                             <div class="card-body" style="height: 300px;">
                                 <canvas id="paymentMethodsChart"></canvas>
                                 <div class="mt-3" id="paymentMethodsLegend"></div>
                             </div>
                         </div>
                     </div>
                 </div>

                 {{-- Recent Transactions --}}
                 <div class="card card-elevated" style="max-height: 50vh; overflow-y: auto;">
                     <div class="card-header bg-light d-flex justify-content-between align-items-center">
                         <h5 class="mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i>Transaksi Terkini</h5>
                         <div class="input-group" style="width: 250px;">
                             <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                             <input type="text" class="form-control" placeholder="Filter tanggal">
                         </div>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table class="table table-hover align-middle">
                                 <thead class="table-light">
                                     <tr>
                                         <th class="ps-4">Tanggal</th>
                                         <th>Pengguna</th>
                                         <th>Voucher</th>
                                         <th class="text-end">Jumlah</th>
                                         <th>Metode</th>
                                         <th class="text-end pe-4">Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($transactions as $transaction)
                                     <tr class="transaction-row">
                                         <td class="ps-4">
                                             <span class="text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $transaction->transaction_date->format('d M Y H:i:s') }}">
                                                 <i class="far fa-calendar-alt me-1"></i>
                                                 {{ $transaction->transaction_date->format('d M Y') }}
                                             </span>
                                         </td>
                                         <td>
                                             <div class="d-flex align-items-center">
                                                 <div class="avatar-circle me-3">
                                                     <span>{{ strtoupper(substr($transaction->user->name, 0, 1)) }}</span>
                                                 </div>
                                                 <div>
                                                     <h6 class="mb-0">{{ $transaction->user->name }}</h6>
                                                     <small class="text-muted">{{ $transaction->user->email }}</small>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <span class="voucher-badge">
                                                 <i class="fas fa-ticket-alt me-1"></i>
                                                 <code>{{ $transaction->voucher->code }}</code>
                                             </span>
                                         </td>
                                         <td class="text-end {{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                             <strong>@currency($transaction->amount)</strong>
                                         </td>
                                         <td>
                                             <span class="badge bg-{{ $transaction->payment_method === 'Transfer Bank' ? 'primary' : ($transaction->payment_method === 'Tunai' ? 'success' : 'info') }}">
                                                 {{ $transaction->payment_method }}
                                             </span>
                                         </td>
                                         <td class="text-end pe-4">
                                             <div class="btn-group" role="group">
                                                 <form action="{{ route('admin.cashflow.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus transaksi ini?')">
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
                         
                         <div class="mt-4">
                             {{ $transactions->links() }}
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     @endsection

     @push('styles')
     <style>
         .stat-card {
             text-align: center;
             padding: 30px;
             border-radius: 16px;
             background: white;
             box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
             transition: all 0.3s ease;
             position: relative;
             overflow: hidden;
             border: 1px solid #e2e8f0;
         }
         
         .stat-card::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             width: 100%;
             height: 4px;
             background: var(--primary-color);
         }
         
         .stat-card:hover {
             transform: translateY(-5px);
             box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
         }
         
         .stat-card .stat-icon {
             font-size: 2.5rem;
             margin-bottom: 16px;
             color: var(--primary-color);
             transition: all 0.3s ease;
         }
         
         .stat-card:hover .stat-icon {
             transform: scale(1.1);
         }
         
         .stat-card .stat-value {
             font-size: 2.2rem;
             font-weight: 700;
             margin-bottom: 8px;
             color: var(--dark-color);
             line-height: 1.2;
         }
         
         .stat-card .stat-label {
             color: var(--gray-color);
             font-size: 0.9rem;
             font-weight: 500;
             text-transform: uppercase;
             letter-spacing: 0.5px;
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
         
         /* Chart Legend */
         #paymentMethodsLegend {
             display: flex;
             flex-wrap: wrap;
             justify-content: center;
             gap: 10px;
             max-height: 100px;
             overflow-y: auto;
         }
         
         .chart-legend-item {
             display: flex;
             align-items: center;
             font-size: 0.8rem;
         }
         
         .chart-legend-color {
             width: 12px;
             height: 12px;
             border-radius: 3px;
             margin-right: 5px;
         }
     </style>
     @endpush

     @push('scripts')
     <script>
         var transactions = @json($transactions);

         // Cashflow Chart
         const ctx = document.getElementById('cashflowChart').getContext('2d');
         const cashflowChart = new Chart(ctx, {
             type: 'line',
             data: {
                 labels: @json($chartLabels),
                 datasets: [{
                     label: 'Arus Kas Bulanan',
                     data: @json($chartData),
                     borderColor: '#6366f1',
                     backgroundColor: 'rgba(99, 102, 241, 0.05)',
                     borderWidth: 2,
                     tension: 0.3,
                     fill: true,
                     pointBackgroundColor: '#6366f1',
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
                         display: false
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
                         displayColors: false,
                         callbacks: {
                             label: function(context) {
                                 return 'Rp ' + context.raw.toLocaleString('id-ID');
                             }
                         }
                     }
                 },
                 scales: {
                     y: {
                         beginAtZero: true,
                         grid: {
                             color: 'rgba(0, 0, 0, 0.05)'
                         },
                         ticks: {
                             callback: function(value) {
                                 return 'Rp ' + value.toLocaleString('id-ID');
                             }
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

         // Payment Methods Chart
         const pieCtx = document.getElementById('paymentMethodsChart').getContext('2d');
         const paymentMethodsChart = new Chart(pieCtx, {
             type: 'doughnut',
             data: {
                 labels: @json($paymentMethodsLabels),
                 datasets: [{
                     data: @json($paymentMethodsData),
                     backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444'],
                     borderWidth: 0,
                     hoverOffset: 10
                 }]
             },
             options: {
                 responsive: true,
                 maintainAspectRatio: false,
                 cutout: '70%',
                 plugins: {
                     legend: {
                         display: false
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
                                 const label = context.label || '';
                                 const value = context.raw || 0;
                                 const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                 const percentage = Math.round((value / total) * 100);
                                 return `${label}: ${percentage}% (${value})`;
                             }
                         }
                     }
                 }
             }
         });

         // Generate custom legend for payment methods chart
         function generateLegend() {
             const legendContainer = document.getElementById('paymentMethodsLegend');
             legendContainer.innerHTML = '';
             
             paymentMethodsChart.data.labels.forEach((label, i) => {
                 const legendItem = document.createElement('div');
                 legendItem.className = 'chart-legend-item';
                 
                 const legendColor = document.createElement('div');
                 legendColor.className = 'chart-legend-color';
                 legendColor.style.backgroundColor = paymentMethodsChart.data.datasets[0].backgroundColor[i];
                 
                 const legendText = document.createElement('span');
                 legendText.textContent = label;
                 
                 legendItem.appendChild(legendColor);
                 legendItem.appendChild(legendText);
                 legendContainer.appendChild(legendItem);
             });
         }

         // Dynamic Modal Population
         document.addEventListener('DOMContentLoaded', function() {
             generateLegend();
             
             var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
             var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                 return new bootstrap.Tooltip(tooltipTriggerEl);
             });
         });
     </script>
     @endpush