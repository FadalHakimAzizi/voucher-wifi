<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fenyxz WiFi - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --pink: #ec4899;
            --glass: rgba(255, 255, 255, 0.2);
        }

        body {
            background: linear-gradient(-45deg, #4f46e5, #8b5cf6, #ec4899);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Glassmorphism Card */
        .auth-card {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        /* Floating Elements */
        .floating {
            position: absolute;
            opacity: 0.8;
            animation: floating 8s ease-in-out infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Form Styles */
        .form-control {
            border: none;
            border-bottom: 2px solid #ddd;
            background: transparent;
            border-radius: 0;
            padding-left: 40px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-bottom-color: var(--primary);
            box-shadow: none;
            background: rgba(255, 255, 255, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }

        /* Button Gradient */
        .auth-btn {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }

        .auth-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        /* Logo Brand */
        .brand-logo {
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            transition: transform 0.5s;
        }

        .brand-logo:hover {
            transform: rotate(15deg);
        }
    </style>
</head>
<body>
    <!-- Floating Background Elements -->
    <svg class="floating" style="top:10%; left:5%; width:80px;" viewBox="0 0 24 24" fill="white" opacity="0.1">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
    </svg>

    <svg class="floating" style="bottom:15%; right:5%; width:60px;" viewBox="0 0 24 24" fill="white" opacity="0.1">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
    </svg>

    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>