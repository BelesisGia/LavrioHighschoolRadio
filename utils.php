<?php 

	function toJS($value)
	{
		echo '\''.addslashes(htmlspecialchars($value)).'\'';
	}
?>