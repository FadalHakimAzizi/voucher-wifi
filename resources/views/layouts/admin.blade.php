<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Fenyxz WiFi Voucher') }} – Admin Dashboard</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Custom CSS -->
  <style>
    :root {
      --primary-color: #6366f1;
      --primary-light: #818cf8;
      --primary-dark: #4f46e5;
      --secondary-color: #f43f5e;
      --light-color: #f8fafc;
      --dark-color: #0f172a;
      --gray-color: #64748b;
      --gray-light: #e2e8f0;
      --success-color: #10b981;
      --warning-color: #f59e0b;
      --danger-color: #ef4444;
      --info-color: #0ea5e9;
      --sidebar-width: 280px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: #f8fafc;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      color: #334155;
      line-height: 1.6;
    }

    /* Sidebar Styles */
    .sidebar {
      background: linear-gradient(180deg, var(--primary-dark), var(--primary-color));
      color: white;
      min-height: 100vh;
      position: fixed;
      width: var(--sidebar-width);
      transition: var(--transition);
      box-shadow: var(--shadow-lg);
      z-index: 1000;
      border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar.active {
      transform: translateX(-100%);
    }

    .sidebar-brand {
      padding: 24px;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: var(--transition);
    }

    .sidebar-brand .logo-icon {
      font-size: 1.8rem;
      margin-right: 12px;
      color: white;
      background: rgba(255, 255, 255, 0.15);
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      transition: var(--transition);
    }

    .sidebar-brand .logo-text {
      font-weight: 700;
      font-size: 1.4rem;
      transition: var(--transition);
      letter-spacing: -0.5px;
    }

    .sidebar-nav {
      padding: 16px 0;
      list-style: none;
      margin: 0;
    }

    .sidebar-nav li {
      margin: 4px 0;
    }

    .sidebar-nav li a {
      color: rgba(255, 255, 255, 0.85);
      text-decoration: none;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      transition: var(--transition);
      border-radius: 8px;
      margin: 0 12px;
      position: relative;
      overflow: hidden;
    }

    .sidebar-nav li a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 3px;
      background: white;
      transform: scaleY(0);
      transition: var(--transition);
      transform-origin: bottom;
    }

    .sidebar-nav li a:hover,
    .sidebar-nav li a.active {
      color: white;
      background: rgba(255, 255, 255, 0.15);
    }

    .sidebar-nav li a.active::before {
      transform: scaleY(1);
    }

    .sidebar-nav li a i {
      margin-right: 12px;
      font-size: 1.1rem;
      width: 20px;
      text-align: center;
      transition: var(--transition);
    }

    .nav-item-badge {
      position: absolute;
      right: 20px;
      background: var(--secondary-color);
      color: white;
      border-radius: 50px;
      min-width: 20px;
      height: 20px;
      font-size: 0.7rem;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 6px;
      font-weight: 600;
      transition: var(--transition);
    }

    /* Logout Item in Sidebar */
    .sidebar-nav .logout-item a {
      color: rgba(255, 255, 255, 0.7) !important;
      margin-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 15px;
    }

    .sidebar-nav .logout-item a:hover {
      color: white !important;
      background: rgba(239, 68, 68, 0.15) !important;
    }

    /* Main Content Styles */
    .main-content {
      margin-left: var(--sidebar-width);
      padding: 0;
      transition: var(--transition);
      min-height: 100vh;
      background-color: #f8fafc;
    }

    .main-content.active {
      margin-left: 0;
    }

    /* Content Container */
    .content-container {
      padding: 30px;
    }

    /* Card Styles */
    .card-custom {
      border: none;
      border-radius: 16px;
      box-shadow: var(--shadow-sm);
      margin-bottom: 24px;
      transition: var(--transition);
      background: white;
      overflow: hidden;
      border: 1px solid var(--gray-light);
    }

    .card-custom:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    .card-custom .card-header {
      background: white;
      border-bottom: 1px solid var(--gray-light);
      font-weight: 600;
      padding: 18px 24px;
      border-radius: 16px 16px 0 0;
      color: var(--dark-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .card-custom .card-header i {
      color: var(--primary-color);
      font-size: 1.2rem;
    }

    .card-custom .card-body {
      padding: 24px;
    }

    .stat-card {
      text-align: center;
      padding: 24px;
      border-radius: 16px;
      background: white;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      border: 1px solid var(--gray-light);
      position: relative;
      overflow: hidden;
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
      box-shadow: var(--shadow-lg);
    }

    .stat-card .stat-icon {
      font-size: 2.5rem;
      margin-bottom: 16px;
      opacity: 0.9;
      transition: var(--transition);
    }

    .stat-card:hover .stat-icon {
      transform: scale(1.1);
    }

    .stat-card .stat-value {
      font-size: 2rem;
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

    .stat-card.primary::before { background: var(--primary-color); }
    .stat-card.success::before { background: var(--success-color); }
    .stat-card.warning::before { background: var(--warning-color); }
    .stat-card.danger::before { background: var(--danger-color); }

    /* Table Styles */
    .table-responsive {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-light);
    }

    .table-custom {
      margin-bottom: 0;
    }

    .table-custom thead th {
      background: var(--primary-color);
      color: white;
      border: none;
      padding: 16px 20px;
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      vertical-align: middle;
    }

    .table-custom tbody tr {
      transition: var(--transition);
    }

    .table-custom tbody tr:hover {
      background-color: rgba(99, 102, 241, 0.05);
    }

    .table-custom tbody td {
      vertical-align: middle;
      padding: 14px 20px;
      border-color: var(--gray-light);
      font-size: 0.9rem;
    }

    /* Badge Styles */
    .badge-custom {
      padding: 6px 12px;
      font-weight: 500;
      border-radius: 6px;
      font-size: 0.75rem;
      transition: var(--transition);
      letter-spacing: 0.3px;
    }

    .badge-custom:hover {
      transform: scale(1.05);
    }

    .status-active { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }
    .status-expired { background: rgba(100, 116, 139, 0.1); color: var(--gray-color); }
    .status-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning-color); }

    /* Button Styles */
    .btn-custom-primary {
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 500;
      transition: var(--transition);
      box-shadow: 0 2px 5px rgba(99, 102, 241, 0.2);
    }

    .btn-custom-primary:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
      color: white;
    }

    .btn-custom-outline-primary {
      border: 1px solid var(--primary-color);
      color: var(--primary-color);
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 500;
      transition: var(--transition);
      background: transparent;
    }

    .btn-custom-outline-primary:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(99, 102, 241, 0.1);
    }

    /* Form Styles */
    .form-control-custom {
      border-radius: 10px;
      padding: 12px 16px;
      border: 1px solid var(--gray-light);
      transition: var(--transition);
      font-size: 0.9rem;
    }

    .form-control-custom:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
      outline: none;
    }

    .search-box {
      position: relative;
    }

    .search-box i {
      position: absolute;
      top: 14px;
      left: 16px;
      color: var(--gray-color);
      transition: var(--transition);
    }

    .search-box .form-control:focus + i {
      color: var(--primary-color);
    }

    .search-box .form-control {
      padding-left: 42px;
      font-size: 0.9rem;
      border-radius: 10px;
    }

    /* Breadcrumb */
    .breadcrumb-custom {
      background: transparent;
      padding: 0;
      margin-bottom: 24px;
    }

    .breadcrumb-custom .breadcrumb-item {
      font-size: 0.9rem;
      font-weight: 500;
    }

    .breadcrumb-custom .breadcrumb-item a {
      color: var(--gray-color);
      text-decoration: none;
      transition: var(--transition);
    }

    .breadcrumb-custom .breadcrumb-item a:hover {
      color: var(--primary-color);
    }

    .breadcrumb-custom .breadcrumb-item.active {
      color: var(--dark-color);
      font-weight: 600;
    }

    .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
      content: '›';
      color: var(--gray-color);
      font-size: 1.1rem;
      line-height: 1;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        transform: translateX(-100%);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .sidebar-brand {
        justify-content: center;
      }

      .sidebar-brand .logo-text {
        display: none;
      }

      .sidebar-nav li a {
        justify-content: center;
        padding: 12px;
        margin: 0 8px;
      }

      .sidebar-nav li a i {
        margin-right: 0;
        font-size: 1.2rem;
      }

      .nav-item-badge {
        right: 8px;
      }

      .main-content {
        margin-left: 0;
      }

      .content-container {
        padding: 16px;
      }

      .card-custom .card-header,
      .card-custom .card-body {
        padding: 16px;
      }

      .table-custom thead th,
      .table-custom tbody td {
        padding: 12px 14px;
        font-size: 0.82rem;
      }
    }

    @media (min-width: 769px) and (max-width: 992px) {
      .sidebar {
        width: 240px;
      }

      .main-content {
        margin-left: 240px;
      }

      .sidebar-brand .logo-text {
        font-size: 1.2rem;
      }

      .sidebar-nav li a {
        padding: 10px 16px;
        margin: 0 8px;
      }

      .stat-card .stat-value {
        font-size: 1.6rem;
      }
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
      animation: fadeIn 0.4s ease-out forwards;
    }

    /* Smooth scroll */
    html {
      scroll-behavior: smooth;
    }

    /* Floating action button */
    .fab {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: var(--primary-color);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow-lg);
      transition: var(--transition);
      z-index: 100;
      border: none;
      cursor: pointer;
    }

    .fab:hover {
      transform: translateY(-3px) scale(1.05);
      background: var(--primary-dark);
    }

    .fab i {
      font-size: 1.5rem;
    }
  </style>
  @stack('styles')
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-brand">
      <i class="fas fa-wifi logo-icon"></i>
      <span class="logo-text">Fenyxz</span>
    </div>
    <ul class="nav flex-column sidebar-nav">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
          <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </a>
      </li>

      @if(Auth::user()->role === 'admin')
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"
           href="{{ route('admin.users') }}">
          <i class="fas fa-users me-2"></i>User Management
          @if(isset($usersCount) && $usersCount > 0)
          <span class="nav-item-badge">{{ $usersCount }}</span>
          @endif
        </a>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.vouchers.index') ? 'active' : '' }}"
           href="{{ route('admin.vouchers.index') }}">
          <i class="fas fa-ticket-alt me-2"></i>Voucher Codes
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.cashflow') ? 'active' : '' }}"
           href="{{ route('admin.cashflow') }}">
          <i class="fas fa-chart-line me-2"></i>Cashflow Analysis
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.history') ? 'active' : '' }}"
           href="{{ route('admin.history') }}">
          <i class="fas fa-history me-2"></i>Usage History
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.promotions') ? 'active' : '' }}"
           href="{{ route('admin.promotions') }}">
          <i class="fas fa-bullhorn me-2"></i>Promotions
        </a>
      </li>
      <li class="logout-item nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
      </li>
    </ul>
  </div>

  <div class="main-content">
    <div class="content-container">
      @yield('content')
    </div>
  </div>

  <!-- Floating Action Button -->
  <button class="fab" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
    <i class="fas fa-arrow-up"></i>
  </button>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggler = document.querySelector('.navbar-toggler');
      const sidebar = document.querySelector('.sidebar');
      const mainContent = document.querySelector('.main-content');

      // Remove navbar toggler since navbar is removed
      if (toggler) toggler.remove();

      document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && !e.target.closest('.sidebar')) {
          sidebar.classList.remove('active');
          mainContent.classList.remove('active');
        }
      });

      // Add animation to cards when they come into view
      const animateOnScroll = () => {
        const cards = document.querySelectorAll('.card-custom, .stat-card');
        cards.forEach(card => {
          const cardPosition = card.getBoundingClientRect().top;
          const screenPosition = window.innerHeight / 1.2;
          
          if (cardPosition < screenPosition) {
            card.classList.add('fade-in');
          }
        });
      };

      window.addEventListener('scroll', animateOnScroll);
      animateOnScroll(); // Run once on load

      // Show/hide floating action button
      const fab = document.querySelector('.fab');
      window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
          fab.style.display = 'flex';
        } else {
          fab.style.display = 'none';
        }
      });
    });
  </script>
  @stack('scripts')
</body>
</html>