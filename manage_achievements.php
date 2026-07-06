<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Login | NWP Engineering Department</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #122340;
            --accent-gold: #d4af37;
            --bg-color: #f8fafc;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #122340 0%, #1e3a8a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .logo-area {
            margin-bottom: 30px;
        }
        .logo-area i {
            font-size: 3.5rem;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }
        h2 {
            color: var(--primary-blue);
            margin-bottom: 5px;
            font-weight: 700;
        }
        p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 38px;
            color: #94a3b8;
        }
        .login-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .login-btn:hover {
            background: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(18, 35, 64, 0.3);
        }
        .error-msg {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: none;
        }
        .back-home {
            display: inline-block;
            margin-top: 25px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }
        .back-home:hover {
            color: var(--primary-blue);
        }
        @media (max-width: 480px) {
            .login-card {
                padding: 25px 20px;
                border-radius: 16px;
                margin: 15px;
            }
            .logo-area {
                margin-bottom: 20px;
            }
            .logo-area i {
                font-size: 2.8rem;
                margin-bottom: 10px;
            }
            h2 {
                font-size: 1.4rem;
            }
            p {
                margin-bottom: 20px;
            }
            .form-control {
                padding: 10px 15px 10px 38px;
            }
            .input-icon {
                top: 35px;
                left: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-area">
            <i class="fas fa-user-shield"></i>
            <h2>Member Access</h2>
            <p>Authorized personnel only</p>
        </div>

        <div id="errorMsg" class="error-msg">
            <i class="fas fa-exclamation-circle"></i> Invalid credentials.
        </div>

        <form id="loginForm">
            <div class="form-group">
                <label>Username / ID</label>
                <i class="fas fa-user input-icon"></i>
                <input type="text" id="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <i class="fas fa-key input-icon"></i>
                <input type="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="login-btn">Sign In <i class="fas fa-arrow-right" style="margin-left:8px;"></i></button>
        </form>

        <a href="index.html" class="back-home"><i class="fas fa-chevron-left"></i> Back to Homepage</a>
    </div>

    <script src="members_login_db.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const uname = document.getElementById('username').value.trim();
            const pass = document.getElementById('password').value.trim();
            const errorMsg = document.getElementById('errorMsg');

            const handleLocalFallback = () => {
                if (typeof portalDatabase !== 'undefined') {
                    const localUsers = JSON.parse(localStorage.getItem('portalUsers')) || portalDatabase.users;
                    const foundUser = localUsers.find(u => u.username === uname && u.password === pass);
                    
                    if (foundUser) {
                        sessionStorage.setItem('loggedInUser', JSON.stringify(foundUser));
                        window.location.href = 'members.html';
                        return true;
                    }
                }
                return false;
            };

            // Try PHP Database Authentication First
            const formData = new FormData();
            formData.append('username', uname);
            formData.append('password', pass);

            fetch('auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    sessionStorage.setItem('loggedInUser', JSON.stringify(data.user));
                    window.location.href = 'members.html';
                } else {
                    // Try local fallback first before displaying error
                    if (!handleLocalFallback()) {
                        errorMsg.innerText = data.message;
                        errorMsg.style.display = 'block';
                    }
                }
            })
            .catch(error => {
                console.error('Database connection failed. Trying local fallback:', error);
                if (!handleLocalFallback()) {
                    errorMsg.innerHTML = "<strong>Access Error:</strong> Incorrect credentials or database connection failed. <br><small>Try the default admin login: <b>admin / admin123</b></small>";
                    errorMsg.style.display = 'block';
                }
            });
        });
    </script>

</body>
</html>
