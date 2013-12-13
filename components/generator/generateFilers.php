<?php
include 'TRecordFile.class.php';
include 'generateFilers.class.php';
include 'TController.class.php';
include 'viewObject.class.php';
include 'object.class.php';

class Aplication {

    public $schema;

    function __construct($schema) {
        try {
            if (is_file($schema) AND file_exists($schema)):

                $this->schema = simplexml_load_file($schema);
                $table = $this->schema->model->table;
                $class = $this->schema->model->class;
                $apiName = $this->schema->model->api;
                $entityes = $this->schema->model->properties->prop;

                $model[1] = $this->schema->model->class . '.class.php';

                $actionController = $this->schema->model->class . 'Action.class.php';
                $ActionMain = $this->schema->model->class . '.class.php';

                $tpl[0] = $this->schema->views->template;
                $tpl[1] = $this->schema->views->template[1];
                $tpl[2] = $this->schema->views->template[2];

                $a = new TRecordFile($table, $class, $entityes);
                TFilers::write($a->creatBody(), $model[1]);
                TFilers::write($a->closeBody(), $model[1]);

                $t = new TActionController($table, $class, $tpl);
                TFilers::write($t->creatBody(), $actionController);
                TFilers::write($t->closeBody(), $actionController);

                $l= new GenerateSuperLayerController($pathToApp='localhost/src/Blog');
                TFilers::write($l->creatBody(), 'ApplicationController.class.php');
				TFilers::write($l->getMenu(), 'ApplicationController.class.php');
				TFilers::write($l->getCss(), 'ApplicationController.class.php');
				TFilers::write($l->getJs(), 'ApplicationController.class.php');
				TFilers::write($l->getColorBox(), 'ApplicationController.class.php');
				TFilers::write($l->getDataTablesScript(), 'ApplicationController.class.php');
				TFilers::write($l->getStyleSettings(), 'ApplicationController.class.php');
                TFilers::write($l->closeBody(), 'ApplicationController.class.php');

                $template = new SmartyTemplateViews($table, $class, $entityes);
                TFilers::write($template->getAllTemplates(), $tpl[0]);
                TFilers::write($template->getIdTemplate(), $tpl[1]);
                TFilers::write($template->index(), 'index.tpl');
                TFilers::write($template->menu(), 'menu.html');

                $main = new MainFiles;
                TFilers::write($main->index(), 'index.php');
                TFilers::write($main->main(), 'main.php');

                echo "<h3>Sucesso ao criar aplicação:</h3><h1>{$this->schema->model->table}</h1>";
            else:
                throw new Exception
                        ('Exception Core [' . "<br/>" .
                        'erro no objeto {' .
                        __CLASS__ . '} no método {' . __FUNCTION__ . '()} ERROR: arquivo ' . $this->schema
                        . 'não existe ou não é um tipo válido de arquivo');
            endif;
        } catch (Exception $e) {
            //exibe uma mensagem de erro
            echo $e->getMessage();
            echo "<br/>";
            echo "<br/>";
            echo ' Linha de erro : ' . $e->getLine();
            echo "<br/>";
            var_dump($e->getTrace());
            echo "<br/>";
            echo "<br/>";
            echo '}';
            exit ();
        }
    }
}
?>