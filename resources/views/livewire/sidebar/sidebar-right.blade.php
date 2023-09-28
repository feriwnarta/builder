<div>
    {{-- toogle button --}}
    <div class="toggle-content">
        {{-- Template Toggle --}}
        <button class="btn toggle btn-icon-text-normal-text {{ $active ? '' : 'toggle-deactive' }}"
            wire:click="toggle(true)">
            Styles
        </button>

        {{-- Template layer --}}
        <button class="btn toggle btn-icon-text-normal-text {{ !$active ? '' : 'toggle-deactive' }}"
            wire:click="toggle(false)">
            Properties
        </button>

    </div>


    <div class="content-sidebar-right" id="styleManager">
        <div id="selectorManager"></div>
        
    </div>
</div>
