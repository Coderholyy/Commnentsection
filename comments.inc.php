<?php

function setComments($conn){
	if(isset($_POST['commentsubmit'])){
		$uid = mysqli_real_escape_string($conn, $_POST['uid']);
		$date = mysqli_real_escape_string($conn, $_POST['date']);
		$message = mysqli_real_escape_string($conn, $_POST['messgae']);

		$sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '$message')";
		$result = $conn->query($sql);
	}
}

function getcomments($conn) {
		$sql = "SELECT * FROM comments";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc())	{
				
				$id = $row['uid'];
				$sql2 = "SELECT * FROM user WHERE id='$id'";
				$result2 = $conn->query($sql2);
				
				if($row2 = $result2->fetch_assoc()){
					echo "<div><p>";
					echo $row2['uid']."<br>";
					echo $row['date']."<br>";
					echo nl2br($row['message']);	
					echo "</p>";

					if(isset($_SESSION['id'])){
						if($_SESSION['id'] == $row2['id']){
							echo "<form method='POST' action='".deleteComments($conn)."'>
									<input type='hidden' name='cid' value='".$row['cid']."'>
									<button type='submit' name='commentdelete'>Delete</button>
								</form>

						<form method='POST' action='editcomment.php'>
							<input type='hidden' name='cid' value='".$row['cid']."'>
							<input type='hidden' name='uid' value='".$row['uid']."'>
							<input type='hidden' name='date' value='".$row['date']."'>
							<input type='hidden' name='message' value='".$row['message']."'>
							<button>Edit</button>
						</form>";
						}
						else{
							//reply function edit

							echo "<form method='POST' action='".deleteComments($conn)."'>	
									<input type='hidden' name='cid' value='".$row['cid']."'>
									<button type='submit' name='commentdelete'>Reply</button>
								</form>";
						}

					}
					else{
						echo "You need to be logged in to reply!! :p";
					}
					echo "</div>";

				}			
		}		
}

function editComments($conn){
	if(isset($_POST['commentsubmit'])){
		$cid = $_POST['cid'];
		$uid = $_POST['uid'];
		$date = $_POST['date'];
		$message = $_POST['message'];

		$sql = "UPDATE comments SET message='$message' WHERE cid='$cid'";
		$result = $conn->query($sql);
		header("Location: index.php");
	}
}

function deleteComments($conn){
	if(isset($_POST['commentdelete'])){
		$cid = $_POST['cid'];
		
		$sql = "DELETE FROM comments WHERE cid = '$cid'";
		$result = $conn->query($sql);
		header("Location: index.php");
	}
}

function getLogin($conn) {

		if(isset($_POST['loginsubmit'])){

			$uid = mysqli_real_escape_string($conn, $_POST['uid']);
			$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
			//mysqli_real_escape_string is to prevent SQL injection
			$sql = "SELECT * FROM user WHERE uid='$uid' AND pwd='$pwd'";
			$result = $conn->query($sql);
			if(mysqli_num_rows($result) > 0){
				if($row = $result->fetch_assoc())	{
					$_SESSION['id'] = $row['id'];
					header("Location: index.php?loginsuccess");
					exit();
				}
			}else {
					header("Location: index.php?loginfailed");
					exit();
			}
		}			
}

function userLogout() {
			if(isset($_POST['logoutsubmit'])){
				session_start();
				session_destroy();
			header("Location: index.php?");
					exit();	
	}			
}