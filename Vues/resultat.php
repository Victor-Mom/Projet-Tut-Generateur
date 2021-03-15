<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panorama</title>
    <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-slice9-component/dist/aframe-slice9-component.min.js"></script>
    <script src="https://unpkg.com/aframe-look-at-component@0.5.1/dist/aframe-look-at-component.min.js"></script>
</head>
<body>

<a-scene>
    <a-assets>
        <img id="fleche" src="Vues/photos/fleche.png" height="357" width="367" alt=""/>
        <img id="map" src="Vues/photos/map.png" height="256" width="256" alt=""/>
        <img id="tooltip" src="Vues/photos/tooltip.png" height="256" width="256" alt=""/>
        <?php
        foreach ($lesPhotos as $photo) {
            echo '<img id="' . $photo->sansExtension() . '" src="photosUpload/' . $photo->getChemin() . '" height="2688" width="5376" alt=""/>';
        }
        echo '<img id="' . $laCarte->sansExtension() . '" src="photosUpload/' . $laCarte->getChemin() . '" height="2688" width="5376" alt=""/>';
        ?>
    </a-assets>

    <a-sky id="skybox" src="#<?php echo $lesPhotos[0]->sansExtension(); ?>"></a-sky>
    <a-entity id="cam" camera position="0 1.6 0" look-controls wasd-controls="enabled:false">
        <a-entity cursor="fuse:true;fuseTimeout:2000"
                  geometry="primitive:ring;radiusInner:0.01;radiusOuter:0.02"
                  position="0 0 -1.8"
                  material="shader:flat;color:blue">
        </a-entity>
    </a-entity>
    <a-entity id="spots" hotspots>
        <?php
            echo '<a-entity id="group-' . $lesPhotos[0]->sansExtension() . '" scale="1 1 1">';
            echo '<a-image spot="linkto:#' . $laCarte->sansExtension() .
                ';spotgroup:group-' . $laCarte->sansExtension() . '" 
                position="-1 -3 -6" src="#map" look-at="#cam"></a-image>';
            foreach ($lesPhotos[0]->panneau as $p){
                echo '<a-entity slice9="width: 5; height: 1; left: 20; right: 43; top: 20; bottom: 43;src: #tooltip"
                          text="' . $p->message . '" ; 
                          look-at="#cam" position="' . $p->position . '"></a-entity>';
            }
            foreach ($lesPhotos[0]->pointNav as $nav) {
                echo '<a-image spot="linkto:#' . $nav->sansExtension() .
                    ';spotgroup:group-' . $nav->sansExtension() . '"
                    position="' . $nav->position . '" src="#fleche" look-at="#cam"></a-image>';
            }
            echo '</a-entity>';

            for ($i = 1 ; $i < $nbPhotos ; $i++) {
                echo '<a-entity id="group-' . $lesPhotos[$i]->sansExtension() . '" scale="0 0 0">';
                echo '<a-image spot="linkto:#' . $laCarte->sansExtension() . ';spotgroup:group-' . $laCarte->sansExtension() . '" 
                        position="-1 -3 -6" src="#map" look-at="#cam"></a-image>';
                foreach ($lesPhotos[$i]->panneau as $p){
                    echo '<a-entity slice9="width: 5; height: 1; left: 20; right: 43; top: 20; bottom: 43;src: #tooltip"
                          text="' . $p->message . '" ; 
                          look-at="#cam" position="' . $p->position . '"></a-entity>';
                }
                foreach ($lesPhotos[$i]->pointNav as $nav) {
                    echo '<a-image spot="linkto:#' . $nav->sansExtension() . ';spotgroup:group-' . $nav->sansExtension() . '"
                         position="' . $nav->position . '" src="#fleche" look-at="#cam"></a-image>';
                }
                echo '</a-entity>';
            }

            echo '<a-entity id="group-' . $laCarte->sansExtension() . '" scale="0 0 0">';
            foreach ($laCarte->pointNav as $nav) {
                echo '<a-image spot="linkto:#' . $nav->sansExtension() . ';spotgroup:group-' . $nav->sansExtension() . '"
                             position="' . $nav->position . '" src="#fleche" look-at="#cam"></a-image>';
            }
            echo '</a-entity>';

        ?>

    </a-entity>

</a-scene>

</body>
<script type="module" src="Vues/js/scriptTelechargement.js"></script>
</html>