<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #e05100;
            --secondary: #008FE0;
            --light: #F2F2F2;
            --dark: #111111;
        }

        body {
            background-image: linear-gradient(to right, var(--primary), var(--secondary));
            color: var(--light);
            font-family: 'Poppins', sans-serif;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-control {
            background-color:var(--light) ;
            border-color: rgba(255, 255, 255, 0.3);
            color: var(--light);
        }

        .form-control:focus {
            background-color: transparent;
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.25rem rgba(0, 143, 224, 0.25);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #c04100;
            border-color: #c04100;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-secondary {
            color: var(--secondary) !important;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row w-100">
        <div class="col-md-6 offset-md-3" >
            <div class="card shadow-lg " >
                <div class="card-header text-center py-3">
                    <img src="{{asset('assets')}}/img/logo.png" style="max-width: 200px">
                    <h3 class="card-title"><b>Sign Up</b></h3>
                    <h6>Join the ride and explore the world with us!</h6>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <!-- Password and Confirm Password in One Row -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>

                    <!-- Login Link -->
                    <div class="text-center mt-4">
                        <p class="mb-0">Already have an account?
                            <a href="{{ route('login') }}" style="color: #0a0a0a"><b>Login</b></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
