<?php
	$user = $data['user'];
?>

<a href="/users">..Back</a>

<?php
	foreach($user as $user){
		echo '<h1>'.$user['firstname'] . ' ' . $user['lastname'].'</h1>';
		//print_pre($user);
	}
?>