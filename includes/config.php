<?php 
//Configuración básica de la página
c::set('site.title','Encuesta Izquierda Independiente');
c::set('site.descr','Toolkit desarrollado por La Última Pregunta');
c::set('site.auth','Izquierda Independiente. Iniciativa por San Sebastián de los Reyes');

//Nombre de la cookie creada por el sitio
c::set('cookie.user','lupUser');

//MAIL
//La librería PHPMailer necesita un remitente con un dominio válido, o no funcionará
c::set('mail.from','noreply@laultimapregunta.com'); //Remitente de los correos enviados automáticamente
c::set('mail.fromName','Alhgo'); //Remitente de los correos enviados automáticamente
c::set('mail.contact','contacto@laultimapregunta.com'); //Correo al que se mandará el formulario de contacto

/*
---------------------
MYSQL
--------------------
*/
c::set('use.database',false);
c::set('db.host','localhost');
c::set('db.database','database_name');
c::set('db.username','root');
c::set('db.password','');
c::set('db.port',3306);


/*
---------------------
FIREBASE
--------------------
*/

c::set('use.firebase',false); //Cambiar a false si no se usará BD Firebase
c::set('fb.url','https://your_firebase_database.firebaseio.com/'); //Cambiar por la URL de la BD

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


//Claves de la API de Google para insertar CPATCHA https://www.google.com/recaptcha/
//Dejar vacío cualquiera de los valores y el script no se cargará
c::set('captcha.site','reCaptacha.Site'); 
c::set('captcha.secret','reCaptcha.Secret'); 

?>