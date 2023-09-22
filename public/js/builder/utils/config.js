import {
    container,
    styleBootstrap,
    jsPopperBootstrap,
    jsBootstrap,
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

        canvas: {
            styles: [styleBootstrap],
            scripts: [jsBootstrap, jsPopperBootstrap],
        },
    });

    builder.on("load", function () {
        // Dapatkan objek canvas melalui API GrapesJS
        const canvas = builder.Canvas;

        // Dapatkan elemen head dalam objek canvas
        const canvasHead = canvas.getDocument().head;
        canvasHead.insertAdjacentHTML(
            "afterbegin",
            `<meta charset="UTF-8">
            <meta name="viewport" content="width=1200">`
        );
    });
};

export { editor };
