<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Panel')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #e6f0ff;
            --primary-gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --text-dark: #2b2d42;
            --text-medium: #4a4e69;
            --text-light: #8d99ae;
            --bg-light: #f8fafc;
            --border-radius: 12px;
            --box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        body {
            font-family: 'Poppins', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            transition: var(--transition);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand:hover {
            transform: translateX(3px);
            color: var(--primary-color);
        }
        
        .navbar-brand i {
            font-size: 1.8rem;
            margin-right: 0.5rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            position: relative;
            color: var(--text-medium) !important;
            font-weight: 500;
            margin: 0 0.25rem;
            padding: 0.75rem 1.25rem !important;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }
        
        .nav-link i {
            width: 1.25rem;
            text-align: center;
            margin-right: 0.5rem;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            color: white !important;
            background: var(--primary-gradient);
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
        }
        
        .nav-link.active i {
            color: white;
        }
        
        .logout-btn {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color) !important;
            border-radius: var(--border-radius);
            padding: 0.5rem 1.25rem;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .logout-btn:hover {
            background: var(--primary-gradient);
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
        }
        
        .logout-btn i {
            margin-right: 0.5rem;
        }
        
        .main-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
            animation: fadeIn 0.5s ease-out;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert {
            border-radius: var(--border-radius);
            border-left: 4px solid;
            box-shadow: var(--box-shadow);
            padding: 1rem 1.5rem;
        }
        
        .alert i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }
        
        footer {
            background-color: white;
            padding: 1.5rem 0;
            margin-top: auto;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .social-icon {
            color: var(--text-light);
            transition: var(--transition);
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.03);
            margin: 0 0.5rem;
        }
        
        .social-icon:hover {
            color: white;
            background: var(--primary-gradient);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
        }
        
        .footer-text {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-container {
                padding: 1.5rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
            
            .navbar-brand {
                font-size: 1.25rem;
            }
            
            .nav-link {
                padding: 0.5rem 1rem !important;
                margin: 0.25rem 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top animate__animated animate__fadeIn">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                <i class="fas fa-cube"></i>
                <span class="ms-2">Fenyxz</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.dashboard')) active @endif" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <span class="ms-2">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.vouchers.*')) active @endif" href="{{ route('user.vouchers.index') }}">
                            <i class="fas fa-ticket-alt"></i>
                            <span class="ms-2">Vouchers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.redeem.*')) active @endif" href="{{ route('user.redeem.form') }}">
                            <i class="fas fa-gift"></i>
                            <span class="ms-2">Redeem</span>
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit" class="btn logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="ms-2">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container main-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="d-flex justify-content-center mb-3">
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-github"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="footer-text text-center mb-0">© 2025 Fenyxz. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add animation to navbar items on hover
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', () => {
                if (!link.classList.contains('active')) {
                    link.style.transform = 'translateY(-2px)';
                }
            });
            link.addEventListener('mouseleave', () => {
                if (!link.classList.contains('active')) {
                    link.style.transform = '';
                }
            });
        });
        
        // Add animation to logout button
        const logoutBtn = document.querySelector('.logout-btn');
        logoutBtn.addEventListener('mouseenter', () => {
            logoutBtn.style.transform = 'translateY(-2px)';
        });
        logoutBtn.addEventListener('mouseleave', () => {
            logoutBtn.style.transform = '';
        });
    </script>
    
    @stack('scripts')
</body>
</html>