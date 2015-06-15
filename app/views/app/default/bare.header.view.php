<?php
	$alerts = $data['alerts'];
	$rel_path = $data['config']->root_path;
?>

<?php if($alerts && count($alerts->alertArray) > 0){ ?>
<div class="alerts-container">
	<?php $alerts->displayAll(); ?>
</div>
<?php } ?>

<nav class="navbar navbar-default">

	<div class="container-fluid">

		<div class="navbar-header">
			<a class="navbar-brand" href="/">STEEL</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			</ul>
		</div>
	</div>
</nav>