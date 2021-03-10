var div;
var text;
var string;
var monPanneau;
var coord;
var cle=0;
var form=document.getElementById("formulaireCarteJS");
var input;
window.addEventListener('keydown', (event) => {
    switch(event.key) {

        case 'n' : //CREATION D'UN POINT DE NAVIGATION
            text = window.prompt("Veuillez rentrer le nom de l'image de destination (avec extension) : ");
            monPanneau = document.createElement("a-image");
            coord= {x: -1.5, y: 1.6, z:-2};
            monPanneau.setAttribute("position",coord);
            let chemin = "photosUpload/" + text;
            monPanneau.setAttribute("id",chemin);
            monPanneau.setAttribute("class", "point");
            monPanneau.setAttribute("src","#logoJaune");
            monPanneau.setAttribute("height","0.480");
            monPanneau.setAttribute("width","0.300");
            monPanneau.setAttribute("look-at","#cam");
            div = document.getElementById("sceneCarte");
            div.appendChild(monPanneau);
            break;
        case 'a' : //CHANGEMENT D'AXE
            cle = (cle + 1) % 3;
            break;
        case 'ArrowLeft' : //DEPLACEMENT SUR L'AXE CHOISI
            div = document.getElementById("sceneCarte");
            monPanneau = div.lastChild;
            coord = monPanneau.getAttribute("position");
            switch (cle) {
                case 0 : coord["x"] -= 0.25;
                    break;
                case 1 : coord["y"] -= 0.25;
                    break;
                case 2 : coord["z"] -= 0.25;
                    break;
            }
            monPanneau.setAttribute("position",coord);
            break;
        case 'ArrowRight' : //DEPLACEMENT SUR L'AXE CHOISI
            div = document.getElementById("sceneCarte");
            monPanneau = div.lastChild;
            coord = monPanneau.getAttribute("position");
            switch (cle) {
                case 0 : coord["x"] += 0.25;
                    break;
                case 1 : coord["y"] += 0.25;
                    break;
                case 2 : coord["z"] += 0.25;
                    break;
            }
            monPanneau.setAttribute("position",coord);
            break;
        case 'j' : //SAUVEGARDE DES ELEMENTS CREES
            let nbElements = 0;
            form=document.getElementById("formulaireCarteJS");
            let points = document.getElementsByClassName("point");
            let count = points.length;
            for (let i=0; i<count; i++) {
                sauvegarde(points[i],nbElements);
                nbElements += 2;
            }
            let info = document.getElementById("nbElements");
            info.setAttribute("value",nbElements.toString());
            form.submit();
            break;
        case 'h' : //AFFICHAGE DE L'AIDE MEMOIRE
            window.alert("P : créer un panneau\n" +
                "N : créer un point de navigation\n" +
                "\n" +
                "flèches (gauche et droite) : déplacer l'élément sur un axe\n" +
                "A : changer d'axe\n" +
                "\n" +
                "J : passer à la photo suivante\n" +
                "\n" +
                "H : afficher l'aide mémoire pour les touches\n");
            break;
        default :
            break;
    }

    function sauvegarde(item,nb){
        form=document.getElementById("formulaireCarteJS");
        input = document.createElement("input");
        input.setAttribute("type","text");
        input.setAttribute("value",item.getAttribute("id"));
        input.setAttribute("name","item"+(nb));
        form.appendChild(input);
        input = document.createElement("input");
        input.setAttribute("type","text");
        coord=item.getAttribute("position");
        coord = coord["x"] + " " + coord["y"] + " " + coord["z"];
        input.setAttribute("value",coord);
        input.setAttribute("name","item"+(nb+1));
        form.appendChild(input);
    }

})