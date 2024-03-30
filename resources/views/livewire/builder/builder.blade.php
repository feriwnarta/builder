@section('style')
    <link rel="stylesheet" href="{{ asset('css/builder/editor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/builder/style.css') }}">
@endsection

<div id="builder">
    <livewire:navbar.navbar-builder/>

    <div class="row g-0 wrapper-editor">
        <div class="col-sm-2 side-menu-left">
            <div id="pages">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header d-flex flex-row align-item-center justify-content-center"
                            id="headingTwo">
                            <button class="accordion-button collapsed d-flex flex-row justify-content-between">

                                Pages

                                <div class="d-flex flex-row align-items-center">
                                    <a class="btn add-pages d-flex flex-row" style="padding: 0px;"
                                       @click="$dispatch('add-page')">
                                        <i class="plus-icon"></i>
                                    </a>

                                    <a class="btn open-collapse d-flex flex-row" data-bs-toggle="collapse"
                                       data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                                       style="padding: 0px;">
                                    </a>


                                </div>
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

            <livewire:sidebar.sidebar-left :modeBuilder="$modeBuilder"/>
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
            <livewire:sidebar.sidebar-right/>
        </div>


        @can('make-template')
            <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop"
                 aria-labelledby="staticBackdropLabel" wire:ignore.self>
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="staticBackdropLabel">Create new template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                        <div class="d-flex flex-column align-self-center align-items-center">
                            <label for="floatingInput">Thumbnail</label>
                            @if ($thumbnail && !$errors->has('$thumbnail'))
                                <img src="{{ $thumbnail->temporaryUrl() }}" width="221" height="221"
                                     @click="document.getElementById('fileInput').click()"
                                >
                            @else
                                <img
                                    src="{{ asset('image/no-image.png') }}"
                                    alt="" srcset="" width="140" @click="document.getElementById('fileInput').click()">
                            @endif
                            <div wire:loading wire:target.prevent="thumbnail">Uploading...</div>
                            @error('thumbnail') <span class="error">{{ $message }}</span> @enderror


                            <input type="file" id="fileInput" wire:model="thumbnail"
                                   style="display: none;"
                                   accept="image/*">

                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Title</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Subtitle</label>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>
