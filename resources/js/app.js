import {Fancybox} from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import LazyLoad from "vanilla-lazyload";
import './bootstrap';
import 'flowbite';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Fancybox Start
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
        },
        slideshow: {
            autoStart: true,
            delay: 3000,
        },

    }
};
Fancybox.bind("[data-fancybox]", options, {});
// Fancybox End

window.onscroll = function (e) {
    var myLazyLoad = new LazyLoad();
}
