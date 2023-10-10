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
const editor = async (id, block) => {

    if (builder !== undefined && builder !== null) {


    }

    builder = grapesjs.init({
        // properti ini digunakan untuk menentukan id mana yang akan menjadi tujuan grapes js untuk menginisialisasi editornya
        container: container,

        // properti ini digunakan oleh grapes js untuk menandakan bahwa didalam editor bisa langsung membaca file html dan menconvertnya
        // langsung menjadi component grapesjs secara otomatis
        fromElement: true,

        height: "100%",

        // digunakan untuk membuat panel grapesjs
        panels: {defaults: []},

        deviceManager: {
            devices: deviceManager,
        },
        showOffsets: true,
        showOffsetsSelected: true,
        noticeOnUnload: true,
        canvas: {
            styles: [styleBootstrap],
            scripts: [jsBootstrap, jsPopperBootstrap],
        },

        layerManager: (builder !== undefined && builder !== null) ? {} : {
            appendTo: appendLayerManager,
        },
        selectorManager: (builder !== undefined && builder !== null) ? {} : {
            appendTo: appendSelectorManager,
            states: statesSelectorManager,
        },
        traitManager: {
            appendTo: appendTraitManager,
        },
        blockManager: (block == null) ? {} : {
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
                        opts.method === "POST" ? {method: "POST"} : {},
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
        styleManager: (builder !== undefined && builder !== null) ? {} :
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
        setDesktopDeviceManager();
        listenerUndo(builder.UndoManager); // -> menangani undo
        listenerRedo(builder.UndoManager); // -> menangani redo
        setPageManager(builder); // -> mengirim event data page
        changeSectorCarret();
        initBlock(block, builder);
        addPage(builder);
        initPopOver();
    });

    builder.on("component:selected", (event) => {
        const component = builder.getSelected(); // Component

        const pageManager = builder.Pages;
        const arrayOfPages = pageManager.getAll();

        // Get a single property
        const tagName = component.get("tagName");

        if (tagName == "a") {
            component.addTrait(
                {
                    type: "select",
                    name: "linkType",
                    label: "Link Type",
                    options: [
                        {id: "internal", name: "Internal Page"},
                        {id: "external", name: "External URL"},
                        {id: "elementId", name: "Element ID"},
                    ],
                },
                {at: 0}
            );
            component.addTrait(
                {
                    type: "text",
                    name: "pageName",
                    label: "Page Name",
                    // Tampilkan ini hanya jika linkType dipilih sebagai 'Internal Page'
                    show: {eq: "internal", at: "linkType"},
                },
                {at: 1}
            );
            component.addTrait(
                {
                    type: "text",
                    name: "externalUrl",
                    label: "External URL",
                    // Tampilkan ini hanya jika linkType dipilih sebagai 'External URL'
                    show: {eq: "external", at: "linkType"},
                },
                {at: 2}
            );
            component.addTrait(
                {
                    type: "select",
                    label: "Internal Page",
                    name: "internalPage",
                    options: arrayOfPages.map((page) => ({
                        id: page.id,
                        name: page.attributes.name,
                    })),
                    visible: (model) =>
                        model.get("traits").get("linkType") === "internal",
                },
                {at: 3}
            );
        }
    });
};
export {editor, initLayerManager, toggleSidebarRight};


const setDesktopDeviceManager = () => {
    let userDeviceWidth = window.innerWidth;
    const desktopSize = getDeviceManagerDesktopSize();

    if (userDeviceWidth == null || desktopSize == null) {
        return;
    }

    if (userDeviceWidth < desktopSize) {
        // Mengatur lebar frame sesuai dengan ukuran desktop
        $(".gjs-cv-canvas").css({
            width: `${desktopSize}px`,
            height: `${(desktopSize / 16) * 9}px`,
        });

        // Mendapatkan lebar sidebar kiri & kanan
        const sideMenuLeft = $(".side-menu-left").outerWidth(true);
        const sideMenuRight = $(".side-menu-right").outerWidth(true);

        // Menghitung skala berdasarkan lebar viewport
        userDeviceWidth = userDeviceWidth - sideMenuLeft - sideMenuRight;
        const scale = userDeviceWidth / desktopSize;

        // Mengatur skala dan transform-origin
        $(".gjs-cv-canvas").css({
            transform: `scale(${scale})`,
            "transform-origin": "left top",
        });
    }
};

const getDeviceManagerDesktopSize = () => {
    let desktopSize = deviceManager.find(function (obj) {
        return obj.name == "Desktop";
    });

    desktopSize = parseInt(desktopSize.width.replace("px", ""));
    return desktopSize;
};

let lastPopOver = null;

const pagePopOverListener = (builder) => {
    $(".btn-dot").on("shown.bs.popover", function () {
        if (lastPopOver == null) {
            // simpan dulu id popover pertama kali
            lastPopOver = $(this).attr("aria-describedby");
        }

        // ambil id popover terbaru
        const thisPopOver = $(this).attr("aria-describedby");

        // tutup popover jika id yang lama dan baru tidak sama
        if (thisPopOver !== lastPopOver) {
            $(`#${lastPopOver}`).removeClass("show");
        }

        renamePage(builder);
        deletePage(builder);
        duplicatePage(builder);

        // simpan popover yang baru terbuka sebagai popover lama
        lastPopOver = thisPopOver;
    });
};

const duplicatePage = (builder) => {
    $(".btn-dot-page-duplicate").click(function (e) {
        if (builder !== null || builder !== undefined) {
            // dismis popover
            dismisPopOver();

            const id = $(this).attr("id");

            // cari page
            const targetPage = builder.Pages.get(id);

            const component = targetPage.getMainComponent().toHTML();

            // tambahkan page bari
            const page = builder.Pages.add({
                name: targetPage.attributes.name + "-(copy)",
                component: component,
            });

            // tampilkan page baru
            setPageManager(builder);

            //ambil element berdasarkan id baru
            const newPage = $("#pagesBody").find(`#${page.id}`);

            // buat page baru menjadi editable dan focus
            setNewName(builder, page.id, newPage);
        }
    });
};

const deletePage = (builder) => {
    $(".btn-dot-page-delete").click(function (e) {
        if (builder !== null || builder !== undefined) {
            // dismis popover
            dismisPopOver();

            const id = $(this).attr("id");

            builder.Pages.remove(id);

            setPageManager(builder);
        }
    });
};

/**
 * rename page
 */
const renamePage = (builder) => {
    $(".btn-dot-page-rename").click(function (e) {
        // dismis popover
        dismisPopOver();

        const id = $(this).attr("id");
        const element = $("#pagesBody").find(`#${id}`);

        // set nama baru untuk page
        setNewName(builder, id, element);
    });
};

const setNewName = (builder, id, element) => {
    // Mengubah elemen menjadi dapat diedit
    element.attr("contentEditable", true);
    element.focus();

    // Menangani tombol Enter
    element.on("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            element.blur(); // Menghilangkan fokus untuk menyebabkan blur event
        }
    });

    // Menangani saat elemen kehilangan fokus
    element.on("blur", function () {
        var newName = element.text();

        // Mengembalikan elemen menjadi tidak dapat diedit
        element.attr("contentEditable", false);

        // ubah nama page
        const page = builder.Pages.get(id);
        page.setName(newName);
    });
};

const initPopOver = () => {
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );
};

const dismisPopOver = () => {
    // Menutup popover yang terbuka
    const popovers = document.querySelectorAll(".popover.show");
    popovers.forEach(function (popover) {
        popover.classList.remove("show");
        // Hapus elemen dari DOM jika diperlukan
        popover.remove();
    });
};

const addPage = (builder) => {
    document.addEventListener("add-page", (e) => {
        let pageManager;
        if (builder !== null || builder !== undefined) {
            pageManager = builder.Pages;
        }

        if (pageManager !== null || pageManager !== undefined) {
            pageManager.add({});

            // tampilkan list page ke accordion
            setPageManager(builder);
        }
    });
};

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
                open: false,
            });
        });

        // set block not open
        const blockCategories = builder.BlockManager.getCategories();
        blockCategories.each((category) => category.set("open", false));
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
    const arrayOfPages = pageManager.getAll();

    // cetak item page di sidebar
    setItemPage(arrayOfPages, pageManager, builder);
    initPopOver();
};

const setItemPage = (arrayOfPages, pageManager, builder) => {
    let html = "";
    arrayOfPages.forEach((page) => {
        html += `
        <div class="item-page d-flex flex-row align-items-center justify-content-between" id="${
            page.attributes.id
        }">
            <p class="item-page-content">
                ${page.attributes.name == "" ? "Page" : page.attributes.name}
            </p>

            <button class="btn btn-dot" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content='
            <div class="d-flex flex-column align-items-start">

                <a class="btn btn-dot-page-rename" id="${
            page.attributes.id
        }">Rename</a>
                <div class="btn-dot-page-divider"></div>
                <a class="btn btn-dot-page-duplicate" id="${
            page.attributes.id
        }">Duplicate</a>
                <div class="btn-dot-page-divider"></div>
                <a  class="btn btn-dot-page-delete" id="${
            page.attributes.id
        }">Delete</a>

            </div>'
            data-bs-html="true">
            <i class="dot-vertical"></i>
            </button>

        </div>`;
    });

    // tampilkan isi
    $("#pagesBody").empty();
    $("#pagesBody").html(html);
    pagePopOverListener(builder);
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

            const userDeviceWidth = window.innerWidth;
            const desktopSizeDeviceManager = getDeviceManagerDesktopSize();

            if (
                userDeviceWidth == null ||
                (desktopSizeDeviceManager == null && userDeviceWidth == null) ||
                userDeviceWidth == undefined
            ) {
                deviceManager.select(device);
                return;
            }

            let isSmallUserDevice = false;
            if (userDeviceWidth < desktopSizeDeviceManager) {
                isSmallUserDevice = true;
            }

            if (
                device == "tablet" ||
                (device == "mobile" && isSmallUserDevice)
            ) {
                $(".gjs-cv-canvas").css({
                    width: ``,
                });

                // Mengatur skala dan transform-origin
                $(".gjs-cv-canvas").css({
                    transform: `none`,
                    "transform-origin": "initial",
                });
            }

            if (device == "desktop" && isSmallUserDevice) {
                // set dekstop
                setDesktopDeviceManager();
            }

            deviceManager.select(device);
            return;
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
