<?php 
//variables globales
//se pueden acceder a estas variables de la siguiente  manera
//en clases php $dato=config('constants.VERSION_CSS') 
//en plnatillas blade {{config('constants.VERSION_CSS')}} 
//estas variables sirven para controlar las versiones de css y js y otros
//si usas las variables de este archivo config/constants.php debes actualizar los valores del mismo archivo
//ahora si usas variables de Providers/AppServiceProvider.php entonces debes actualizar los valores de ese mismo archivo
return [ 
    'VERSION_CSS' => '1', 
    'VERSION_JS' =>'1', 
];
