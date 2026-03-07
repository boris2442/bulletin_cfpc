import "./bootstrap";

import Alpine from "alpinejs";
import Typed from "typed.js";

window.Alpine = Alpine;
var typed = new Typed("#typewriter", {
    strings: [
        "Gestion Académique",
        "Gestion des Élèves",
        "Gestion des Notes",
        "Gestion des Bulletins",
        "Gestion des Compétences",
        "Gestion des Absences",
        "Gestion des Retards",
    ],
    typeSpeed: 60,
    backSpeed: 40,
    backDelay: 1500,
    loop: true,
});
Alpine.start();
