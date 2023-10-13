var hostname = window.location.protocol+'//'+window.location.hostname;
var images = hostname+'/randonnees_2/images/';

var banner_array = ['banner_1', 'banner_2', 'banner_3', 'banner_4'];
var index_image_banner = banner_array.length;

/************************************************
 * fonction pour animer les image de bannère
 ************************************************/
function animation_banner(){
    var element = document.getElementById("bienvenu");
    if(index_image_banner < banner_array.length) index_image_banner++;
    else index_image_banner=1;
    //src=\"<?php echo NOM_HOST.'/images/banner_4.jpg'?>\"
    element.innerHTML = "<img src = '"+images+banner_array[index_image_banner-1]+".jpg'/>";
    // ?>images/"+banner_array[index_image_banner-1]+".jpg'/>";
    console.log(element.innerHTML);
}

var gallery_array = ['gallery_1', 'gallery_2', 'gallery_3', 'gallery_4', 'gallery_5', 'gallery_6'];
var gallery_description = ['Randonner avec un accompagnateur','A pied' ,'A cheval' ,'Itinéraires VTT', 'Refuges', 'La collection des carto-guides Balades et Randonnées']
var index_image_gallery = gallery_array.length;

/************************************************
 * fonction pour animer les images de gallery si la boutton next est cliquée
 ************************************************/
function next_image_gallery(){
    //window.clearInterval(animate_gallery);
    var element = document.getElementById('container_gallery');
    var description_gallery = document.getElementById('description_gallery');
    if(index_image_gallery < gallery_array.length) index_image_gallery++;
    else index_image_gallery = 1;
    element.innerHTML = "<img src='"+images+gallery_array[index_image_gallery - 1]+".jpg'/>";
    description_gallery.innerHTML = gallery_description[index_image_gallery - 1];
    console.log(element.innerHTML);
}


/************************************************
 * fonction pour animer les images de gallery si la boutton prév est cliquée
 ************************************************/
function prev_image_gallery(){
    //window.clearInterval(animate_gallery);
    var element = document.getElementById('container_gallery');
    var description_gallery = document.getElementById('description_gallery');
    if(index_image_gallery < gallery_array.length+1 && index_image_gallery > 1) index_image_gallery--;
    else index_image_gallery = gallery_array.length;
    element.innerHTML = "<img src='"+images+gallery_array[index_image_gallery - 1]+".jpg'/>";
    description_gallery.innerHTML = gallery_description[index_image_gallery - 1];
    console.log(element.innerHTML);
}

/************************************************
 * démarrer l'auto-animation du bannère avec un interval de temps de 6 secondes
 ************************************************/
var animate_banner = setInterval("animation_banner()", 6000);


/************************************************
 * démarrer l'auto-animation du gallery avec un interval de temps de 4 secondes
 ************************************************/
var animate_gallery = setInterval("next_image_gallery()", 4000);
