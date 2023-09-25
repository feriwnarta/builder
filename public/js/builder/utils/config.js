import {
    container,
    styleBootstrap,
    jsPopperBootstrap,
    jsBootstrap,
    deviceManager,
} from "./utils.js";

const projectID = 1;
const projectEndpoint = `http://127.0.0.1:8000/template/${projectID}`;
const projectSaveEndpoint = `http://127.0.0.1:8000/template`;

/**
 * inisialisasi editor grapes js
 * ini akan dipanggil dan akan memuat grapes js
 */

// Dapatkan token CSRF dari meta tag
var csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

const editor = () => {
    const builder = grapesjs.init({
        // properti ini digunakan untuk menentukan id mana yang akan menjadi tujuan grapes js untuk menginisialisasi editornya
        container: container,

        // properti ini digunakan oleh grapes js untuk menandakan bahwa didalam editor bisa langsung membaca file html dan menconvertnya
        // langsung menjadi component grapesjs secara otomatis
        fromElement: true,

        // storage manager digunakan untuk menyimpan hasil edit yang berlangsung di editor
        storageManager: false,

        // digunakan untuk membuat panel grapesjs
        panels: { defaults: [] },

        deviceManager: {
            default: "",
            devices: deviceManager,
        },
        canvas: {
            styles: [styleBootstrap],
            scripts: [jsBootstrap, jsPopperBootstrap],
        },

        // Default configurations
        storageManager: {
            type: "remote", // Storage type. Available: local | remote
            autosave: true, // Store data automatically
            autoload: true, // Autoload stored data on init
            stepsBeforeSave: 3, // If autosave is enabled, indicates how many changes are necessary before the store method is triggered
            options: {
                remote: {
                    urlStore: projectSaveEndpoint,
                    urlLoad: projectEndpoint,
                    // The `remote` storage uses the POST method when stores data but
                    // the json-server API requires PATCH.
                    fetchOptions: (opts) =>
                        opts.method === "POST" ? { method: "POST" } : {},
                    // As the API stores projects in this format `{id: 1, data: projectData }`,
                    // we have to properly update the body before the store and extract the
                    // project data from the response result.
                    onStore: (data) => ({
                        id: 1,
                        data: JSON.stringify(data),
                        _token: csrfToken,
                    }),
                    onLoad: (result) => result.data,
                },
            },
        },
    });

    // saat builder sudah diload
    builder.on("load", function () {
        // listenerBuilder();
        listenerLoadTemplate(); // -> load template
        initUndoManager(builder.UndoManager); // -> init undo manager
        listenerChangeDevice(builder.Devices); // -> ganti responsive device
        listenerUndo(builder.UndoManager); // -> menangani undo
        listenerRedo(builder.UndoManager); // -> menangani redo

        // Get current project data
        const projectData = builder.getProjectData();
        console.log(projectData);

        builder.store();
    });
};
export { editor };

const listenerBuilder = () => {
    document.addEventListener("init-builder", (event) => {
        editor();

        $("#loadTemplate").remove();
    });
};

/**
 * fungsi ini digunakan sebagai listener saat menu item diklik
 * fungsi ini akan menutup editor / builder dengan template yang dimuat dari database
 */
const listenerLoadTemplate = () => {
    document.addEventListener("load-template", (event) => {
        if (event !== null && event !== undefined) {
            const id = event.detail.id;

            // $("#componentLoad").css({
            //     width: "100%",
            //     height: "100%",
            //     backgroundColor: "#F5F6F8",
            // });

            // // Mengganti kontennya dengan teks "load"
            // $("#componentLoad").html("<h1>load</h1>");
        }
    });
};

/**
 * fungsi ini digunakan sebagai inisialisasi undo manager (ini digunakan sebagai penggunaan
 * undo redo)
 */
const initUndoManager = (undoManager) => {
    // memulai undo / redo
    undoManager.start();
};

/**
 * fungsi ini akan dijalankan ketika user mengklik button responsive device dengan menerima paramter type
 * parameter type akan berisi (mobile, tablet, desktop)
 * setelah dijalankan fungsi ini akan memanggil device manager bootstrap
 * dan akan merubah lebar frame sesuai apa yang kita pilih
 */
function listenerChangeDevice(deviceManager) {
    // menambahkan even listener saat button responsive dinavbar diklik
    document.addEventListener("responsive", (event) => {
        if (event !== null && event !== undefined) {
            const device = event.detail.device;

            deviceManager.select(device);
        }
    });
}

/**
 * fungsi ini digunakan sebagai listener saat button undo di navbar diklik
 * undo akan mengembalikan perubahan yang sebelumnya terjadi di builder grapes js
 */
const listenerUndo = (undoManager) => {
    document.addEventListener("undo", (event) => {
        if (undoManager !== null && undoManager !== undefined) {
            if (undoManager.hasUndo()) {
                undoManager.undo();
            }
        }
    });
};

/**
 * fungsi ini digunakan sebagai listener saat button redo di navbar diklik
 * redo akan mengembalikan perubahan keversi terbaru sebelum undo dijalankan
 */
const listenerRedo = (undoManager) => {
    document.addEventListener("redo", (event) => {
        if (undoManager !== null && undoManager !== undefined) {
            if (undoManager.hasRedo()) {
                undoManager.redo();
            }
        }
    });
};
