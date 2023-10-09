@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme/theme.css') }}">
@endsection

<div id="wrapper">

    <livewire:admin.components.sidebar />

    <div id="content">

        <livewire:admin.components.navbar></livewire:admin.components.navbar>

        <div id="page">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-error">
                    {{ Session::get('error') }}
                </div>
            @endif
            <form wire:submit="saveCategory">
                <div class="mb-3">
                    <label for="inputText" class="form-label">Name</label>
                    <input type="text" class="form-control" id="inputText" wire:model="nameCategory">
                    <div>
                        @error('nameCategory')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>

    </div>
</div>
