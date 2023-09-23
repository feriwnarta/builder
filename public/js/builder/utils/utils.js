const container = "#editor";


// device manager
const deviceManager = [
    {
        id: 'desktop',
        name: 'Desktop',
        width: '',
    },
    {
        id: 'tablet',
        name: 'Tablet',
        width: '770px',
        widthMedia: '992px',
    },
    {
        id: 'mobileLandscape',
        name: 'Mobile landscape',
        width: '568px',
        widthMedia: '768px',
    },
    {
        id: 'mobile',
        name: 'Mobile portrait',
        width: '320px',
        widthMedia: '480px',
    },
];

// style & js bootstrap
const styleBootstrap =
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css";
const jsBootstrap =
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js";
const jsPopperBootstrap =
    "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js";

export { container, styleBootstrap, jsBootstrap, jsPopperBootstrap, deviceManager };
