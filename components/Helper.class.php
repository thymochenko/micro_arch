<?php
class Helper
{
    static function upperPrimaryLetter($str, $mod=null ,$extension=null)
	{
	    if(!$str=='')
		{
		    $class = $str . $extension;
			if($mod=='upper')
			{
				$primary_cons = strtoupper($class[0]);
			}
			elseif($mod=='lower')
			{
				$primary_cons = strtolower($class[0]);
			}
            $class_model = str_split($class);
            array_shift($class_model);
            array_unshift($class_model, $primary_cons);
            $class_model = implode('', $class_model);
		    return $class_model;
		}
		else
		{
		    throw new Exception("param String is nulll");
		}
	        
	}
}
