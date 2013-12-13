<?php

class SmartyTemplateViews{
public $table;
public $path;

	public $class;
	/* @table
	*  propriedade private que contém o nome da tabela a ser gerado os cruds
	*/
	public $tableLines = array ();
	/* @tableLines
	*  propriedade private que contém um array com as linhas do banco de dado
	*
	*/
	public function __construct($table, $class, $tableLines = array()){
	    $this->table = $table;
		$this->class = $class;
		$this->path = $path;
		$this->tableLines = $tableLines;
	}

    public function index(){
	    return "<html>
    <head>
        {php}Partial::init()->module('ApplicationController')->message('css');{/php}
        {php}Partial::init()->module('ApplicationController')->message('styleSettings');{/php}
        {php}Partial::init()->module('ApplicationController')->message('javascripts');{/php}
        {php}Partial::init()->module('ApplicationController')->message('colorBoxSettings');{/php}
        {php}Partial::init()->module('ApplicationController')->message('datatables');{/php}
    </head>
    <body>
	{php}Partial::init()->module('ApplicationController')->message('menu');{/php}
	{php}" . '
        $frontController=_AutoLoad::getFrontController();
        $frontController->listering();
        $frontController->run();
	{/php}
        <h1>Ola mundo LazyBird Framework</h1>
	</body>
</html> ';
	}
	
	public function menu(){
	    return '<div id="boxInitical"><h1> <span class="titulo">Sistema de Gerenciamento Empresarial</span> </h1>
            <div id="posixBox"><div id="menu">  
			<a href="?class=UIComponent&method=getAll">exemplo1</a>
			/   <a href="?class=UIComponent&method=getMaioresQueCincoMil">exemplo2</a>
			<a href="?class=UIComponent&method=relacaoPorCep">/  exemplo3</a> <a href="?class=UIComponent&method=relacaoPorFoneCel">exemplo4</a>
			/ estoque / <a href="?class=elemento&method=index">atendimento</a>
			/   contatos /  <a href="?class=organizacao&method=index">gerenciamento</a> </div>
                <form name="send" action="index.php?class=ninja&method=ataques" method="POST">
                    <input type="text" name="nome_ninja" value="" />
                    <input type="submit" value="enviar" name="" />
                    <input type="hidden" name="ataques" value="ninja">
                </form>
            </div>
        </div>';
	}
	
	function getAllTemplates()
	{
	   $tpl= "<h1>Admin area : {$this->class}:</h1>" . '
			
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	    <thead>
		<tr>';
		
		foreach($this->tableLines as $k=>$tables):
			$tpl.= "<th>{$tables}</th>" .  "\r\n";
		endforeach;
		$tpl.='
		<th>Visualizar</th>
        <th>Deletar</th>
        <th>Atualizar</th>
		</tr>
	    </thead>
	    <tbody>';
	   $tpl.=   '<tr class="gradeY">' . "{foreach item=" . $this->table . ' from=$' . $this->class . '}';
        foreach($this->tableLines as $k=>$tables):
		    $tpl.='<td> {$' . $this->table . '->' . "$tables} </td>" ."\r\n";
		endforeach;
		$tpl.=
		'<td><a href="main.php?class=' . $this->table . "&method=getId{$this->class}&id=" .'{$'. $this->table .'->id}" id="" >Visualizar</a></td>'. "\r\n".
		'<td><a href="main.php?class=' . $this->table . '&method=destroy&id={$'. $this->table .'->id}" id="" >Deletar</a></td>'. "\r\n".
		'<td><a href="main.php?class=' . $this->table . '&method=update&id={$'. $this->table .'->id}" id="">Atualizar</a></td>' ."\r\n";
		$tpl.='</tr>
		{/foreach}'.
		'</tbody>
        </table>' ;
		
        return $tpl;				
	}
	
	public function getIdTemplate(){
	    return ('<html>
        <body>
       {foreach item='. $this->table . ' from=$'. $this->class. '}
        <h2> id: {$'. $this->table . '->'. $this->tableLines[0] . '}  </h2><br>
	        <p> name:    {$'. $this->table . '->'. $this->tableLines[1] . '} </p>  <br>
	           <p> email:   {$'. $this->table . '->'. $this->tableLines[2] . '} </p>  <br>
            <p> text:   {$'. $this->table . '->'. $this->tableLines[3] . '} </p>  <br>
		{/foreach}
        </body>
        </html>');
	}
}

class MainFiles{

public function index(){
    return "<?php include('protected/config/bootstrap.php');" .
'
$view = new ApplicationController();' . '
$view->staticRender(' . "array('view_dirname'=>'index','tpl_name'=>'index','extension'=>'tpl'));
?>";
}

public function main(){
    return "<?php 
include('protected/config/bootstrap.php');
" . '
$frontController=_AutoLoad::getFrontController();
$frontController->listering();
$frontController->run();
 ?>
';
}
}