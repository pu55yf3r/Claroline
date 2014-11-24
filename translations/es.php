<?php

use Claroline\CoreBundle\Library\Installation\Settings\AbstractValidator;
use Claroline\CoreBundle\Library\Installation\Settings\DatabaseChecker;
use Claroline\CoreBundle\Library\Installation\Settings\MailingChecker;

return array(
    'welcome' => 'Bienvenido',
    'welcome_message' => 'Este asistente le guiará a través de la instalación de la plataforma.',
    'install_language' => 'Idioma de instalación',
    'requirements_check' => 'Comprobación de configuración',
    'failed_requirement_msg' => 'La aplicación no se ejecutará correctamente en su configuración actual. Por favor, corrija los elementos resaltados en rojo y vuelva a cargar esta página.',
    'additional_failed_recommendation_msg'
        => 'También se recomienda corregir cualquier elemento resaltado en color naranja, ya que indican ajustes que pueden impactar negativamente en el comportamiento de la aplicación o ejecución.',
    'failed_recommendation_msg'
        => 'Su configuración cumple los requisitos mínimos para ejecutar la aplicación, pero algunos ajustes puede influir negativamente en el comportamiento o rendimiento. Para resolver este problema, debe corregir los elementos resaltados en naranja y volver a cargar esta página.',
    'correct_configuration_msg' => 'Su configuración cumple con todos los requisitos y recomendaciones para ejecutar la aplicación correctamente.',
    'correct_config' => 'Su configuración es correcta.',
    'PHP version' => 'PHP versión',
    'PHP version must be at least %version% (installed version is %installed_version%)'
        => 'La versión de PHP debe ser al menos %version% (la versión instalada es %installed_version%)',
    'PHP version 5.3.16 has known bugs which will prevent the application from working properly'
        => 'La versión 5.3.16 de PHP tiene errores conocidos que impidan la aplicación funcione correctamente.',
    'PHP versions prior to 5.3.8 have known bugs which may prevent the application from working properly'
        => 'Las versiones de PHP anteriores a 5.3.8 tinen errores que pueden impedir la aplicación funcione correctamente.',
    'PHP version 5.4.0 has known bugs which may prevent the application from working properly'
        => 'La version de PHP 5.4.0 tine errores que puede impedir la aplicación funcione correctamente',
    'PHP configuration' => 'Configuración de PHP',
    'Parameter date.timezone must be set in your php.ini' => 'El parametro <em>date.timezone</em> debe estar presente en su <em>php.ini</em>.',
    'Your default timezone (%timezone%) is not supported' => 'Su zona horaria por defecto (<em>%timezone%</em>) no es compatible.',
    'Parameter %parameter% must be set to %value% in your php.ini' => 'El parametro <em>%parameter%</em> debe estar establecido a <em>%value%</em> en su php.ini.',
    'Parameter %parameter% should be set to %value% in your php.ini' => 'El parametro <em>%parameter%</em> debe estar establecido a <em>%value%</em> en su php.ini.',
    'Parameter %parameter% should be equal or greater than %value% in your php.ini' => 'El parametro <em>%parameter%</em> debe ser igual o superior a <em>%value%</em> en su php.ini',
    'PHP extensions' => 'Extensiones PHP',
    'Extension %extension% must be installed and enabled' => 'La extensión <em>%extension%</em> debe estar instalada y activada.',
    'Extension %extension% should be installed and enabled' => 'Le extensión <em>%extension%</em> debería estar instalada y activada.',
    'PDO must have some drivers installed (i.e. for MySQL, PostgreSQL, etc.)'
        => 'El PDO debe tener algunos controladores instalados (por ejemplo, MySQL, PostgreSQL, etc.).',
    'A PHP accelerator (like APC or XCache) should be installed and enabled (highly recommended)'
        => 'Un acelerador de PHP (como APC o XCache) debe estar instalado y activado (muy recomendado).',
    'APC version must be at least %version%' => 'La versión de APC debe ser al menos la %version%.',
    'Extension %extension% should not be enabled' => 'LA extensión <em>%extension%</em> no debe estar activada.',
    'Parameter %parameter% should be above 100 in php.ini' => 'El parametro <em>%parameter%</em> debe estar por encima de 100 en su php.ini.',
    'File permissions' => 'Los permisos de archivo',
    'The directory %directory% must be writable' => 'El directorio <em>%directory%</em> debe tener permisos de escritura.',
    'The file %file% must be writable' => 'El archivo <em>%file%</em> debe tener permisos de escritura.',
    'database_parameters' => 'Parametros de la base de datos',
    'database_msg' => 'Introduzca aquí los parámetros de la base de datos que serán utilizados por la aplicación. Si no existe la base de datos, una sera creada. De lo contrario, debe estar vacía.',
    'driver' => 'Controlador',
    'host' => 'Host',
    'database' => 'Base de datos',
    'user' => 'Usuario',
    'password' => 'Contraseña',
    'port' => 'Puerto',
    AbstractValidator::NOT_BLANK_EXPECTED => 'Este valor no debe estar en blanco',
    AbstractValidator::NUMBER_EXPECTED => 'Este valor debe ser un número positivo',
    AbstractValidator::INVALID_DRIVER => 'Este controlador no es válido',
    AbstractValidator::INVALID_EMAIL => 'Esta dirección de correo electrónico no es válida',
    AbstractValidator::INVALID_URL => 'Esta URL no es válido',
    AbstractValidator::OVER_MAX_LENGTH => 'Este valor es demasiado largo',
    AbstractValidator::UNDER_MIN_LENGTH => 'Este valor es demasiado corto',
    AbstractValidator::INVALID_TRANSPORT => 'Transporte no válido',
    AbstractValidator::INVALID_AUTH_MODE => 'Modo de autenticación inválido',
    AbstractValidator::INVALID_ENCRYPTION => 'Cifrado inválido',
    DatabaseChecker::DATABASE_NOT_EMPTY
        => 'La base de datos que ha seleccionado no está vacía. Por favor elija otra o deje al instalador crear una para usted.',
    DatabaseChecker::CANNOT_CONNECT_TO_SERVER
        => 'La conexión al servidor de base de datos no puede ser establecida. Por favor, compruebe que los parámetros son correctos.',
    DatabaseChecker::CANNOT_CONNECT_OR_CREATE
        => 'La conexión a la base de datos no se puede establecer y la base de datos no puede ser creada. Por favor, compruebe que el usuario de base de datos que ha seleccionado tiene permisos suficientes.',
    'platform_parameters' => 'Parámetros de la plataforma',
    'platform_msg' => 'Escriba aquí la información general acerca de su plataforma. Estos parámetros serán editables en la sección de administración de la plataforma, una vez instalada la aplicación.',
    'language' => 'Idioma',
    'name' => 'Nombre',
    'support_email' => 'Correo electrónico de soporte',
    'organization' => 'Organización',
    'organization_url' => 'Sitio web',
    'admin_user' => 'Administrador',
    'admin_msg' => 'Introduzca aquí los datos de la cuenta del primer administrador de la plataforma (probablemente <em>usted</em>).',
    'first_name' => 'Nombre',
    'last_name' => 'Apellido',
    'username' => 'Nombre de usuario',
    'email' => 'Correo electrónico',
    'transport' => 'Transporte',
    'mail_server' => 'Servidor de correo electrónico',
    'mailing_msg' => 'Puede introducir aquí los parámetros necesarios para el envío de mensajes de correo electrónico desde la plataforma. Este paso es opcional: usted será capaz de especificar estos parámetros en la sección de administración de la plataforma, una vez instalada la aplicación.',
    MailingChecker::UNABLE_TO_START_TRANSPORT => 'El transporte de correo no se puede iniciar. Por favor, compruebe que los parámetros son correctos.',
    MailingChecker::UNABLE_TO_START_SENDMAIL => 'Sendmail o Postfix no pueden ser iniciados. Por favor, compruebe que uno de ellos está instalado y configurado correctamente.',
    MailingChecker::UNABLE_TO_START_GMAIL => 'La conexión al servicio SMTP Gmail no se puede establecer. Por favor, compruebe que las credenciales son correctas.',
    MailingChecker::UNABLE_TO_START_SMTP => 'La conexión al servidor SMTP no puede ser establecida. Por favor, compruebe que los parámetros son correctos.',
    'encryption' => 'Cifrado',
    'auth_mode' => 'Autenticación',
    'installation' => 'Instalación',
    'pre_install_msg' => 'La aplicación está lista para ser instalada. Puede volver a los pasos anteriores para comprobar que los parámetros proporcionados son correctos o iniciar la instalación inmediatamente.',
    'do_install' => 'Lanzar la instalación ahora',
    'install_wait_msg' => 'Por favor, espere mientras se instala la plataforma. Esto puede tardar varios minutos.',
    'install_details' => 'Mostrar los detalles de la instalación',
    'failed_install' => 'Error de instalación',
    'failure_message' => 'La instalación ha fallado. Por favor, informe de este incidente.',
    'install_log' => 'Registro de instalación detallado',
    'no_log_available' => 'Ningún registro disponibles (Archivo "%log_file%" no encontrado).',
    'previous_step' => 'Anterior',
    'skip_step' => 'Omitir',
    'next_step' => 'Siguiente',
    'test_again' => 'Pruebar de nuevo',
    'please_wait' => 'Espere por favor',
    'country' => 'País'
);
