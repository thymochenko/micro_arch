<?php
class Message
{
	static function _get($type, $msg) {
		if ($type == 'Error') {
			$error = '<div id="insert" style="
				    background-color:#CC0000;
		            color:#fff;
					border-width:2px;
					border-style:solid;
					border-color:#FF9900;
				    ">';
			echo $error;
			echo $msg;
			echo ' </div>';
		}
		if ($type == 'Info') {
			$info = '<div id="insert" style="
				    background-color:#FFF0C1;
		            color:#000;
					border-width:2px;
					border-style:solid;
					border-color:#FFC56C;
				    ">';
			echo $info;
			echo $msg;
			echo ' </div>';
		}
		return true;
	}
}