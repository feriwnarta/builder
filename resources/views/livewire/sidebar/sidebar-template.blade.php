<div id="sidebar-left-content">


    <div class="side-menu">

        @foreach ($categories as $category)
            <button wire:key="{{ $category['id'] }}" class="btn btn-menu-item"
                @click="$dispatch('load-template', {id: {{ $category['id'] }}})">{{ $category['title'] }}</button>
        @endforeach
    </div>



</div>
