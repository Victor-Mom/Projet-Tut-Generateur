var div;
var text;
var string;
var monPanneau;
var coord;
var cle=0;
var form=document.getElementById("notreFormulaire");
var input;
var lesElements;
window.addEventListener('keydown', (event) => {
    switch(event.key) {
        case 'p' : //CREATION D'UN PANNEAU
            text = window.prompt("Veuillez rentrer le texte de votre panneau : ");
            text = text.trim();
            if (text != null) {
                monPanneau = document.createElement("a-entity");
                coord = {x: -2, y: 4, z: -10};
                monPanneau.setAttribute("position", coord);
                monPanneau.setAttribute("slice9", "width: 5; height: 1; left: 20; right: 43; top: 20; bottom: 43;src: Vues/photos/tooltip.png");
                monPanneau.setAttribute("look-at", "#cam");
                monPanneau.setAttribute("class", "panneau");
                let value = "value:" + text + ";wrap-count:15; width:5; align:center;zOffset:0.05";
                monPanneau.setAttribute("text", value);
                div = document.getElementById("notreScene");
                div.appendChild(monPanneau);
            }
            break;
        case 'n' : //CREATION D'UN POINT DE NAVIGATION
            text = window.prompt("Veuillez rentrer le nom de l'image de destination (avec extension) : ");
            monPanneau = document.createElement("a-image");
            coord= {x: -2, y: 4, z:-10};
            monPanneau.setAttribute("position",coord);
            let chemin = "photosUpload/" + text;
            monPanneau.setAttribute("link","href:"+chemin);
            monPanneau.setAttribute("class", "point");
            monPanneau.setAttribute("src","Vues/photos/fleche.png");
            monPanneau.setAttribute("look-at","#cam");
            div = document.getElementById("notreScene");
            div.appendChild(monPanneau);
            break;
        case 'a' : //CHANGEMENT D'AXE
            cle = (cle + 1) % 3;
            break;
        case 'ArrowLeft' : //DEPLACEMENT SUR L'AXE CHOISI
            div = document.getElementById("notreScene");
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
        case 'ArrowRight' : //DEPLACEMENT SUR L'AXE CHOISI
            div = document.getElementById("notreScene");
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
        case 'j' : //SAUVEGARDE DES ELEMENTS CREES
            let panneaux = Array.from(document.getElementsByClassName("panneau"));
            let points = Array.from(document.getElementsByClassName("point"));
            lesElements = panneaux.concat(points);
            lesElements.forEach(element => sauvegarde(element));

            input = document.createElement("input");
            input.setAttribute("type","submit");
            input.setAttribute("name","action");
            input.setAttribute("value","SAVE");
            form.appendChild(input);

            form.submit();
            break;
        default :
            break;
    }

    function sauvegarde(item){
        input = document.createElement("input");
        input.setAttribute("type","text");
        if (item.className === "panneau") {
            input.setAttribute("value",item.getAttribute("text").value);
        }
        else {
            input.setAttribute("value",item.getAttribute("link"));
        }
        form.appendChild(input);
        input = document.createElement("input");
        input.setAttribute("type","text");
        coord=item.getAttribute("position");
        coord = coord["x"] + " " + coord["y"] + " " + coord["z"];
        input.setAttribute("value",coord);
        form.appendChild(input);
    }


})
