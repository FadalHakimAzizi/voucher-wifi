<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiFi Voucher - Login Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6c63ff;
            --primary-light: #8a84ff;
            --primary-dark: #4d44db;
            --accent-color: #ff6584;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --gray-light: #e9ecef;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
        }
        
        .auth-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .auth-container:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        
        .auth-header h2 {
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            font-size: 2rem;
        }
        
        .auth-header p {
            opacity: 0.9;
            margin-bottom: 0;
            font-size: 1.1rem;
            position: relative;
        }
        
        .auth-body {
            padding: 40px;
        }
        
        .form-control {
            padding: 15px 20px;
            border-radius: 10px;
            border: 1px solid var(--gray-light);
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.15);
        }
        
        .input-group-text {
            background-color: white;
            border-right: none;
            color: var(--gray-color);
        }
        
        .form-control:focus + .input-group-text {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 15px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
            font-size: 1rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.2);
        }
        
        .btn-primary:active {
            transform: translateY(-1px);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--gray-color);
            margin: 25px 0;
            font-size: 0.9rem;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--gray-light);
        }
        
        .divider::before {
            margin-right: 15px;
        }
        
        .divider::after {
            margin-left: 15px;
        }
        
        .auth-footer {
            text-align: center;
            padding: 20px;
            background-color: var(--light-color);
            border-top: 1px solid var(--gray-light);
            font-size: 0.9rem;
        }
        
        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .auth-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .voucher-badge {
            position: absolute;
            top: -15px;
            right: -15px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 15px rgba(255, 101, 132, 0.3);
            animation: pulse 2s infinite;
        }
        
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: var(--gray-color);
            font-weight: 500;
            padding: 15px 25px;
            font-size: 1.1rem;
            transition: all 0.3s;
            position: relative;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: transparent;
        }
        
        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 3px;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            color: var(--primary-color);
        }
        
        .wifi-icon {
            font-size: 4rem;
            color: white;
            margin-bottom: 20px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: float 3s ease-in-out infinite;
        }
        
        .alert-danger {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .auth-header {
                padding: 30px 20px;
            }
            
            .auth-body {
                padding: 30px;
            }
            
            .wifi-icon {
                font-size: 3rem;
            }
            
            .voucher-badge {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                top: -10px;
                right: -10px;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="auth-container">
                    <div class="auth-header">
                        <div class="position-relative d-inline-block">
                            <i class="wifi-icon fas fa-wifi"></i>
                            <div class="voucher-badge">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
                        <h2>WiFi Voucher System</h2>
                        <p>Administrator Login Portal</p>
                    </div>
                    
                    <div class="auth-body">
                        <ul class="nav nav-tabs justify-content-center" id="authTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="authTabsContent">
                            <!-- Login Tab -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action='' method="POST" id="loginForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="loginEmail" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" value="{{ old('email') }}" name="email" class="form-control" id="loginEmail" placeholder="Enter your email" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="loginPassword" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-sign-in-alt me-2"></i> Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="auth-footer">
                        <p>Need help? <a href="#">Contact support</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple form validation example
        document.addEventListener('DOMContentLoaded', function() {
            // Login form validation
            const loginForm = document.querySelector('#login form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const email = document.getElementById('loginEmail').value;
                    const password = document.getElementById('loginPassword').value;
                    
                    if (!email || !password) {
                        e.preventDefault();
                        alert('Please fill in all fields');
                    }
                });
            }
            
            // Add animation class when elements are in view
            const authContainer = document.querySelector('.auth-container');
            if (authContainer) {
                setTimeout(() => {
                    authContainer.style.opacity = '1';
                    authContainer.style.transform = 'translateY(0)';
                }, 100);
            }
        });
    </script>
</body>
</html>