<?php
final class RssObject{

    /*@param $siteParan = parametros correspondes ao site
        *type:[ arrayObjet ]
	*/
    protected $siteParan;
    /*@param $object = objeto filho de TRecord
        *type:[ TRecord, objectTRecord... ]
        */	
	protected $object;
	 /*@param $properties= propriedades do objeto dado
        *type:[ arrayObjet ]
	*/
	protected $propertyes;
	
    
	public function __construct($siteParan, $propertyes, $object)
	{
	    $this->siteParan = $siteParan;
		$this->object = $object;
		$this->propertyes = $propertyes;

		
        if (!$conn = TTransaction :: get())
		{
		    throw new TCoreException("<h2>Não existe uma transação ativa</h2>");
		}
		//atribui propriedades básicas ao feed.
		$prop = $this->setPropertyes();
		echo $prop;
		//percorre TRecord Object
		foreach($object as $k=>$oVal):
		    $xCont=$this->setContent($oVal);
		    echo $xCont;
		endforeach;
        echo '</channel></rss>';
		
	}
	
	public function __toString()
	{
	    return $this->siteParan . $this->propertyes;
	}
	
	private function setPropertyes()
	{
		$rss = '';
        $rss .= '<rss version="2.0" xmlns:blogChannel="http://backend.userland.com/blogChannelModule">';
        $rss .= '<channel>';
        $rss .= "<title>". utf8_decode($this->siteParan['title']) ."</title>";
        $rss .= "<description>". utf8_encode($this->siteParan['description']) ."</description>";
        $rss .= "<link>" . utf8_encode($this->siteParan['link']) . "</link>";
        $rss .= "<language>". $this->siteParan['language'] . "</language>";
		return $rss;
	}
	
	private function setContent($objectResult)
	{
	    //objetos do model contendo as notícias
	    $title_url=$objectResult->title_url;
		$descr=$objectResult->description;
		$id=$objectResult->id;
		//url base
		$base='http://www.aguiaserigrafia.com.br';
		//corpo do feed
	    $content = '<item>';
      	$content .= '<title>'. utf8_encode($title_url) .  '</title>'; 
      	$content .= '<description>' . utf8_encode($descr) . '</description>'; 
      	$content .= '<link>' . "{$base}/posts/show/" . utf8_encode($title_url) . '/' . $id . '.html' . '</link>';
      	$content .= '</item>';
		return $content;
	}
}