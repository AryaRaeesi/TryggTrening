<!-- Hvis det er mer en 0 feil: kjør koden-->
<!-- Plass: handlevogn.php -->
<?php  if (count($errors) > 0) : ?>
  	<!-- $errors definert i server.php -->
	<!-- $errors: array, $error: variabel -->
	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
<?php  endif ?>
