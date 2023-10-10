<div>


    {{-- toogle button --}}
    <div class="toggle-content">
        {{-- Template Toggle --}}
        @if ($modeBuilder == 'edit')
            {{-- khusus user bisnis --}}
            <button class="btn toggle btn-icon-text-normal-text {{ $active ? '' : 'toggle-deactive' }}"
                    wire:click="toggle(true)">
                <i class="{{ $active ? 'layout-icon-active' : 'layout-icon-deactive' }}"></i>
                Template
            </button>
        @else
            {{-- khusus kreator --}}
            <button class="btn toggle btn-icon-text-normal-text {{ $active ? '' : 'toggle-deactive' }}"
                    wire:click="toggle(true)">
                <i class="{{ $active ? 'layout-icon-active' : 'layout-icon-deactive' }}"></i>
                Component
            </button>
        @endif



        {{-- Template layer --}}
        <button class="btn toggle btn-icon-text-normal-text {{ !$active ? '' : 'toggle-deactive' }}"
                wire:click="toggle(false)">
            <i class="{{ !$active ? 'layer-icon-active' : 'layer-icon-deactive' }}"></i>
            Layer
        </button>

    </div>

    @if ($modeBuilder == 'create')
        {{-- khusus kreator / admin --}}
        <livewire:sidebar.sidebar-component/>
    @else
        {{-- khusus user bisnis --}}
        <livewire:sidebar.sidebar-template lazy/>
    @endif


    <livewire:sidebar.sidebar-layer/>


</div>
