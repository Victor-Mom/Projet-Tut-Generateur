<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carte</title>
    <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-slice9-component/dist/aframe-slice9-component.min.js"></script>
    <script src="https://unpkg.com/aframe-look-at-component@0.5.1/dist/aframe-look-at-component.min.js"></script>
</head>
<body>


<form id="formulaireCarteJS" method="POST" action="index.php?action=SaveCarte">
    <input id="nbElements" name="nbElements" type="text" value="0" hidden="hidden"/>
    <input id="envoi" type="submit" value="SAVE" hidden="hidden"/>
</form>

<a-scene id="sceneCarte">
    <a-sky id="skybox" src="#fondBlanc"></a-sky>

    <a-assets>
        <img id="logoJaune" src="vues/photos/logoJaune.png" alt=""/>
        <img id="fondBlanc" src="vues/photos/fondBlanc.png" alt=""/>
    </a-assets>

    <a-assets>
        <img id="photoCarte" src="photosUpload/<?php echo $laCarte->getChemin(); ?>" alt=""/>
    </a-assets>

    <a-entity id="cam" camera position="0 1.6 0" look-controls wasd-controls="enabled:false">
        <a-entity cursor="fuse:true;fuseTimeout:2000"
                  geometry="primitive:ring;radiusInner:0.01;radiusOuter:0.02"
                  position="0 0 -1.8"
                  material="shader:flat;color:blue">
        </a-entity>
    </a-entity>

    <a-plane position="-1.89574 1.6 -1.96425" src="#photoCarte" look-at="#cam" height="4" width="6"  rotation="0 43.98317825991033 0">
    </a-plane>

</a-scene>

</body>
<script type="module" src="vues/js/scriptCarte.js"></script>
</html>