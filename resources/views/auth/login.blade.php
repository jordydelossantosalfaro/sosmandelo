<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Nest Dashboard</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('imgs/theme/favicon.svg') }}" />
        <link href="{{ asset('css/main.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main>
            <section class="content-main mt-80 mb-80">
                <div class="card mx-auto card-login">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            Ingresar al sistema
                        </h4>
                        <form method="POST" action="{{ route('admin.login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" placeholder="Email"
                                       required autocomplete="off" autofocus />

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" placeholder="Password"
                                       required autocomplete="current-password" />

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                           {{ old('remember') ? 'checked' : '' }} />
                                    <span class="form-check-label">
                                        Recordarme
                                    </span>
                                </label>
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    Iniciar sesión
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
        <script src="{{ asset('js/vendors/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/vendors/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/vendors/jquery.fullscreen.min.js') }}"></script>
        <script src="{{ asset('js/main.js?v=1.1') }}" type="text/javascript"></script>
    </body>
</html>
