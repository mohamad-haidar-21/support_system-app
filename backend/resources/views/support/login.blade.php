<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Login</title>
    <link rel="icon" type="image/png" href="{{ asset('iconsupport.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 24px;
            padding: 48px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 36px;
            margin: 0 auto 24px;
            box-shadow: 0 10px 30px rgba(72, 187, 120, 0.3);
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #718096;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.1);
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .input-icon {
            position: relative;
        }

        .input-icon .form-input {
            padding-left: 48px;
        }

        .input-icon::before {
            content: attr(data-icon);
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #718096;
            z-index: 1;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(72, 187, 120, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(245, 87, 108, 0.1);
            color: #f5576c;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 20px;
            border-left: 4px solid #f5576c;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
        }

        .error-message::before {
            content: "⚠";
            font-size: 18px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .support-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(72, 187, 120, 0.1);
            color: #38a169;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .support-badge::before {
            content: "🎧";
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 32px 24px;
            }

            .login-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-icon">S</div>
            <span class="support-badge">Support Portal</span>
            <h2>Support Login</h2>
            <p>Access the support dashboard</p>
        </div>

        <form method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-icon" data-icon="📧">
                    <input type="email" name="email" class="form-input" placeholder="support@example.com"
                        value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-icon" data-icon="🔒">
                    <input type="password" name="password" class="form-input" placeholder="Enter your password"
                        required>
                </div>
            </div>

            <button type="submit" class="login-btn">Sign In</button>

            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </form>
    </div>
</body>

</html>
