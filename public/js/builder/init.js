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
        // hapus marker
        // $("#marker").remove();

        // editor();
        console.log(event.detail.component_id);
    });
};

listenerBuilder();
