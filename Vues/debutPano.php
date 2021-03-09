
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panorama</title>
    <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-slice9-component/dist/aframe-slice9-component.min.js"></script>
    <script src="https://unpkg.com/aframe-look-at-component@0.5.1/dist/aframe-look-at-component.min.js"></script>
    <!--animation component script-->
    <script src="https://unpkg.com/aframe-animation-component@^4.1.2/dist/aframe-animation-component.min.js"></script>

    <script src="https://unpkg.com/aframe-look-at-component@0.5.1/dist/aframe-look-at-component.min.js"></script>
    <script src="Vues/js/script.js"></script>

</head>
<body>
    <form method="POST" action="index.php?action=SAVE" id="notreFormulaire">
        <input id="nbElements" name="nbElements" type="text" value="0" hidden="hidden"/>
        <input id="envoi" type="submit" value="SAVE" hidden="hidden"/>
    </form>

    <a-scene id="notreScene">
        <a-assets>
            <img id="photo1" src="photosUpload/<?php echo $photoEnCours->getChemin(); ?>" alt=""/>
        </a-assets>


        <a-sky id="skybox" src="#photo1"></a-sky>

        <a-entity id="cam" camera position="0 1.6 0" look-controls>
            <a-entity cursor="fuse:true;fuseTimeout:2000"
                  geometry="primitive:ring;radiusInner:0.01;radiusOuter:0.02"
                  position="0 0 -1.8"
                  material="shader:flat;color:blue"
                  animation__component="property:scale;to:2 2 2;
                                        color:green;endEvents:mouseleave;
                                        startEvents:mouseenter;dir:reverse;dur:200;loop:1">>
            </a-entity>
        </a-entity>

        <a-entity id="spots" hotspots>

            <a-entity id="group-photo1">
            </a-entity>
        </a-entity>
    </a-scene>
</body>
</html>
