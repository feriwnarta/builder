@section('style')
    <link rel="stylesheet" href="{{ asset('css/builder/editor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/builder/style.css') }}">
@endsection


<div id="builder">
    <livewire:navbar.navbar-builder />



    <div class="row g-0" style="height: 100vh;">
        <div class="col-sm-2 side-menu-left">
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
        <div class="col-sm-2 side-menu-right">sidebar style</div>
    </div>



</div>


@section('footer-script')
    <script type="module" src="{{ asset('js/builder/init.js') }}"></script>
@endsection
