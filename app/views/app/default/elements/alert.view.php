<?php
	$message = $data['message'];
	$title = $data['title'];
	$dismissable = $data['dismissable'];
	$type = $data['type'];
?>

<div class="alert alert-<?php echo $type; ?>">
	<?php
		if($dismissable){ echo '<button type="button" class="close" data-dismiss="alert">x</button>'; }
		if($title){echo '<h4>'.$title.'</h4>';}
	?>
	<p><?php echo $message; ?></p>
</div>