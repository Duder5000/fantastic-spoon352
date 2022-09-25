<?php
	$document_root = $_SERVER['DOCUMENT_ROOT'];
	$file_path = "foods.txt";
	if (!file_exists($file_path)) {
		require('header.php');
		echo "<strong>No food added</strong>";
		require('footer.php');
		exit;
	}
	$fp = @fopen($file_path,'r');
	if(!$fp) {
		require('header.php');
		echo "<strong>List not available at this time. Please try again later.</strong>";
		require('footer.php');
		exit;
	}
	// require ('enrolled_functions.php');
	require ('foodList_functions.php');

	require('header.php');
	echo "<h1>Recipe List</h1>";

	e13_table_header();
	while ($arr = fgetcsv($fp)) {
		e13_table_student($arr[0],$arr[1],$arr[2],$arr[3]);
	}
	e13_table_end();


	require('footer.php');
?>
