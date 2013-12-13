<?php
class ConfigPath extends GlobalConfig {

    private static $path_config;

    public static function _setConfig(array $path_config) {
        self::$path_config = $path_config;
    }

    public static function _getConfig() {
        return new ConfigPath;
    }

    public static function httpPathAppBase() {
        return self::$path_config['conf_path']['http_path_app_base'];
    }

    public static function AppCore() {
        return self::$path_config['conf_path']['app_core'];
    }

    public static function pathAppBase() {
        return self::$path_config['conf_path']['path_app_base'];
    }

    public static function loginAdminRedirectDefault() {
        return self::$path_config['conf_path']['login_admin_redirect_default'];
    }

    public static function pathBaseForAdmin() {
        return self::$path_config['conf_path']['path_base_for_admin'];
    }
	
	public static function pathRoot()
	{
	    return self::$path_config['conf_path']['path_root'];
	}
	
	public static function pathImageLegate()
	{
	    return self::$path_config['conf_path']['path_image_legate'];
	}
	
	public static function folderFrontend()
	{
	    return self::$path_config['conf_path']['folder_frontend'];
	}
	
	public static function folderBackend()
	{
	    return self::$path_config['conf_path']['folder_backend'];
	}

    public static function root() {
        $base_core = self::AppCore();
        $http_base = self::pathAppBase();

        return array(
            "{$base_core}/kernel/metadata_class",
            "{$base_core}/kernel/logger",
            "{$base_core}/kernel/connection",
            "{$base_core}/controller",
            "{$base_core}/model",
            "{$base_core}/components",
            "{$base_core}/interfaces",
            "{$base_core}/Exception",
            "{$base_core}/tests",
            "{$base_core}/components/Smarty/libs",
            /* protected */
            "{$http_base}/protected/controllers",
            "{$http_base}/protected/controllers/filters",
            "{$http_base}/protected/controllers/legacy",
            "{$http_base}/protected/models",
			"{$http_base}/protected/models/legacy",
            "{$http_base}/protected/services",
            "{$http_base}/protected/components",
            "{$http_base}/protected/helpers"
        );
    }
}
?>
