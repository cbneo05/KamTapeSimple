<?php
define('KAMTAPE_DB_DSN', 'sqlite:kamtape.sqlite');
define('KAMTAPE_ADMINS', serialize([
    'SwedishCeko'
]));

define('SMTP_HOST', 'server.name');
define('SMTP_PORT', 25);
define('SMTP_SECURE', 'none'); 
define('SMTP_USERNAME', 'username@server.name');
define('SMTP_PASSWORD', 'password');
define('SMTP_FROM_EMAIL', 'username@server.name');
define('SMTP_FROM_NAME', 'RetroShow');
