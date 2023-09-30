@section('style')
    <link rel="stylesheet" href="{{ asset('css/builder/editor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/builder/style.css') }}">
@endsection


@persist('player')
    <div id="builder">
        <livewire:navbar.navbar-builder />

        <div class="row g-0 wrapper-editor">
            <div class="col-sm-2 side-menu-left">
                <div id="pages">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Pages
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body" id="pagesBody">



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <livewire:sidebar.sidebar-left />
            </div>
            <div class="col-sm-8 position-relative">

                {{-- Editor --}}
                <div id="editor">
                    {!! $html !!}
                    <img id="marker" src="{{ asset('pictures/icon/Frame 126.png') }}"
                        class="position-absolute top-50 start-50 translate-middle" style="z-index: 0;">


                </div>

            </div>
            <div class="col-sm-2 side-menu-right">
                <livewire:sidebar.sidebar-right />
            </div>
        </div>



    </div>
@endpersist


@section('footer-script')
    <script type="module" src="{{ asset('js/builder/init.js') }}"></script>
@endsection
