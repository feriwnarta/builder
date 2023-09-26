// File ini digunakan sebagai tempat inisialisasi editor grape js
// Grapes js documentation -> https://grapesjs.com/docs/

/**
 * Import terlebih dahulu config js
 * detail inisialisasi editor berada difile config js
 */
import { editor } from "./utils/config.js";
// editor();

const listenerBuilder = () => {
    document.addEventListener("init-builder", (event) => {
        $(document).ready(function () {
            //! perbaiki ini untuk menampilkan pesan error ke user
            if (
                event.detail.component_id === null ||
                event.detail.component_id === undefined
            )
                return null;

            const id = event.detail.component_id;

            // kosongkan editor
            $("#editor").empty();

            // load editor
            editor(id);
        });
    });
};

listenerBuilder();
