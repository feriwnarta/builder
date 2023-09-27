<div id="sidebar-left-content">


    <div class="side-menu" style="{{ $active ? 'display: block;' : 'display : none;' }}">
        @foreach ($categories as $category)
            <button wire:key="{{ $category->id }}" class="btn btn-menu-item"
                @click="$dispatch('load-template', {id: '{{ $category->id }}'})">{{ $category->name }}</button>
        @endforeach
    </div>

</div>
