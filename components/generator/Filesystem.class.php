<?php
class FileSystem {

	public $pathViews;

	
	public function creat_Views_Folder($folder) {
	    try{
		if (mkdir("{$this->pathViews}\\Smarty\\Smarty_templates_c\\{$folder}", 0777)) {
		    echo "diretório {$folder} criado com sucesso";
		}
		else {
		    echo 'erro ao criar diretório';
		}
		} catch(Exception $e){
		    return False;
		}
	}  

}

#$app = new FileSystem;
#$app->creat_models("tb_posts", array (
#	0 => 'postsRecord.class.php',
#	1 => 'postsRepository.class.php',
#	2 => 'posts_TQuery.class.php'
#));

#$app->creat_Controllers("posts.action", array (
#	0 => 'postsController.class.php',
#	1 => 'deletAction.php',
#	2 => 'updateAction.php',
#	3 => 'insertAction.php',

#));

#$app->creat_Componets("posts_paginate.class.php");

#$app->creat_Views_filers('views.posts', array(
#    0 => 'dataFormEntryPostsTemplate.tpl',
#    1 => 'getAllPostsTemplate.tpl',
#    2 => 'getIdPostsTemplate.tpl'));