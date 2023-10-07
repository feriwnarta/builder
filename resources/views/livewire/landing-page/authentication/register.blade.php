<div class="container vh-100">

    <div class="auth-wrapper">
        <div class="row g-0 d-sm-flex align-items-center">
            <div class="col-sm-6 order-sm-0 order-1">
                <div class="img-login "></div>
            </div>

            <div
                class="col-sm-4 offset-sm-1 order-0 order-sm-1 d-flex flex-column justify-content-around wrapper-auth-form">

                <div>
                    <img src="{{ asset('image/MicroKit.svg') }}" alt="" width="125" height="auto"
                        class="d-inline-block align-text-top microkit">
                </div>

                <div>
                    <h2 class="title-login">Sign Up for Free</h2>
                    <p class="subtitle-login">Create an Account and Start Building Your Website</p>

                    <form id="loginForm" wire:submit="save">

                        <div class="input-name">
                            <label for="inputName" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="inputName"
                                placeholder="Please enter your full name" wire:model.blur="name" required>
                            <div>
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-email">
                            <label for="inputEmail" class="col-form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="inputEmail"
                                placeholder="jamescook@gmail.com" autocomplete="on" required wire:model.blur="email">
                            <div>
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-password">
                            <label for="inputPassword" class="col-form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword"
                                placeholder="Enter password" required wire:model.blur="password">
                            <div>
                                @error('password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @elseif(Session::has('error'))
                            <div class="alert alert-error">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <button id="btnSignIn" type="submit" class="btn container">Create a new account</button>

                        <hr>

                    </form>

                    <button type="button" id="googleLogin" class="btn container" onclick="getToken()">
                        <i class="google-icon"></i>
                        Create a new account via Google
                    </button>

                    <p class="dont-have-account text-center">Have you already created an account before?
                        <span class="sign-up">
                            <a href="{{ url('/sign-in') }}" wire:navigate>Sign in</a>
                        </span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
