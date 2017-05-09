<?php
$db = parse_url(getenv('CLEARDB_DATABASE_URL'));

$container->setParameter('database_driver', 'pdo_mysql');
$container->setParameter('database_host', $db['host']);
$container->setParameter('database_port', $db['port']);
$container->setParameter('database_name', substr($db["path"], 1));
$container->setParameter('database_user', $db['user']);
$container->setParameter('database_password', $db['pass']);
$container->setParameter('secret', getenv('SECRET'));
$container->setParameter('locale', 'en');
$container->setParameter('mailer_transport', null);
$container->setParameter('mailer_host', null);
$container->setParameter('mailer_user', null);
$container->setParameter('mailer_password', null);
$container->setParameter('jwt_private_key_path', '%kernel.root_dir%/../var/jwt/private.pem');
$container->setParameter('jwt_public_key_path', '%kernel.root_dir%/../var/jwt/public.pem');
$container->setParameter('jwt_key_pass_phrase', 'salama');
$container->setParameter('jwt_token_ttl', 604800);