<?php 

$phpVar = 'my php';
echo "<script type='text/javascript'>var jsvar = " $phpVar ";</script>";
echo "<script type='text/javascript' src='site_url('assets/js/crud.js')'></script>";
?>