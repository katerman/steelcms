<?php

	$app = $data['app'];

	$alerts = $data['alerts'];
	$rel_path = $app->get('rel_path');
	$index_path = $data['config']->index_path;
	$user = $data['user'];
	$_config = $data['config'];

	$template_path = $_config->current_theme_path;
	$default = $_config->default_root_template;

	$pages = isset($data['dataToPass']['pages']) ? $data['dataToPass']['pages'] : array() ;

?>

<nav class="navbar navbar-default <?php if($user->loggedIn()){ echo 'loggedin'; } ?>" id="main-navbar">

	<?php if($alerts && count($alerts->alertArray) > 0){ ?>
	<div class="alerts-container">
		<?php $alerts->displayAll(); ?>
	</div>
	<?php } ?>

	<div class="container-fluid">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $index_path; ?>">Steel Admin</a>
		</div>
		<div class="collapse navbar-collapse" id="main-nav">
			<ul class="nav navbar-nav navbar-left">

				<?php foreach($pages as $page){

					echo '<li><a href="' . $app->get('index_path'). $page['page_url'] .'">' .$page['page_name']. '</a></li>';

				}?>

<!--
				<li>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</li>
-->

			</ul>
			<ul class="nav navbar navbar-right navbar-nav">

				<?php if($user->isAdmin()){ ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="/admin/pages"><span class="fa fa-file-o"></span>Pages</a></li>
						</ul>
					</li>
				<?php } ?>

				<?php if($user->loggedIn()){ ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span><?php echo $user->get('nickname');?>

						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $index_path ?>/page">PutPageHere</a></li>

							</a></li>
							<li><a class="logout text-danger" href="#">Logout</a></li>
						</ul>
					</li>


				<?php } else { ?>
					<li class="navbar-right"><button type="button" class="btn btn-primary navbar-btn" data-toggle="modal" data-target=".login-modal">Login</button></li>
				<?php } ?>
			</ul>

		</div>
	</div>
</nav>