const container = "#editor";

// device manager
const deviceManager = [
    {
        id: "desktop",
        name: "Desktop",
        width: "1440px",
        widthMedia: "1200px",
    },
    {
        id: "tablet",
        name: "Tablet",
        width: "770px",
        widthMedia: "992px",
    },
    {
        id: "mobileLandscape",
        name: "Mobile landscape",
        width: "568px",
        widthMedia: "768px",
    },
    {
        id: "mobile",
        name: "Mobile portrait",
        width: "320px",
        widthMedia: "480px",
    },
];

// style & js bootstrap
const styleBootstrap =
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css";
const jsBootstrap =
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js";
const jsPopperBootstrap =
    "http://127.0.0.1:8000/css/bootstrap/popper.js";

//  layer manager
const appendLayerManager = "#layerContainer";

// selecttor manager
const appendSelectorManager = "#selectorManager";
const statesSelectorManager = [
    {name: "hover"},
    {name: "active"},
    {name: "nth-of-type(2n)"},
];

// trait manager
const appendTraitManager = "#traitManager";

// block manager
const appendBlockManager = "#blockManager";

// storage manager
const storageType = "remote";

// style manager
const appendStyleManager = "#styleManager";
const sectors = [
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
                    {id: "bold", label: "bold"},
                    {id: "normal", label: "normal"},
                    {id: "500", label: "semi-bold"},
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
                    {id: "center", label: "Center"},
                    {id: "left", label: "Left"},
                    {id: "right", label: "Right"},
                    {id: "justify", label: "Justify"},
                ],
            },
            {
                type: "select",
                property: "text-decoration",
                label: "Decoration",
                default: "none",
                options: [
                    {id: "none", label: "None"},
                    {id: "overline", label: "Overline"},
                    {
                        id: "line-through",
                        label: "Line Through",
                    },
                    {
                        id: "underline",
                        label: "Underline",
                    },
                ],
            },
            {
                type: "select",
                property: "text-transform",
                label: "Case",
                default: "none",
                options: [
                    {id: "none", label: "None"},
                    {
                        id: "uppercase",
                        label: "Uppercase",
                    },
                    {
                        id: "lowercase",
                        label: "Lowercase",
                    },
                    {
                        id: "capitalize",
                        label: "Capitalize",
                    },
                ],
            },
            {
                type: "select",
                property: "direction",
                label: "Direction",
                default: "ltr",
                options: [
                    {id: "ltr", label: "LTR"},
                    {id: "rtl", label: "RTL"},
                    {id: "initial", label: "Initial"},
                    {id: "inherit", label: "Inherit"},
                ],
            },
        ],
    },
    {
        name: "Space",
        properties: [
            {
                type: "composite",
                property: "padding",
                label: "Padding",
                // Additional props
                properties: [
                    {
                        type: "number",
                        units: ["px"],
                        default: "0",
                        label: "Atas Bawah",
                        property: "padding-top",
                    },
                    {
                        type: "number",
                        units: ["px"],
                        default: "0",
                        label: "Kiri Kanan",
                        property: "padding-left",
                    },
                ],

                toStyle: (values) => {
                    const top = values["padding-top"] || 0;
                    const left = values["padding-left"] || 0;

                    if (top != "0px" && left != "0px") {
                        return {
                            padding: `${top} ${left}`,
                        };
                    }

                    if (top != "0px") {
                        return {
                            padding: `${top} 0px`,
                        };
                    }

                    if (left != "0px") {
                        return {
                            padding: `0px ${left}`,
                        };
                    }
                },
            },
            {
                type: "composite",
                property: "margin",
                label: "Margin",
                // Additional props
                properties: [
                    {
                        type: "number",
                        units: ["px"],
                        default: "0",
                        label: "Atas Bawah",
                        property: "margin-top",
                    },
                    {
                        type: "number",
                        units: ["px"],
                        default: "0",
                        label: "Kiri Kanan",
                        property: "margin-left",
                    },
                ],

                toStyle: (values) => {
                    const top = values["margin-top"] || 0;
                    const left = values["margin-left"] || 0;

                    if (top != "0px" && left != "0px") {
                        return {
                            margin: `${top} ${left}`,
                        };
                    }

                    if (top != "0px") {
                        return {
                            margin: `${top} 0px`,
                        };
                    }

                    if (left != "0px") {
                        return {
                            margin: `0px ${left}`,
                        };
                    }
                },
            },
        ],
    },
];

export {
    container,
    styleBootstrap,
    jsBootstrap,
    jsPopperBootstrap,
    deviceManager,
    appendLayerManager,
    appendSelectorManager,
    statesSelectorManager,
    appendTraitManager,
    appendBlockManager,
    storageType,
    appendStyleManager,
    sectors,
};
