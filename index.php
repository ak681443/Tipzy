<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Primitive server memory
$raw_subtotal = '';
$subtotal = 0;
$tip_percent = 10;
$subtotal_error_flag = False;
$tip_percent_flag = False;

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['subtotal']) && isset($_POST['tip-percent'])){
	$raw_subtotal = $_POST['subtotal'];
        $subtotal = intval($raw_subtotal);
        $tip_percent = intval($_POST['tip-percent']);
	if($subtotal<1){
		$subtotal_error_flag = True;		
	}
	
	if($tip_percent < 1){
		$tip_percent_flag = True;
	} 
}

?>

<html>
	<head>
		<title>Tip Calculator</title>
		<style>
			.error {
				color: brown;
			}	

			.center {
				display : inline;
				margin-left : 30%;
				text-align : center;
			}

			.calc-body {
				width : 30%;
				margin-left : 35%;
				border : 1px solid black;
			}
			
			.ok-button {
				float: center;
				margin-left : 45%;
			}

			.tip-percent {
				padding-left : 100px;
			}
			
			.result {
				border : 2px solid blue;
				margin : 10px;
				padding : 20px;
			}	
		</style>
	</head>

	<body>
		<div class='calc-body'>
			<h1 class='center'> Tip Calculator </h1>
			<form method='post' action='/Calculator/' >
				<span label-for='subtotal' class='<?=$subtotal_error_flag? 'error':'' ?>'>Bill Subtotal: $</span> 
				<input type='text' name='subtotal' autocomplete='off' value='<?= $subtotal==0 ? $raw_subtotal : $subtotal ?>'/>
				<br/>
				<h4>Tip Percentage: </h4>
				<?php
					for ($i=10; $i<=20; $i= $i+5){
						echo "<input type='radio' name='tip-percent' class='tip-percent' value='$i'";
						if($tip_percent == $i){
							echo " checked='true'";
						}
						echo ">$i</input>";
					}
					
				?>
				<br/>
				<input type='submit' value='Submit' class='ok-button' />
			</form>
			<?php 
				if ($_SERVER['REQUEST_METHOD']=='POST'){
					echo "<div class='result'>";
					if(!$tip_percent_flag && !$subtotal_error_flag){
						$tip = $subtotal * ($tip_percent/100);
						echo "Tip Amount : $tip <br/>";
						$total = $subtotal + $tip;
						echo "Total Amount : $total";  
					} else {
						echo "Input Error";
					}
					echo "</div>";
				}
			?>
		</div>
	</body>
</html>
