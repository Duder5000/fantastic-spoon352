<?php
	require ('foodList_functions.php');

	require('header.php');
	echo "<h1>Recipe Details</h1>";

	$nameSend = $_GET ['rname'];
	$listSend = $_GET ['rlist'];
	$typeSend = $_GET ['rtype'];

	e13_table_header2();

	e13_table_details($nameSend ,$listSend,$typeSend);

	e13_table_end();


	require('footer.php');
?>
