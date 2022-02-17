<?php 

	function toJS($value)
	{
		echo '\''.addslashes(htmlspecialchars($value)).'\'';
	}

	function quote($value){
		return '"'.$value.'"';
	}
	function htmlquote($value){
		return quote(htmlspecialchars($value));
	}
?>