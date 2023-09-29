<div>
    {{-- toogle button --}}
    <div x-data="{ active: @entangle('active') }" class="toggle-content">
        {{-- Template Toggle --}}
        <button class="btn toggle btn-icon-text-normal-text" x-bind:class="{ 'toggle-deactive': !active }"
            x-on:click="active = !active" wire:click="$dispatch('toggle-sidebar-right', {active: true})">
            Styles
        </button>

        {{-- Template layer --}}
        <button class="btn toggle btn-icon-text-normal-text" x-bind:class="{ 'toggle-deactive': active }"
            x-on:click="active = !active" wire:click="$dispatch('toggle-sidebar-right', {active: false})">
            Properties
        </button>
    </div>



    <div class="content-sidebar-right" id="styleManager">
        <div id="selectorManager"></div>
        <div id="traitManager"></div>
    </div>
</div>
