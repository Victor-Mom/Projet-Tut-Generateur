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
    <script>
        AFRAME.registerComponent('hotspots',{
            init:function(){
                this.el.addEventListener('reloadspots',function(evt){

                    //get the entire current spot group and scale it to 0
                    var currspotgroup=document.getElementById(evt.detail.currspots);
                    currspotgroup.setAttribute("scale","0 0 0");

                    //get the entire new spot group and scale it to 1
                    var newspotgroup=document.getElementById(evt.detail.newspots);
                    newspotgroup.setAttribute("scale","1 1 1");
                });
            }
        });
        AFRAME.registerComponent('spot',{
            schema:{
                linkto:{type:"string",default:""},
                spotgroup:{type:"string",default:""}
            },
            init:function(){

                //add image source of hotspot icon
                //this.el.setAttribute("src","#fleche");
                //make the icon look at the camera all the time
                this.el.setAttribute("look-at","#cam");



                var data=this.data;

                this.el.addEventListener('click',function(){
                    //set the skybox source to the new image as per the spot
                    var sky=document.getElementById("skybox");
                    sky.setAttribute("src",data.linkto);

                    var spotcomp=document.getElementById("spots");
                    var currspots=this.parentElement.getAttribute("id");
                    //create event for spots component to change the spots data
                    spotcomp.emit('reloadspots',{newspots:data.spotgroup,currspots:currspots});
                });

            }
        });

    </script>
</head>
<body>
    <form method="post" id="notreFormulaire"></form>
    <a-scene id="notreScene">
        <a-assets>
            <img id="photo1" src="photosUpload/<?php echo $_POST['photo1']; ?>" alt=""/>
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
