<?php 
	if( isset($_GET['recipeName'])) $recipeName=trim($_GET['recipeName']); 
	if( isset($_GET['ingredientList'])) $ingredientList=trim($_GET['ingredientList']); 
	if( isset($_GET['course'])) $course=$_GET['course']; 

	if (!empty($recipeName) && !empty($ingredientList) && !empty($course)) {
		$fp = @fopen("foods.txt",'a');
		if(!$fp) {
			echo "<strong>Your additon was not processed. Please try again later.</strong>";
			exit;
		}
		$out = $recipeName.",".$ingredientList.",".$course."\n";
		fwrite($fp,$out);
		fclose($fp);
		
		header('Location: foodList.php');
		exit;
	}
	
	require('header.php');
	
	$incomplete = !empty($recipeName) || !empty($ingredientList) || !empty($course);

	echo $incomplete ? "<p>Please fill in the <font style=\"background-color:Yellow;\">missing</font> information below</p>" 
			: "<p>Please fill in the recipe input form below</p>";
	
	require('table_functions.php');

	// 
	echo "<form action=\"home.php\">";
	
	p11_form_start();
	p11_textfield('Recipe Name:','recipeName',$incomplete);
	p11_textfield('Ingredient List </br>(separate by spaces):','ingredientList',$incomplete);
	p11_course('Type:', 'course', ['','breakfast','lunch','dinner'],
		['Select type',
		'Breakfast',
		'Lunch',
		'Dinner'],$incomplete);
	p11_form_end();
	echo "</form>";

	require('footer.php');
?>