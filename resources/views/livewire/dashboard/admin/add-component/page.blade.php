<div id="page">

    <h1 class="mb-5">Tambah Component</h1>

    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @elseif(Session::has('error'))
        <div class="alert alert-error">
            {{ Session::get('error') }}
        </div>
    @endif


    <form wire:submit="saveComponent">
        <div class="mb-3">
            <select class="form-select" wire:model="idCategory">
                <option selected>Kategori</option>

                @foreach ($categories as $category)
                    <option wire:key="{{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('idCategory')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputText" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputText" wire:model="name">
            <div>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="inputMedia" class="form-label">Media</label>
            <input type="text" class="form-control" id="inputMedia" wire:model="media">
            <div>
                @error('media')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Masukan HTML" id="textAreaHtml" style="height: 100px"
                    wire:model="componentHtml"></textarea>
                <label for="textAreaHtml">Masukan HTML</label>
            </div>
            <div>
                @error('componentHtml')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
