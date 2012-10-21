<?php
require ('yh.class.php');
$yh= new yh;
echo 'Number of clients: ';
echo $yh->numclients();
echo '<br>';
echo 'Number of websites: ';
echo $yh->numaccounts();
echo '<br>The first YH api! CC-BY Maarten Eyskens';