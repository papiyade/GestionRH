<x-guest-layout>
    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        {{-- <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">{{ __('Log in to your account') }}</h2>

        <a href="{{route('redirect.google')}}"> Se connecter avec Google</a>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form> --}}
        <body>

            <!-- auth-page wrapper -->
            <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
                <div class="bg-overlay"></div>
                <!-- auth-page content -->
                <div class="auth-page-content overflow-hidden pt-lg-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card overflow-hidden card-bg-fill galaxy-border-none">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4 auth-one-bg h-100">
                                                <div class="bg-overlay"></div>
                                                <div class="position-relative h-100 d-flex flex-column">
                                                    <div class="mb-4">
                                                        <a href="index.html" class="d-block">
                                                            <img src="assets/images/logo-light.png" alt="" height="18">
                                                        </a>
                                                    </div>
                                                    <div class="mt-auto">
                                                        <div class="mb-3">
                                                            <i class="ri-double-quotes-l display-4 text-success"></i>
                                                        </div>

                                                        <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                            <div class="carousel-indicators">
                                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                            </div>
                                                            <div class="carousel-inner text-center text-white-50 pb-5">
                                                                <div class="carousel-item active">
                                                                    <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                                </div>
                                                                <div class="carousel-item">
                                                                    <p class="fs-15 fst-italic">" The theme is really great with an amazing customer support."</p>
                                                                </div>
                                                                <div class="carousel-item">
                                                                    <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end carousel -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->

                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <div>
                                                    <h5 class="text-primary">Bienvenue !</h5>
                                                    <p class="text-muted">Connectez-vous pour pouvoir continuer sur Farlu.</p>
                                                </div>

                                                <div class="mt-4">
                                                    <form method="POST" action="{{ route('login') }}">
                                                    @csrf
                                                        <div class="mb-3">
                                                            <label for="username" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre adresse mail">
                                                        </div>

                                                        <div class="mb-3">
                                                            <div class="float-end">
                                                                <a href="auth-pass-reset-cover.html" class="text-muted">Mot de passe oublié ?</a>
                                                            </div>
                                                            <label class="form-label" for="password-input">Mot de passe</label>
                                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                                <input type="password" name="password" class="form-control pe-5 password-input" placeholder="Entrez votre mot de passe" id="password">
                                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                            </div>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember">
                                                            <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                                                        </div>
                                                        <x-validation-errors class="mb-4" />

                                                        <div class="mt-4">
                                                            <button class="btn btn-success w-100" type="submit">Se Connecter</button>
                                                        </div>

                                                        <div class="mt-4 text-center">
                                                            <div class="signin-other-title">
                                                                <h5 class="fs-13 mb-4 title">Se Connecter avec</h5>
                                                            </div>

                                                            <div>
                                                                <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                          {{--      <a href="{{route('redirect.google')}}" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></a> --}}
                                                          <a href="#" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></a>

                                                                <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                                <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>

                                                <div class="mt-5 text-center">
                                                    <p class="mb-0">Vous n'avez pas de compte ? <a href="auth-signup-cover.html" class="fw-semibold text-primary text-decoration-underline"> S'inscrire</a> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end container -->
                </div>
                <!-- end auth page content -->

                <!-- footer -->
                <footer class="footer galaxy-border-none">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <p class="mb-0">&copy;
                                        <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->
            </div>
            <!-- end auth-page-wrapper -->

            <!-- JAVASCRIPT -->
            <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/libs/simplebar/simplebar.min.js"></script>
            <script src="assets/libs/node-waves/waves.min.js"></script>
            <script src="assets/libs/feather-icons/feather.min.js"></script>
            <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
            <script src="assets/js/plugins.js"></script>

            <!-- password-addon init -->
            <script src="assets/js/pages/password-addon.init.js"></script>
        </body>

</x-guest-layout>
