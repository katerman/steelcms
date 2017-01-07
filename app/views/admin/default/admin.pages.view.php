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

	print_pre($pages);
?>

<div class="container">
	<div class="row">

		<ul>
		<?php
			foreach($pages as $page){
				echo '<li>' . $page['page_name'] . '</li>';
			}
		?>
		</ul>

	</div>
</div>