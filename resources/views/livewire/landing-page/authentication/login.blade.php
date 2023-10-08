<div class="container vh-100">

    <div class="auth-wrapper">
        <div class="row g-0 d-sm-flex align-items-center">
            <div class="col-sm-6 order-1 order-sm-0">
                <div class="img-login"></div>
            </div>

            <div
                class="col-sm-4 offset-sm-1 order-0 order-sm-1 d-sm-flex flex-column justify-content-around wrapper-auth-form">

                <div>
                    <img src="{{ asset('image/MicroKit.svg') }}" alt="" width="125" height="auto"
                        class="d-inline-block align-text-top microkit">
                </div>




                <div>
                    <h2 class="title-login">Ready to Create?</h2>
                    <p class="subtitle-login">Sign in to Begin Crafting Your Website</p>

                    <form wire:submit="login">

                        <div class="input-email">
                            <label for="inputEmail" class="col-form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="inputEmail"
                                placeholder="jamescook@gmail.com" required wire:model.blur="email">
                            <div>
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-password">
                            <label for="inputPassword" class="col-form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword"
                                placeholder="Enter password" required wire:model.blue="password">
                            <div>
                                @error('password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        @if (Session::has('error'))
                            <div class="alert alert-error">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <button id="btnSignIn" type="submit" class="btn btn-primary container">Sign in</button>
                        <hr>


                    </form>

                    <button id="googleLogin" type="button" class="btn container" onclick="getToken()">
                        <i class="google-icon"></i>
                        Sign in via Google
                    </button>
                    <p class="dont-have-account text-center">Do you not have an account yet?
                        <span class="sign-up">
                            <a href="{{ url('/sign-up') }}" wire:navigate>Sign up</a>
                        </span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>