<?php
	$users = $data['users'];
?>

<ul>
	<?php

		foreach($users as $user){
			echo '<li><a href="./user/' . $user['id'] . '">' . $user['firstname'] . '</a></li>';
		}

	?>
</ul>