<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitCore - Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: black;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            gap: 40px;
            width: 100%;
            max-width: 600px;
            align-items: center;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .image-box {
                display: none;
            }
        }

        .form-card {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(224, 255, 0, 0.2);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            color: #e0e7ff;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #e0ff00;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #e0e7ff;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(224, 255, 0, 0.2);
            color: #e0e7ff;
            border-radius: 6px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #e0ff00;
            background: rgba(30, 41, 59, 1);
        }

        input::placeholder {
            color: #64748b;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="radio"] {
            width: auto;
            accent-color: #e0ff00;
        }

        .radio-option label {
            margin: 0;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #e0ff00;
            border: none;
            color: #0f172a;
            font-weight: 700;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #f0ff1a;
        }
        .login-link{
            text-align: center;
            margin-top: 20px;
        }
        .login-link a{
            text-decoration: none;
            color: #CCFF00;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="form-card">
            <h1>Create Account</h1>
            <form method="POST" action="register.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" min="13" max="120" required>
            </div>

            <div class="form-group">
                <label for="height">Height (cm)</label>
                <input type="number" id="height" name="height" min="50" max="300" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="male" name="gender" value="Male" required>
                        <label for="male">Male</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="female" name="gender" value="Female" required>
                        <label for="female">Female</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>

            <button type="submit">Create Account</button>
            <div class="login-link">
                Already have an account? <a href="login.php">Sign In</a>
            </div>

            </form>

        </div>
    </div>
</body>
</html>