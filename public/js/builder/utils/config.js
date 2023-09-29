import {
    container,
    styleBootstrap,
    jsPopperBootstrap,
    jsBootstrap,
    deviceManager,
    appendLayerManager,
    appendSelectorManager,
    statesSelectorManager,
    appendTraitManager,
    storageType,
    sectors,
    appendBlockManager,
    appendStyleManager,
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
const editor = (id, block) => {
    builder = grapesjs.init({
        // properti ini digunakan untuk menentukan id mana yang akan menjadi tujuan grapes js untuk menginisialisasi editornya
        container: container,

        // properti ini digunakan oleh grapes js untuk menandakan bahwa didalam editor bisa langsung membaca file html dan menconvertnya
        // langsung menjadi component grapesjs secara otomatis
        fromElement: true,

        height: "100%",

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
            appendTo: appendLayerManager,
        },
        selectorManager: {
            appendTo: appendSelectorManager,
            states: statesSelectorManager,
        },
        traitManager: {
            appendTo: appendTraitManager,
        },
        blockManager: {
            appendTo: appendBlockManager,
        },
        // Default configurations
        storageManager: {
            type: storageType, // Storage type. Available: local | remote
            autosave: true, // Store data automatically
            autoload: true, // Autoload stored data on init
            stepsBeforeSave: 1, // If autosave is enabled, indicates how many changes are necessary before the store method is triggered
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
        styleManager:
            // jika !== null makan akan menampilkan semua style manager
            block !== null
                ? {
                      appendTo: appendStyleManager,
                  }
                : {
                      appendTo: appendStyleManager,
                      sectors: sectors,
                  },
    });

    // saat builder sudah diload
    builder.on("load", function () {
        initUndoManager(builder.UndoManager); // -> init undo manager
        listenerChangeDevice(builder.Devices); // -> ganti responsive device
        listenerUndo(builder.UndoManager); // -> menangani undo
        listenerRedo(builder.UndoManager); // -> menangani redo
        setPageManager(builder); // -> mengirim event data page
        changeSectorCarret();
        initBlock(block, builder);
    });

    builder.DomComponents.addType("text", {
        model: {
            defaults: {
                traits: [
                    "name",
                    "id",
                    {
                        type: "text",
                        name: "placeholder",
                        label: "Placeholder",
                    },
                    {
                        type: "select",
                        label: "Type",
                        name: "type",
                        options: [
                            { id: "text", name: "Text" },
                            { id: "email", name: "Email" },
                            { id: "password", name: "Password" },
                            { id: "number", name: "Number" },
                        ],
                    },
                    {
                        type: "checkbox",
                        name: "required",
                    },
                ],
            },
        },
    });

    builder.on("component:selected", (event) => {
        const component = builder.getSelected(); // Component
        console.log(component);

        const traits = component.get("traits");
        traits.forEach((trait) => console.log(trait.props()));
    });
};
export { editor, initLayerManager, toggleSidebarRight };

/**
 * toggleSidebarRight
 * berfungsi untuk menampilkan styles atau properties
 */
function toggleSidebarRight() {
    document.addEventListener("toggle-sidebar-right", (e) => {
        if (e.detail !== null || e.detail !== undefined) {
            if (!e.detail.active) {
                $(".gjs-sm-sectors").hide();
                $("#selectorManager").hide();
                $("#traitManager").show();
                return;
            }
            $("#traitManager").hide();
            $("#selectorManager").show();
            $(".gjs-sm-sectors").show();
        }
    });
}

function initBlock(block, builder) {
    if (block !== undefined && block !== null) {
        const blockJson = JSON.parse(block);
        const blockManager = builder.Blocks;

        Object.values(blockJson).forEach((block) => {
            blockManager.add(`${block.id}`, {
                label: block.label,
                content: block.content,
                category: block.category,
                media: block.media,
            });
        });
    }
}

/**
 * merubah icon carret dari style manager
 */
const changeSectorCarret = () => {
    // Temukan semua elemen sektor caret
    const sectorCarets = document.querySelectorAll(
        ".gjs-sm-sector-title .gjs-sm-sector-caret"
    );

    // Iterasi melalui setiap elemen dan ganti ikon SVG
    sectorCarets.forEach((sectorCaret) => {
        sectorCaret.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.23431 5.83392C4.54673 5.5215 5.05327 5.5215 5.36569 5.83392L8 8.46824L10.6343 5.83392C10.9467 5.5215 11.4533 5.5215 11.7657 5.83392C12.0781 6.14634 12.0781 6.65288 11.7657 6.96529L8.56569 10.1653C8.25327 10.4777 7.74673 10.4777 7.43431 10.1653L4.23431 6.96529C3.9219 6.65288 3.9219 6.14634 4.23431 5.83392Z" fill="#424242"/>
    </svg>
`;
    });
};

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

// inisialisasi layer manager
const initLayerManager = () => {
    document.addEventListener("toggle-sidebar", (e) => {
        if (e.detail !== null || e.detail !== undefined) {
            if (!e.detail.active) {
                $("#layerContainer").show();

                if ($("#blockManager").length) {
                    $("#blockManager").hide();
                }

                return;
            }

            if ($("#blockManager").length) {
                $("#blockManager").show();
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
