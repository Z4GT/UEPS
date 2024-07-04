<x-guest-layout>

    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-guest.sidenav-guest />
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 start-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute d-flex fixed-top ms-auto h-100 z-index-0 bg-cover me-n8"
                                    style="background-image:url('../assets/img/logoVertical.png'); background-position:center; background-size:100%; background-repeat: no-repeat;" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-black text-dark display-6" style="color:#4a59a4!important;">Registrate Aqui!</h3>
                                    <p class="mb-0" style="color:#4a59a4!important;">Encantado de Conocerte! Por favor Ingresa tus datos.</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="sign-up">
                                        @csrf
                                        <label style="color:#4a59a4!important;">Nombre</label>
                                        <div class="mb-3">
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Escriba su nombre" value="{{ old('name') }}"
                                                aria-label="Name" aria-describedby="name-addon">
                                            @error('name')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label style="color:#4a59a4!important;">Apellido</label>
                                        <div class="mb-3">
                                            <input type="text" id="last_name" name="last_name" class="form-control"
                                                placeholder="Escriba su apellido" value="{{ old('last_name') }}"
                                                aria-label="Last-Name" aria-describedby="name-addon">
                                            @error('last_name')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label style="color:#4a59a4!important;">Correo electrónico</label>
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Ingrese su correo" value="{{ old('email') }}"
                                                aria-label="Email" aria-describedby="email-addon">
                                            @error('email')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label style="color:#4a59a4!important;">Contraseña</label>
                                        <div class="mb-3">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Crea una contraseña" aria-label="Password"
                                                aria-describedby="password-addon">
                                            @error('password')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-dark w-100 mt-4 mb-3"  style="background-color:#84be51!important; border-color:#84be51; ">Registrarse</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto" style="color:#4a59a4!important;">
                                        Ya tienes una cuenta?
                                        <a href="{{ route('sign-in') }}" class="text-dark font-weight-bold" style="color:#4a59a4!important;">Inicia Sesion</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-guest-layout>
