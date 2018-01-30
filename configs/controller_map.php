<?php
/*
    if you need controller map,  define an array named cmap. for example:

    // map maptoinstall->doinstall ==>  install->doins
    $cmap['maptoinstall/doinstall'] = array('install','doins'); 

    // map maptonewcontroller ==> newcontroller
    $cmap['maptonewcontroller'] =  'newcontroller';
*/
$cmap['pages/404'] = array('pages','e404');
$cmap['person/names.json'] = array('person','names_json');
$cmap['person/phones.json'] = array('person','phones_json');
