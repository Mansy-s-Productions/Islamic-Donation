import {Fancybox} from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import './bootstrap';
import 'flowbite';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const options = {
    Toolbar: {
        display: {
            left: ["infobar"],
            middle: [
                "zoomIn", "zoomOut", "download",
            ],
            right: ["close"]
        },
        Thumbs: {
            type: "modern"
        }

    }
};

Fancybox.bind("[data-fancybox]", options, {});
