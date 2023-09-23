import {
    container,
    styleBootstrap,
    jsPopperBootstrap,
    jsBootstrap,
    deviceManager,
} from "./utils.js";


/**
 * inisialisasi editor grapes js
 * ini akan dipanggil dan akan memuat grapes js
 */
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
            default: '',
            devices: deviceManager
        },
        canvas: {
            styles: [styleBootstrap],
            scripts: [jsBootstrap, jsPopperBootstrap],
        },
    });


    // saat builder sudah diload
    builder.on("load", function () {
        initUndoManager(builder.UndoManager); // -> init undo manager
        listenerChangeDevice(builder.Devices) // -> ganti responsive device
        listenerUndo(builder.UndoManager); // -> menangani undo
        listenerRedo(builder.UndoManager); // -> menangani redo

    });





};
export { editor };


/**
 * fungsi ini digunakan sebagai inisialisasi undo manager (ini digunakan sebagai penggunaan
 * undo redo)
 */
const initUndoManager = (undoManager) => {
    // memulai undo / redo
    undoManager.start();
}

/**
 * fungsi ini akan dijalankan ketika user mengklik button responsive device dengan menerima paramter type
 * parameter type akan berisi (mobile, tablet, desktop)
 * setelah dijalankan fungsi ini akan memanggil device manager bootstrap
 * dan akan merubah lebar frame sesuai apa yang kita pilih
 */
function listenerChangeDevice(deviceManager) {
    // menambahkan even listener saat button responsive dinavbar diklik
    document.addEventListener('responsive', event => {
        if (event !== null && event !== undefined) {
            const device = event.detail.device;

            deviceManager.select(device);
        }


    })
}

/**
 * fungsi ini digunakan sebagai listener saat button undo di navbar diklik
 * undo akan mengembalikan perubahan yang sebelumnya terjadi di builder grapes js
 */
const listenerUndo = (undoManager) => {

    document.addEventListener('undo', event => {
        if (undoManager !== null && undoManager !== undefined) {
            if (undoManager.hasUndo()) {
                undoManager.undo();
            }
        }
    });
}

/**
 * fungsi ini digunakan sebagai listener saat button redo di navbar diklik
 * redo akan mengembalikan perubahan keversi terbaru sebelum undo dijalankan
 */
const listenerRedo = (undoManager) => {

    document.addEventListener('redo', event => {
        if (undoManager !== null && undoManager !== undefined) {
            if (undoManager.hasRedo()) {
                undoManager.redo();
            }
        }
    });
}
