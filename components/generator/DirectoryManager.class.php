<?php

class DirectoryManager {

    protected $path, $name;

    public static function createResource() {

        return new self;
    }

    public function pathToDir($path) {

        $this->path = $path;

        return $this;
    }

    public function dirname($name) {

        $this->name[] = $name;

        return $this;
    }

    public function generate() {

        foreach ($this->name as $k => $name) {

            echo DIRECTORY_SEPARATOR;

            mkdir("{$this->path}" . DIRECTORY_SEPARATOR . "{$name}", 0777);
        }
    }

}

class MoviePackage {

    protected $to, $for, $package;

    public function __construct($to, $for) {

        $this->moveDir($to, $for, false);
    }

    function moveDir($diretorio, $destino, $ver_acao = false) {

        if ($destino{strlen($destino) - 1} == '/') {

            $destino = substr($destino, 0, -1);
        }

        if (!is_dir($destino)) {

            if ($ver_acao) {

                echo "Criando diretorio {$destino}\n";
            }

            mkdir($destino, 0755);
        }



        $folder = opendir($diretorio);



        while ($item = readdir($folder)) {

            if ($item == '.' || $item == '..') {

                continue;
            }

            if (is_dir("{$diretorio}/{$item}")) {

                $this->moveDir("{$diretorio}/{$item}", "{$destino}/{$item}", $ver_acao);
            } else {

                if ($ver_acao) {

                    echo "Copiando {$item} para {$destino}" . "\n";
                }

                copy("{$diretorio}/{$item}", "{$destino}/{$item}");
            }
        }
    }

    public static function movieFileToContentType($type, $dir, $to) {

        $folder = opendir($dir);

        while ($item = readdir($folder)) {

            if (stripos($item, $type)) {

                copy("{$dir}/{$item}", "{$to}/{$item}");
            }
        }
    }

    public static function movieFile($file, $new_file) {

        if (!copy($file, $new_file)) {

            throw new Exception('Erro ao mover arquivo para outro diretorio');
        }

        return true;
    }

}

class ApplicationGenerator {

    protected $project_name, $path, $path_to, $objects;

    public function __construct($path, $project_name, array $objects) {

        $this->path = $path;

        $this->project_name = $project_name;

        $this->path_to = "{$this->path}" . DIRECTORY_SEPARATOR . "{$this->project_name}";

        $this->objects = $objects;
    }

    public function init() {

        $this->createProject();

        $this->createProtectedAppEstructure();
    }

    public function createProject() {



        //cria um projeto

        $resource = DirectoryManager::createResource();

        $resource->pathToDir("{$this->path}")
                ->dirname("{$this->project_name}")
                ->generate();



        $this->createProjectEstructure();

        $this->createMediaStructure();
    }

    public function createProjectEstructure() {

        //cria os diretórios root	

        $project_root = DirectoryManager::createResource();

        $project_root->pathToDir("{$this->path_to}")
                ->dirname('protected')
                ->dirname('media')
                ->generate();


        new MoviePackage($to = "/var/www/lazyBird_g/core/components/datatables", $for = "/var/www/application/legado/media/datatables");

        new MoviePackage($to = "/var/www/lazyBird_g/core/components/colorbox", $for = "/var/www/application/legado/media/colorbox");
    }

    public function createMediaStructure() {

        $media = DirectoryManager::createResource();

        $media->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR . "media")
                ->dirname('css')
                ->dirname('images')
                ->dirname('js')
                ->generate();
    }

    public function createProtectedAppEstructure() {

        //cria as pasta em protected {relativas a app} 	

        $protected = DirectoryManager::createResource();

        $protected->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR . "protected")
                ->dirname('cache')
                ->dirname('config')
                ->dirname('controllers')
                ->dirname('helpers')
                ->dirname('logs')
                ->dirname('models')
                ->dirname('tests')
                ->dirname('views')
                ->generate();



        $this->createCacheEstructure();

        $this->createLogsEstructure();

        $this->createControllersEstructure();

        $this->createViewsEstructure();

        $this->createTestsEstructure();

        $this->createSubFoldersViews();



        MoviePackage::movieFile('/var/www/lazyBird_g/core/components/app.generator/files/index.php',
                        "{$this->path_to}" . DIRECTORY_SEPARATOR . "index.php");



        MoviePackage::movieFile('/var/www/lazyBird_g/core/components/app.generator/files/main.php',
                        "{$this->path_to}" . DIRECTORY_SEPARATOR . "main.php");



        MoviePackage::movieFile('/var/www/lazyBird_g/core/kernel/metadata_class/bootstrap.php',
                        "{$this->path_to}" . DIRECTORY_SEPARATOR .
                        "protected" . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "bootstrap.php");



        MoviePackage::movieFile('/var/www/lazyBird_g/core/components/app.generator/files/ApplicationController.class.php',
                        "{$this->path_to}" . DIRECTORY_SEPARATOR .
                        "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "ApplicationController.class.php");



        MoviePackage::movieFileToContentType('Action', '/var/www/lazyBird_g/core/components/app.generator/files',
                        "{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers");



        MoviePackage::movieFileToContentType('class', '/var/www/lazyBird_g/core/components/app.generator/files',
                        "{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "models");
    }

    public function createCacheEstructure() {

        $cache = DirectoryManager::createResource();

        $cache->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "cache")
                ->dirname('cache_lite')
                ->generate();
    }

    public function createSubFoldersViews() {

        $viewsSub = DirectoryManager::createResource();



        foreach ($this->objects as $obj) {

            $viewsSub->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR .
                            "protected" . DIRECTORY_SEPARATOR . "views")
                    ->dirname("views.{$obj}")
                    ->generate();



            MoviePackage::movieFileToContentType($obj . ".tpl",
                            '/var/www/lazyBird_g/core/components/app.generator/files',
                            "{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR .
                            "views" . DIRECTORY_SEPARATOR . "views.{$obj}");
        }
    }

    public function createLogsEstructure() {

        $logs = DirectoryManager::createResource();

        $logs->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "logs")
                ->dirname('logs_xml')
                ->dirname('logs_html')
                ->dirname('logs_txt')
                ->generate();
    }

    public function createControllersEstructure() {

        $controllers = DirectoryManager::createResource();

        $controllers->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers")
                ->dirname('filters')
                ->generate();
    }

    public function createViewsEstructure() {

        $views = DirectoryManager::createResource();

        $views->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views")
                ->dirname('views.index')
                ->generate();



        MoviePackage::movieFile('/var/www/lazyBird_g/core/components/app.generator/files/index.tpl', "{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "views.index" . DIRECTORY_SEPARATOR . 'index.tpl');

        MoviePackage::movieFile('/var/www/lazyBird_g/core/components/app.generator/files/menu.html', "{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "views.index" . DIRECTORY_SEPARATOR . 'menu.html');
    }

    public function createTestsEstructure() {

        $tests = DirectoryManager::createResource();

        $tests->pathToDir("{$this->path_to}" . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "tests")
                ->dirname('tests_models')
                ->dirname('tests_controllers')
                ->dirname('tests_views')
                ->generate();
    }

}

$project = new ApplicationGenerator('/var/www/application', 'legado', array('Produto'));

$project->init();

echo 'projeto criado com sucesso';