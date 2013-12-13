<?php
class TActionController {
    /* $table
	*  propriedade private que contém o nome da tabela a ser gerado os cruds
	*/
    public $table;
    /*$class
	*contém o nome da classe a ser criada.
	*/
	public $class;
	/*$tableLines
	* array de propriedades dinâmicas do objeto controller 
	*/
	public $template = array();
	
	public function __construct($table, $class, $template){
	    $this->table = $table;
		$this->class = $class;
		$this->template = $template;
	}
	
    public function creatBody() {
	    return '<?php' . "\r\n".
       'class ' . $this->class . 'Action extends ApplicationController{' . "\r\n";
	}
	
	
	public function closeBody() {
		return  '}' . "\r\n".
		 '?>';
	}
	
	//fim do método.
	}
	
class GenerateSuperLayerController{

    
	public function __construct($path){
	    $this->path = $path;
	}
	
    public function creatBody() {
	    return '<?php' . "\r\n".
       'class ApplicationController extends ControllerFactory{' . "\r\n";
	}

	public function closeBody() {
		return  '}' . "\r\n".
		 '?>';
	}
	
	
	public function getMenu(){
	    return "function menu(){" . "\r\n" . "
	    ". '$this->staticRender(array(' . "\r\n" . "
	        'view_dirname'=>'index',"  . "\r\n" . "
		    'tpl_name'=>'menu'," . "\r\n" ."
		    'extension'=>'html')" . "\r\n" ."
		);" . "\r\n" ."
	    }" . "\r\n" ;
	}
	
	public function getCss(){
	    return  "\r\n" . "public function css(){" . "\r\n" ."
        echo ' " . "
        <link rel" . '="stylesheet" href="http://' . $this->path . '/css/style.css"' . " />';" . "\r\n" ."
	     }" . "\r\n" ;
	}
	
	public function getJs(){
	    return  "\r\n" . "public function javascripts(){" . "\r\n" . "
	    echo '
		 <script type" . '="text/javascript" language="javascript" src="http://' . $this->path . '/media/datatables/media/js/jquery.js"></script>' . "\r\n" . '
		<script type="text/javascript" language="javascript" src="http://' . $this->path . '/media/datatables/media/js/jquery.dataTables.js"></script>' . "\r\n" . "
		';
	    }";
	}
	
	public function getColorBox(){
	     return "   public function colorBoxSettings(){" . "\r\n" ."
	        echo '';
	        }" . "\r\n" ;
	}
	
	public function getDataTablesScript(){
	    return "public function datatables(){" .  "\r\n" ."
	    echo" .  "'<script" . ' type="text/javascript" charset="utf-8">' . "\r\n" . '
			$(document).ready(function() { ' . "\r\n" . '
				oTable = $("#example").dataTable({ ' . "\r\n" . '
					"bJQueryUI": true,' . "\r\n" . '
					"sPaginationType": "full_numbers"' .  "\r\n" .'
				});
			} );
		' . "</script>'" . ';
	    }';   
	}
	
	public function getStyleSettings(){
	    return "public function styleSettings(){" . "\r\n" ."
	    echo '<style type" . '="text/css" title="currentStyle">' .  "\r\n" .'
			@import "http://' . $this->path . '/media/datatables/media/css/demo_page.css";' . "\r\n" .'
			@import "http://' . $this->path . '/media/datatables/media/css/demo_table_jui.css";'. "\r\n" .'
			@import "http://' . $this->path . '/media/datatables/examples/examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css";
		' . "</style>';
	    }";
	}	
}