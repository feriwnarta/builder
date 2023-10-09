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
            //! perbaiki ini untuk menampilkan pesan error ke user
            if (
                event.detail.component_id === null ||
                event.detail.component_id === undefined
            )
                return null;

            const id = event.detail.component_id;
            const block = event.detail.block;

            // kosongkan editor
            $("#editor").empty();

            // load editor
            editor(id, block);

            // inisialisasi layer manager
            initLayerManager();

            toggleSidebarRight();
            return;
        });
        listenerCreated = true; // Set variabel ini menjadi true untuk menandakan bahwa listener sudah dibuat
    }
};

// jalanakan listener builder saat livewire menavigasikan spa
document.addEventListener("livewire:navigating", () => {
    listenerBuilder();
});

// jalankan listener saat builder direfresh dan setelah livewire menavigasikan spa

if (!listenerCreated) {
    listenerBuilder();
}
