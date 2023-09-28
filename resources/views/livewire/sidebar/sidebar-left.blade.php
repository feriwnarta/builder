<div>


    {{-- toogle button --}}
    <div class="toggle-content">
        {{-- Template Toggle --}}

        {{-- khusus user bisnis --}}
        {{-- <button class="btn toggle btn-icon-text-normal-text {{ $active ? '' : 'toggle-deactive' }}"
            wire:click="toggle(true)">
            <i class="{{ $active ? 'layout-icon-active' : 'layout-icon-deactive' }}"></i>
            Template
        </button> --}}


        {{-- khusus kreator--}}
        <button class="btn toggle btn-icon-text-normal-text {{ $active ? '' : 'toggle-deactive' }}"
            wire:click="toggle(true)">
            <i class="{{ $active ? 'layout-icon-active' : 'layout-icon-deactive' }}"></i>
            Component
        </button>

        {{-- Template layer --}}
        <button class="btn toggle btn-icon-text-normal-text {{ !$active ? '' : 'toggle-deactive' }}"
            wire:click="toggle(false)">
            <i class="{{ !$active ? 'layer-icon-active' : 'layer-icon-deactive' }}"></i>
            Layer
        </button>

    </div>

    {{-- Content dinamis --}}
    {{-- @if ($active)
        <livewire:sidebar.sidebar-template lazy />
    @else
        <livewire:sidebar.sidebar-layer lazy />
    @endif --}}

    {{-- khusus user bisnis --}}
    {{-- <livewire:sidebar.sidebar-template lazy />  --}}

    {{-- khusus kreator --}}
    <livewire:sidebar.sidebar-component lazy />
    <livewire:sidebar.sidebar-layer />


</div>
