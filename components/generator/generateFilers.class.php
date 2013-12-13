<?php
final class TFilers
{
    static function write($str, $filename)
	{
	    $handler = fopen('files/'.$filename, 'a');
		fwrite($handler, $str);
		fclose($handler);
    }
}
	
?>

 