<?php
require "/var/zpanel/hostdata/zadmin/public_html/ironcoders_com/ratbv/scripts/config.php";
require "/var/zpanel/hostdata/zadmin/public_html/ironcoders_com/ratbv/scripts/secure.php";

$nume_statie=secure($_POST["nume_statie"]);
$nume_destinatie=secure($_POST["nume_destinatie"]);

header('Location: /ratbv/index.php?type=find&nume_statie='.$nume_statie.'&nume_destinatie='.$nume_destinatie);

?>