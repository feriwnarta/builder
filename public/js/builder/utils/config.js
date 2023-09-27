import {
    container,
    styleBootstrap,
    jsPopperBootstrap,
    jsBootstrap,
    deviceManager,
} from "./utils.js";

const projectEndpoint = `http://127.0.0.1:8000/template/`;
const projectSaveEndpoint = `http://127.0.0.1:8000/template`;

/**
 * inisialisasi editor grapes js
 * ini akan dipanggil dan akan memuat grapes js
 */

// Dapatkan token CSRF dari meta tag
var csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

let builder;
const editor = (id) => {
    builder = grapesjs.init({
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

        layerManager: {
            appendTo: "#layerContainer",
        },

        // Default configurations
        storageManager: {
            type: "remote", // Storage type. Available: local | remote
            autosave: true, // Store data automatically
            autoload: true, // Autoload stored data on init
            stepsBeforeSave: 5, // If autosave is enabled, indicates how many changes are necessary before the store method is triggered
            options: {
                remote: {
                    urlStore: projectSaveEndpoint,
                    urlLoad: `${projectEndpoint}${id}`,
                    // The `remote` storage uses the POST method when stores data but
                    // the json-server API requires PATCH.
                    fetchOptions: (opts) =>
                        opts.method === "POST" ? { method: "POST" } : {},
                    // As the API stores projects in this format `{id: 1, data: projectData }`,
                    // we have to properly update the body before the store and extract the
                    // project data from the response result.
                    onStore: (data) => ({
                        id: id,
                        data: JSON.stringify(data),
                        _token: csrfToken,
                    }),
                    onLoad: (result) => result.data,
                },
            },
        },
        styleManager: {
            appendTo: "#styleManager",
            sectors: [
                {
                    name: "Typhography",
                    buildProps: ["font-family", "color"],
                    properties: [
                        {
                            type: "number",
                            property: "font-size",
                            label: "Size",
                            default: "0px",
                            // Additional props
                            units: ["px"],
                            min: 0,
                            max: 100,
                        },
                        {
                            type: "select",
                            property: "font-weight",
                            label: "Weight",
                            default: "normal",
                            options: [
                                { id: "bold", label: "bold" },
                                { id: "normal", label: "normal" },
                                { id: "500", label: "semi-bold" },
                            ],
                        },
                        {
                            type: "number",
                            property: "line-height",
                            label: "Line Height",
                            default: "0px",
                            // Additional props
                            units: ["px"],
                            min: 0,
                            max: 100,
                        },
                        {
                            type: "number",
                            property: "letter-spacing",
                            label: "Letter Space",
                            default: "0px",
                            // Additional props
                            units: ["px"],
                            min: 0,
                            max: 100,
                        },
                        {
                            type: "select",
                            property: "text-align",
                            label: "Align",
                            default: "left",
                            options: [
                                { id: "center", label: "Center" },
                                { id: "left", label: "Left" },
                                { id: "right", label: "Right" },
                                { id: "justify", label: "Justify" },
                            ],
                        },
                        {
                            type: "select",
                            property: "text-decoration",
                            label: "Decoration",
                            default: "none",
                            options: [
                                { id: "none", label: "None" },
                                { id: "overline", label: "Overline" },
                                { id: "line-through", label: "Line Through" },
                                { id: "underline", label: "Underline" },
                            ],
                        },
                        {
                            type: "select",
                            property: "text-transform",
                            label: "Case",
                            default: "none",
                            options: [
                                { id: "none", label: "None" },
                                { id: "uppercase", label: "Uppercase" },
                                { id: "lowercase", label: "Lowercase" },
                                { id: "capitalize", label: "Capitalize" },
                            ],
                        },
                        {
                            type: "select",
                            property: "direction",
                            label: "Direction",
                            default: "ltr",
                            options: [
                                { id: "ltr", label: "LTR" },
                                { id: "rtl", label: "RTL" },
                                { id: "initial", label: "Initial" },
                                { id: "inherit", label: "Inherit" },
                            ],
                        },
                    ],
                },
            ],
        },
    });

    // saat builder sudah diload
    builder.on("load", function () {
        initUndoManager(builder.UndoManager); // -> init undo manager
        listenerChangeDevice(builder.Devices); // -> ganti responsive device
        listenerUndo(builder.UndoManager); // -> menangani undo
        listenerRedo(builder.UndoManager); // -> menangani redo
        setPageManager(builder); // -> mengirim event data page
    });
};
export { editor, initLayerManager };

// kirim event berupa isi page
const setPageManager = (builder) => {
    const pageManager = builder.Pages;

    const newPage = pageManager.add({
        id: "new-page-id", // without an explicit ID, a random one will be created
        name: "page ke 2",
        styles: `.my-class { color: red }`, // or a JSON of styles
        component: '<div class="my-class">My element</div>', // or a JSON of components
    });

    const newPage2 = pageManager.add({
        id: "page-ke-3", // without an explicit ID, a random one will be created
        name: "page ke 3",
        styles: `.my-class2 { color: blue }`, // or a JSON of styles
        component: '<div class="my-class2">My element 3</div>', // or a JSON of components
    });

    const arrayOfPages = pageManager.getAll();

    // cetak item page di sidebar
    setItemPage(arrayOfPages, pageManager);
};

const setItemPage = (arrayOfPages, pageManager) => {
    let html = "";
    arrayOfPages.forEach((page) => {
        html += `
        <div class="item-page d-flex flex-row align-items-center justify-content-between" id="${
            page.attributes.id
        }">
            ${page.attributes.name == "" ? "Page" : page.attributes.name}
            <button class="btn">
                <i class="dot-vertical"></i>
            </button>
        </div>`;
    });

    // tampilkan isi
    $("#pagesBody").html(html);
    pageClicked(pageManager);
};

const pageClicked = (pageManager) => {
    $(".item-page").click(function () {
        const id = $(this).attr("id");

        if (pageManager !== null && pageManager !== undefined) {
            pageManager.select(id);
        }
    });
};

// rebuild page manager saat berpindah ke layer manager
const rebuildPageManager = (builder) => {
    const pageManager = builder.Pages;
    const arrayOfPages = pageManager.getAll();
};

// inisialisasi layer manager
const initLayerManager = () => {
    document.addEventListener("toggle-sidebar", (e) => {
        if (e.detail !== null || e.detail !== undefined) {
            if (!e.detail.active) {
                $("#layerContainer").show();

                return;
            }

            $("#layerContainer").hide();
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
    window.addEventListener("responsive", (event) => {
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
