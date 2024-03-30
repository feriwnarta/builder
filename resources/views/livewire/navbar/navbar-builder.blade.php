<nav class="navbar navbar-builder navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid" style="padding: 0px;">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('pictures/icon/Microkit.svg') }}" alt="logo microkit" width="132px" height="44px">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">

            <div class="navbar-nav me-auto">

                <div class="wrapper-responsive-btn">
                    {{-- button responsive desktop --}}
                    <button class="btn" @click="$dispatch('responsive', {device: 'desktop'})">
                        <i class="desktop-responsive-icon"></i>
                    </button>

                    {{-- button responsive tablet --}}
                    <button class="btn" @click="$dispatch('responsive', {device: 'tablet'})">
                        <i class="tablet-responsive-icon"></i>
                    </button>

                    {{-- button responsive mobile --}}
                    <button class="btn" @click="$dispatch('responsive', {device: 'mobile'})">
                        <i class="mobile-responsive-icon"></i>
                    </button>
                </div>

            </div>


            <div class="nav-action d-flex flex-row">
                <div class="action-one">
                    {{-- button trash --}}
                    <button class="btn">
                        <i class="trash-icon"></i>
                    </button>

                    {{-- button undo --}}
                    <button class="btn" @click="$dispatch('undo')">
                        <i class="undo-icon"></i>
                    </button>

                    {{-- button redo --}}
                    <button class="btn" @click="$dispatch('redo')">
                        <i class="redo-icon"></i>
                    </button>

                    {{-- theme change --}}
                    <button class="btn dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="theme-mode-icon"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </button>
                </div>

                <div class="action-two d-flex flex-row">
                    <button class="btn btn-icon-text-outlined">
                        Preview
                    </button>

                    <button class="btn btn-icon-text-outlined" style="margin-left: 16px"
                            wire:click="$dispatch('publish')">
                        Publish
                    </button>

                </div>
            </div>
        </div>

    </div>


</nav>
