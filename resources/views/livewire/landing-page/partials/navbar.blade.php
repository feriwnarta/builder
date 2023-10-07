<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('image/MicroKit.svg') }}" alt="" width="125" height="auto"
                class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                {{-- user is login --}}
                @if (isset(auth()->user()->email))
                    <div class="user-login">
                        <div class="d-flex flex-row justify-content-between d-sm-none">
                            <img src="{{ asset('image/MicroKit.svg') }}" alt="" width="125" height="auto"
                                class="d-inline-block align-text-top">
                            <!-- Tombol Close -->
                            <button class="btn-close" type="button" data-bs-target="#navbarNavAltMarkup"
                                aria-label="Close"></button>
                        </div>

                        <div class="d-flex flex-row align-items-center profile-data d-none d-sm-flex"
                            id="profilePopOver">
                            <div class="name-profile">Hi, {{ auth()->user()->name }}</div>
                            <img src="{{ auth()->user()->picture }}" alt="" referrerpolicy="no-referrer"
                                class="img-profile rounded-circle" />
                        </div>

                        <div class="d-flex flex-row align-items-center profile-data d-sm-none">
                            <div class="name-profile">Hi, {{ auth()->user()->name }}</div>
                            <img src="{{ auth()->user()->picture }}" alt="" referrerpolicy="no-referrer"
                                class="img-profile rounded-circle" />
                        </div>


                        {{-- popper data --}}
                        <div id="profileContent" class="d-sm-none d-flex flex-column align-items-start">
                            <div>
                                <a href="download">Download (0)</a>
                            </div>

                            <div>
                                <a href="profile-setting">Profile Setting</a>
                            </div>

                            <div>
                                <a href="sign-out">Sign Out</a>
                            </div>
                        </div>
                    </div>

                    <div class="container bg-primary-surface end-footer2-mobile d-none">
                        <div class="text-center copyright">
                            © 2022 MicroKit by Microconn. All rights reserved.
                        </div>
                    </div>
                @else
                    {{-- user not login --}}
                    <div class="container user-no-login">



                        <div class="d-flex flex-row justify-content-between d-sm-none">
                            <img src="{{ asset('image/MicroKit.svg') }}" alt="" width="125" height="auto"
                                class="d-inline-block align-text-top">
                            <!-- Tombol Close -->
                            <button class="btn-close" type="button" data-bs-target="#navbarNavAltMarkup"
                                aria-label="Close"></button>
                        </div>


                        <div class="d-sm-flex flex-row">


                            <div class="d-sm-none">


                                <img src="{{ asset('image/mobile-regis-illustration.png') }}" alt=""
                                    srcset="" class="img-no-login img-fluid">

                                <div class="text-no-login">Register your account and get ready to experience
                                    the
                                    ease and
                                    speed of building your
                                    own website!</div>

                            </div>

                            <a href="/sign-in" wire:navigate>
                                <button class="btn btn-primary me-lg-3 button-secondary">Sign
                                    In</button>
                            </a>

                            <a href="/sign-up" wire:navigate>
                                <button class="btn btn-primary button-primary container-fluid">Sign Up</button>
                            </a>


                        </div>



                    </div>

                    <div class="container bg-primary-surface end-footer-mobile d-sm-none">
                        <div class="text-center copyright">
                            © 2022 MicroKit by Microconn. All rights reserved.
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</nav>
