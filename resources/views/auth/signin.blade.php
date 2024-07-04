<x-guest-layout>
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-guest.sidenav-guest />
            </div>
        </div>
    </div>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <h3 class="font-weight-black text-dark display-6" style="color:#4a59a4!important;">Bienvenido</h3>
                                    <p class="mb-0" style=color:#4a59a4!important;">Crea una nueva cuenta<br></p>
                                    <p class="mb-0" style="color:#4a59a4!important;">O inicia sesión con tus credenciales</p>
                                </div>
                                <div class="text-center">
                                    @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-green-600">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @error('message')
                                        <div class="alert alert-danger text-sm" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="card-body">
                                    <form role="form" class="text-start" method="POST" action="{{ route('sign-in') }}">
                                        @csrf
                                        <label style="color:#4a59a4!important;">Correo Electrónico</label>
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Ingresa tu Correo Electrónico"
                                                value="{{ old('email') ? old('email') : '' }}"
                                                aria-label="Email" aria-describedby="email-addon">
                                        </div>
                                        <label style="color:#4a59a4!important;">Contraseña</label>
                                        <div class="mb-3">
                                            <input type="password" id="password" name="password"
                                                value="{{ old('password') ? old('password') : '' }}"
                                                class="form-control" placeholder="Contraseña" aria-label="Password"
                                                aria-describedby="password-addon">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('password.request') }}"
                                                class="text-xs font-weight-bold ms-auto" style="color:#4a59a4!important;">Olvidé mi contraseña</a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark w-100 mt-4 mb-3" style="background-color:#84be51!important; border-color:#84be51;">Iniciar Sesión</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto" style="color:#4a59a4!important;">
                                        ¿No tienes una cuenta aún?
                                        <a href="{{ route('sign-up') }}" class="text-dark font-weight-bold" style="color:#4a59a4!important;">Regístrate Ahora</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8"
                                    style="background-image:url('../assets/img/logoVertical.png');background-position:center; background-size:100%; background-repeat: no-repeat;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-guest-layout>
