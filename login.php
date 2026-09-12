<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | Login</title>
    <!-- เพิ่ม Font Prompt จาก Google Fonts ให้ตัวหนังสือภาษาไทยสวยขึ้น -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Prompt', system-ui, -apple-system, sans-serif; 
        }
        
        body { 
            min-height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            background: #0f172a; 
            color: #f8fafc;
            overflow: hidden;
            padding: 20px;
        }

        /* การตกแต่งการ์ดแบบเดียวกับหน้า index.php */
        .login-card { 
            background: #1e293b; 
            border: 1px solid #334155; 
            padding: 40px 35px; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3); 
            width: 100%; 
            max-width: 380px; 
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card h2 { 
            color: #10b981; 
            text-align: center; 
            margin-bottom: 30px; 
            font-weight: 600; 
            letter-spacing: 1px; 
        }

        .input-group { 
            margin-bottom: 20px; 
            position: relative;
        }

        .input-group label { 
            display: block; 
            color: #94a3b8; 
            font-size: 14px; 
            margin-bottom: 8px; 
            text-transform: capitalize; 
            font-weight: 400;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group input { 
            width: 100%; 
            padding: 10px 14px; 
            border-radius: 6px; 
            border: 1px solid #334155; 
            background: #0f172a; 
            font-size: 14px; 
            outline: none; 
            transition: all 0.2s ease; 
            color: #ffffff;
        }

        .input-group input:focus { 
            border-color: #10b981; 
            outline: 2px solid #10b981;
        }

        /* ปุ่มแสดง/ซ่อนรหัสผ่าน */
        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 13px;
            user-select: none;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #10b981;
        }

        /* ลิ้งค์เพิ่มเติม */
        .form-options {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            margin-top: -10px;
        }

        .forgot-pass {
            color: #94a3b8;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-pass:hover {
            color: #10b981;
            text-decoration: underline;
        }

        .btn-login { 
            width: 100%; 
            padding: 10px 18px; 
            margin-top: 5px; 
            border: none; 
            border-radius: 6px; 
            background: #10b981; 
            color: #ffffff; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.2s ease; 
        }

        .btn-login:hover { 
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login</h2>
        <form action="check_login.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="กรอกชื่อผู้ใช้" autocomplete="username">
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required placeholder="กรอกรหัสผ่าน" autocomplete="current-password">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">แสดง</button>
                </div>
            </div>

            <div class="form-options">
                <a href="#" class="forgot-pass">ลืมรหัสผ่าน?</a>
            </div>

            <button type="submit" class="btn-login">เข้าสู่ระบบ</button>
        </form>
    </div>

    <!-- Script ช่วยเปิด/ปิดการมองเห็นรหัสผ่าน -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = 'ซ่อน';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = 'แสดง';
            }
        }
    </script>
</body>
</html>