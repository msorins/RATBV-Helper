<?php
require "/var/zpanel/hostdata/zadmin/public_html/ironcoders_com/ratbv/scripts/config.php";
require "/var/zpanel/hostdata/zadmin/public_html/ironcoders_com/ratbv/scripts/secure.php";
$req=mysql_query("SELECT * FROM `statii` WHERE `statii_nume` LIKE  '%" . secure($_GET['term']) . "%'  ");
$c=0;
while($row = mysql_fetch_array($req))
{
	$c++;
	$results[] = array('label' => $row['statii_nume']);
	if($c>15)
		{
			$results[] = array('label' => "..");
			break;
		}
}

echo json_encode($results);
?>