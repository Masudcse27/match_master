<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .verification-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7f7f7;
        }
        .verification-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .verification-code-input {
            letter-spacing: 10px;
            text-align: center;
            font-size: 24px;
        }
    </style>
</head>
<body>

<div class="verification-container">
    <div class="verification-box">
        <h3 class="text-center mb-4">Email Verification</h3>
        <p class="text-center">Enter the code sent to your email address.</p>
        <form action="{{route('otp.verification')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="verificationCode" class="form-label">Verification Code</label>
                <input type="text" name="verificationCode" class="form-control verification-code-input" id="verificationCode" maxlength="6" placeholder="______" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Verify</button>
            </div>
        </form>
        <div class="text-center mt-3">
            <p>Didn't receive the code?</p>
            <a class="btn btn-link" href="{{route('otp.resend')}}">Resend Code</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
