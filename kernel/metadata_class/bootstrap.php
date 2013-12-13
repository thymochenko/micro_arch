<?php

include_once('/var/www/lazyBird_g/core/kernel/metadata_class/_AutoLoad.class.php');

ConfigDatabase::_setConfig(array(
    'config_database'=>array(
    'database'=>'youdatabase')
));

ConfigSmarty::_setConfig(array(
    'smarty_config'=>array(
    'smarty_compiler_mod'=>true)
));

ConfigPath::_setConfig(array(
        'conf_path'=>array(
        'http_path_app_base'=>'http://localhost/youpath',
	'app_core'=>'/var/www/lazyBird_g/core',
	'path_app_base'=>'/var/www/youpath',
	'login_admin_redirect_default'=>'http://localhost/youpath/app.admin/',
	'path_base_for_admin'=>''
)));

ConfigTemplate::_setConfig(array(
    'global_conf_template'=>array(
    'default_template'=>'SmartyTemplateComponent'))
);

ConfigMail::_setConfig(array(
    'host'=>null,
    'username'=>null,
	'password'=>null,
	'addaddress'=>null)
);

ConfigDebug::_setConfig(array(
	'global_objects'=>array(
	'mod_debug'=>false))
);

ConfigCache::_setConfig(array(
	'cache_path'=>'/var/www/youpath/protected/cache/cache_lite/',
	'cache_load_method_id'=>array('load'=>'1', 'findBySql'=>'2'),
	'cache_default_life_time'=>5
));

ConfigLogger::_setConfig(array(
    'log'=>array('start_log'=>true,
	'path_html'=>'/var/www/youpath/protected/logs/logs_html/',
	'path_xml'=>'/var/www/youpath/protected/logs/logs_xml/',
	'path_txt'=>'/var/www/youpath/protected/logs/logs_txt/'
)));
?>
