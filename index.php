<?php
	date_default_timezone_set('asia/kolkata');
	include 'database.php';
	include 'comments.inc.php';
	session_start();
?>


<!DOCTYPE html>
<html>
	<body>
<?php

	echo	"<form method='POST' action='".getLogin($conn)."'>
			<input type='text' name='uid'>
			<input type='password' name='pwd'>
			<button type='submit' name='loginsubmit'>LOGIN</button>
		</form>";
	echo	"<form method='POST' action='".userLogout()."'>
			<button type='submit' name='logoutsubmit'>LOGOUT</button>
		</form>";

	if(isset($_SESSION['id'])){
		echo "You are logged in!";
	} else {
		echo "You are not logged in!!";
	}		
?>
<br><br>
		<?php
			if(isset($_SESSION['id'])){
				echo "<form method='POST' action='".setComments($conn)."'>
						<input type='hidden' name='uid' value='".$_SESSION['id']."'></input>
						<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'></input>
						<textarea name='message'></textarea><br>
						<button name='commentsubmit' type='submit'>COMMENTS</button>
					</form>";
			} else {
				echo "You are need to be logged in to comment !!
				<br><br>";
			}	


			getcomments($conn);
		?>
	</body>


</html>