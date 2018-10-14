<?php

//LOCALHOST CONFIG FILE
//c::set('site.title','Nombre local');
c::set('site.url','http://localhost/sitename');

//LOCAL MYSQL
c::set('db.host','localhost');
c::set('db.database','encuestasanse');
c::set('db.username','root');
c::set('db.password','');


/*
---------------------
FIREBASE LOCAL
--------------------
*/
c::set('fb.url','https://firebase_database.firebaseio.com/'); //Cambiar por la URL de la BD

//Archivo de config en carpeta includes. 
//Panel de Control de FB -> Configuración del proyecto -> Cuentas de servicio -> SDK de Firebase -> generar nueva clave
c::set('fb.jsonFile','google-service-account.json'); 
//Secreto de la Base de Datos. Obsoleto.
//Panel de Control de Firebase -> Configuración del proyecto -> Cuentas de servicio -> Secretos de la Base de datos
c::set('fb.token','SecretKey'); 
//Datos para logeo por correo
c::set('fb.admin_email','');
c::set('fb.admin_pass','');
c::set('fb.admin_uid','');

//Datos para iniciar la APP (obtenidas de la consola de FB)
c::set('fb.apiKey','firebase_API');
c::set('fb.authDomain','firebase_authDomain');
c::set('fb.databaseURL','databaseURL');
c::set('fb.projectId','projectID');
c::set('fb.storageBucket','storageBucket');
c::set('fb.messagingSenderId','messagingSender');


?>