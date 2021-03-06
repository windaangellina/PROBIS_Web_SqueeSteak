<!DOCTYPE html>
<html lang="en">
<head>
	<title>Masuk</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ asset('assets/img/icons_steaks.png') }}" type="image" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}"> --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ mix('css/responsive-font.css') }}"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url('{{ asset('resources/images/app/logo/app_logo.png') }}');">
					<span class="login100-form-title-1">
						&nbsp;
					</span>
				</div>

                <div class="container w-75 align-middle mt-3 mb-0" data-validate="Username is required">
                    {{-- alert --}}
                    @include('layouts.display-items.alert')
                </div>

				<form class="login100-form validate-form" method="POST" action="{{ url('login') }}">
                    @csrf
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Nama Akun</span>
						<input class="input100" type="text" name="username" placeholder="Enter username">
						<span class="focus-input100"></span>
					</div>
                    @error('username')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Kata Sandi</span>
						<div class="d-flex justify-content-between">
                            <input class="input100 inputpw" type="password" name="pass" placeholder="Enter password">
                            <button type="button" class="btn btn-sm btn-light ml-3 py-0 btn-toggle-pw" mode='hidden'>
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
						<span class="focus-input100"></span>
					</div>
                    @error('pass')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
					<div class="container-login100-form-btn">
						<button class="login100-form-btn mx-auto" type="submit">
							Masuk
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
	<script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>


<script>
    function toggleVisibilityInputPassword(btnToggle){
        let mode = $(btnToggle).attr('mode');
        let attrType = 'text';
        if (mode == 'hidden') {
            mode ='visible';

            $(btnToggle).html('<i class="fas fa-eye"></i>');
        }
        else if (mode == 'visible') {
            mode = 'hidden';
            attrType ='password';

            $(btnToggle).html('<i class="fas fa-eye-slash"></i>');
        }

        let inputpw = $(btnToggle).siblings('.inputpw')[0];
        $(inputpw).attr('type', attrType);
        $(btnToggle).attr('mode', mode);
    }

    $(document).on('click', '.btn-toggle-pw', function(){
        toggleVisibilityInputPassword(this);
        console.log(this);
    });
</script>
