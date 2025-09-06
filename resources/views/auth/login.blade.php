<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Farlu">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Farlu</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('template/html/template/assets/img/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('template/html/template/assets/css/bootstrap.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('template/html/template/assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('template/html/template/assets/css/style.css') }}">
</head>

<body>
<div class="main-wrapper auth-bg position-relative overflow-hidden">

    <div class="container-fluid position-relative z-1">
        <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">

            <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap py-3">
                <div class="col-lg-4 mx-auto">

                    <form method="POST" action="{{ route('login') }}" class="d-flex justify-content-center align-items-center">
                        @csrf
                        <div class="d-flex flex-column justify-content-lg-center p-4 p-lg-0 pb-0 flex-fill">
                            <div class="mx-auto mb-4 text-center">
                                <img src="{{ asset('template/html/template/assets/img/logo.svg') }}" class="img-fluid" width="100" alt="Logo">
                            </div>

                            <div class="card border-0 p-lg-3 rounded-4">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h5 class="mb-1 fw-bold">Connexion</h5>
                                        <p class="mb-0">Entrez vos informations pour accéder au tableau de bord</p>
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">Adresse Email</label>
                                        <div class="input-group input-group-flat">
                                            <span class="input-group-text">
                                                <i class="ti ti-mail fs-14 text-dark"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Entrez votre email" value="{{ old('email') }}" required autofocus>
                                        </div>
                                        @error('email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label class="form-label">Mot de passe</label>
                                        <div class="input-group input-group-flat">
                                            <span class="input-group-text">
                                                <i class="ti ti-lock-open fs-14 text-dark"></i>
                                            </span>
                                            <input type="password" name="password" class="pass-input form-control @error('password') is-invalid @enderror" placeholder="************" required>
                                            <span class="toggle-password input-group-text ti ti-eye-off fs-14 text-dark"></span>
                                        </div>
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Remember / Forgot -->
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="form-check form-check-md mb-0">
                                            <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
                                            <label for="remember_me" class="form-check-label mt-0 text-dark">Se souvenir de moi</label>
                                        </div>
                                        <div class="text-end">
                                            @if(Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->

                        </div>
                    </form>

                </div><!-- end col -->
            </div>
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="{{ asset('template/html/template/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('template/html/template/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/html/template/assets/js/script.js') }}"></script>

</body>
</html>
