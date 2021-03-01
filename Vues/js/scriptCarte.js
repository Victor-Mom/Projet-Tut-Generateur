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

        case 'n' : //CREATION D'UN POINT DE NAVIGATION
            text = window.prompt("Veuillez rentrer le nom de l'image de destination (avec extension) : ");
            monPanneau = document.createElement("a-image");
            coord= {x: -2, y: 1.6, z:-2};
            monPanneau.setAttribute("position",coord);
            let chemin = "photosUpload/" + text;
            monPanneau.setAttribute("link",chemin);
            monPanneau.setAttribute("class", "point");
            monPanneau.setAttribute("src","#logoJaune");
            monPanneau.setAttribute("height","0.480");
            monPanneau.setAttribute("width","0.300");
            monPanneau.setAttribute("look-at","#cam");
            div = document.getElementById("sceneCarte");
            console.log(div);
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
            div = document.getElementById("sceneCarte");
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
            let points = document.getElementsByClassName("point");
            points.forEach(element => sauvegarde(element));
            form.submit();
            break;
        default :
            break;
    }

    function sauvegarde(item){
        input = document.createElement("input");
        input.setAttribute("type","text");
        input.setAttribute("value",item.getAttribute("link"));
        form.appendChild(input);
        input = document.createElement("input");
        input.setAttribute("type","text");
        coord=item.getAttribute("position");
        coord = coord["x"] + " " + coord["y"] + " " + coord["z"];
        input.setAttribute("value",coord);
        form.appendChild(input);
    }

})