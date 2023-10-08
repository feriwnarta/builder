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
// editor();


const listenerBuilder = () => {

    document.addEventListener("init-builder", (event) => {
        $(document).ready(function () {
            console.log('load');
            console.log(event.detail);

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
            return;
        });

        // jika user sebagai kreator
    });
};


listenerBuilder();

// inisialisasi layer manager
initLayerManager();

toggleSidebarRight();





