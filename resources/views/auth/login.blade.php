<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card shadow">

                    <div class="card-header text-center">
                        <h3>Login</h3>
                    </div>

                    <div class="card-body">

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">

                            @csrf

                            <div class="mb-3">
                                <label>Email</label>

                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>

                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3 form-check">

                                <input type="checkbox" class="form-check-input" name="remember">

                                <label class="form-check-label">
                                    Remember Me
                                </label>

                            </div>

                            <button class="btn btn-primary w-100">
                                Login
                            </button>

                        </form>

                        <div class="text-center mt-3">
                            <a href="/register">
                                Create Account
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
