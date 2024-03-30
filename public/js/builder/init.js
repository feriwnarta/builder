// File ini digunakan sebagai tempat inisialisasi editor grape js
// Grapes js documentation -> https://grapesjs.com/docs/

/**
 * Import terlebih dahulu config js
 * detail inisialisasi editor berada difile config js
 */
import {
    editor,
    initLayerManager,
    toggleSidebarRight,
} from "./utils/config.js";

// Buat variabel boolean untuk melacak apakah event listener sudah dibuat
let listenerCreated = false;

const listenerBuilder = () => {
    if (!listenerCreated) {
        document.addEventListener("init-builder", (event) => {
            $(document).ready(function () {
                //! perbaiki ini untuk menampilkan pesan error ke user
                if (
                    event.detail.component_id === null ||
                    event.detail.component_id === undefined
                    || event.detail.id === null || event.detail.id === undefined
                )
                    return null;

                // kosongkan editor
                $("#editor").empty();

                const id = event.detail.component_id;
                const block = event.detail.block;
                const userId = event.detail.id;

                // load editor
                editor(id, block, userId);

                return;
            });
        });
        listenerCreated = true; // Set variabel ini menjadi true untuk menandakan bahwa listener sudah dibuat
    }
};

// jalanakan listener builder saat livewire menavigasikan spa
document.addEventListener("livewire:navigating", () => {
    listenerBuilder();

    // inisialisasi layer manager
    initLayerManager();

    // inisialisasi sidebar right
    toggleSidebarRight();
});

// jalankan listener saat builder direfresh dan setelah livewire menavigasikan spa
if (!listenerCreated) {
    listenerBuilder();

    // inisialisasi layer manager
    initLayerManager();

    // inisialisasi sidebar right
    toggleSidebarRight();
}
