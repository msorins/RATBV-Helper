<?php
function secure($val)
{
	if(isset($val))
	{
		//$val=preg_replace('/[^a-z0-9_-]+/i','', $val);
		$val=mysql_real_escape_string($val);
		$val=htmlspecialchars($val, ENT_QUOTES);
		return $val;
	}
	return $val;
}
function secure_just_mysql($val)
{
	$val=mysql_real_escape_string($val);
    return $val;
}
?>