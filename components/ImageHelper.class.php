<?php

class ImageHelper
{
    /*@param= prop(string)
	*nome do campo da tabela que ira receber o nome da imagem
	*/
    private static $prop;
	/*@param = $imgattr (mixer)
	*array contendo as propriedades do objeto imagem na sua criaчуo
	*/
	private static $imgattr;
    /*__construct()
	*atribui as propriedades e inicializa o mщtodo estatico getImage responsсvel pelas aчѕes
	*/
    public function __construct($prop, $imgattr)
	{
	    self::$prop = $prop;
		self::$imgattr= $imgattr;
		try
		{
		    self::getImage(self::$prop, self::$imgattr);
		}
		catch (Exception $e)
		{
			//exibe uma mensagem de erro
			echo $e->getMessage();
		}
	}
    /*getImage
	*move a imagem para um diretѓrio base/image
	*cria uma miniatura.
	*/
    public static function getImage($prop, $imgattr){
			//verifica se щ uma variсvel post
			if ($_FILES)
			{
			    $dir = ConfigPath::pathAppBase();
				
			    $namefile = $_FILES["$prop"]['name'];
			    $tempfile = $_FILES["$prop"]["tmp_name"];
			    //move a imagem original para o diretѓrio de imagem
			    $move = move_uploaded_file($tempfile, "{$dir}/media/images/{$namefile}");
			    //cria a miniatura
				
			    $thumb = new thumbnail("{$dir}/media/images/{$namefile}");
			    $thumb->size_width(@$imgattr['width']);
			    $thumb->size_height(@$imgattr['heigth']);
			    $thumb->size_auto(@$imgattr['auto']);
			    $thumb->jpeg_quality(@$imgattr['quality']);
			    $thumb->size_square(@$imgattr['square']);
			    $thumb->save("{$dir}/media/images/thumb_{$namefile}");
				return true;
	        }
	}
	
	public static function destroyFiles($dir, $atributeList=array())
	{
	    foreach($atributeList as $k=>$fileList){
	        if(file_exists("{$dir}/images/{$fileList}"))
			{
			    unlink("{$dir}/images/{$fileList}");
			}
			else
			{
			    return true;
			}
	    }
	}
}
?>