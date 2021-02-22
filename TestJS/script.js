var div;
var text;
var string;
var monPanneau;
var coord;
var cle=0;
window.addEventListener('keydown', (event) => {
    switch(event.key) {
        case 'p' :
            text = window.prompt("Veuillez rentrer le texte de votre panneau : ");
            text = text.trim();
            if (text != null) {
                monPanneau = document.createElement("a-entity");
                coord = {x: -2, y: 4, z: -10};
                monPanneau.setAttribute("position", coord);
                monPanneau.setAttribute("slice9", "width: 5; height: 1; left: 20; right: 43; top: 20; bottom: 43;src: tooltip.png");
                monPanneau.setAttribute("look-at", "#cam");
                let value = "value:" + text + ";wrap-count:15; width:5; align:center;zOffset:0.05";
                monPanneau.setAttribute("text", value);
                div = document.getElementById("notreScene");
                div.appendChild(monPanneau);
            }
            break;
        case 'n' :
            text = window.prompt("Veuillez rentrer le nom de l'image de destination : ");
            monPanneau = document.createElement("a-image");
            coord= {x: -2, y: 4, z:-10};
            monPanneau.setAttribute("position",coord);
            let chemin = "photosUpload/" + text;
            monPanneau.setAttribute("link",chemin);
            monPanneau.setAttribute("src","fleche.png");
            monPanneau.setAttribute("look-at","#cam");
            div = document.getElementById("notreScene");
            div.appendChild(monPanneau);
            break;
        case 'a' :
            cle = (cle + 1) % 3;
            break;
        case 'ArrowLeft' : div = document.getElementById("notreScene");
            monPanneau = div.lastChild;
            coord = monPanneau.getAttribute("position");
            switch (cle) {
                case 0 : coord["x"] -= 0.5;
                    break;
                case 1 : coord["y"] -= 0.5;
                    break;
                case 2 : coord["z"] -= 0.5;
                    break;
            }
            monPanneau.setAttribute("position",coord);
            break;
        case 'ArrowRight' : div = document.getElementById("notreScene");
            monPanneau = div.lastChild;
            coord = monPanneau.getAttribute("position");
            switch (cle) {
                case 0 : coord["x"] += 0.5;
                    break;
                case 1 : coord["y"] += 0.5;
                    break;
                case 2 : coord["z"] += 0.5;
                    break;
            }
            monPanneau.setAttribute("position",coord);
            break;
        case 's' :
            //SAUVEGARDE
            break;
        default :
            break;
    }
})