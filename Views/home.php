<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?php echo $data['page_tag']; ?> </title>
	</head>
	<body>
		<section id="<?php //echo $data['page_id']; ?>">
			<h1><?php echo $data['page_title']?></h1>
			<p>Mini Framewrok V1.0 </p>
			<?php echo $data['page_content']; ?>

			<?php echo "<br>"; echo MONEY.formatMoney(65456.34) ?>
		</section>
		

		
	</body>
</html>