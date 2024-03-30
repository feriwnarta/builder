<div id="sidebar-left-content">


    <div class="side-menu" style="{{ $active ? 'display: block;' : 'display : none;' }}">
        @foreach ($templateRepository as $repository)
            <div class="card mt-4" wire:key="{{ $repository->id }}">
                @if(empty($repository->template->thumbnail))

                @else
                    <img src="{{ asset("storage/{$repository->template->thumbnail[0]}") }}" class="card-img-top" alt="...">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $repository->template->title }}</h5>
                    <p class="card-text">{{ $repository->template->subtitle }}</p>
                    <a @click="$dispatch('load-template', {id: '{{ $repository->template->id }}'})" class="btn btn-primary">Try it</a>
                </div>
            </div>

{{--            <button wire:key="{{ $repository->id }}" class="btn btn-menu-item"--}}
{{--                @click="$dispatch('load-template', {id: '{{ $repository->template->id }}'})">{{ $repository->template->title }}</button>--}}
        @endforeach
    </div>

</div>
