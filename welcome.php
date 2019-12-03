<?php
   include('session.php');

	$result = mysqli_query($db, "SELECT userid, userfname, userlname, username,adminflag FROM users WHERE username = '$login_session' ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$userid = $row['userid'];
    $userfname = $row['userfname'];
    $userlname = $row['userlname'];
    $adminflag = $row['adminflag'];
?>

<html>

	<head>
	
    	<title>myMusic - Home</title>

		<style type = "text/css">
        	body 
         	{
            	font-family:Arial, Helvetica, sans-serif;
            	font-size:14px;
         	}
         
         	label 
         	{
            	font-weight:bold;
            	width:100px;
            	font-size:14px;
         	}
         
         	.box 
         	{
            	border:#666666 solid 1px;
         	}

      		.auto-style1 
      		{
		  	text-align: center;
	  		}

      		a { color: inherit; }
			a:link { text-decoration: none;}
						
      </style>
      
   </head>
   
	<body bgcolor = "#B2B1B1">
	
		<div align = "center">
 
			<img alt="myMusic" src="header.jpg" width="600px" height="240px">
			
			<br>

        	<div style = "width:600px; border: solid 1px #333333; " align = "left">

				<div style = "width:594px;background-color:#333333; color:#FFFFFF; padding:3px;" align="center">
			
					<b>myMusic -- Welcome <?php echo $userfname; ?> -- <a href = "logout.php">Sign Out</a></b>
					
				</div>

				<?php
				
					if($adminflag == '1')
					{
						echo "<div style = 'width:594x;background-color:#2F4F4F; color:#FFFFFF; padding:3px;' align='center'>";
						echo "<b>Admin Options -- <a href = 'song_manage.php'>Add/Remove Song from DB</a> -- <a href = 'user_manage.php'>Add/Remove User from DB</a></b>";
						echo "<br></div>";
					}
					
				?>

				<div style = "margin:30px">

					<table>
					
						<tr>
						
							<td>
						
								<br><a href='password_reset.php'><b>Reset Password</b></a><br><br><br>

								<?php		

									$sql = "SELECT playlistid,name FROM Playlists where Userid = '$userid'";
									$result = $db->query($sql);

									echo "<table><tr><th><u>My Playlists</u></th></tr>";

 									while($row = $result->fetch_assoc()) 
 									{
										$id = $row['playlistid'];

										$result1 = mysqli_query($db, "SELECT songid FROM playlistsongs WHERE playlistid = $id limit 1");
    									$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
										$song = $row1['songid'];

										$name = $row['name'];
										echo "<tr><td><a href = 'playlist.php?id=$id&song=$song'>$name</a></td></tr>";			
 									}

								 	echo "</table><br><a href='playlist_manage.php'><b>Add/Remove Playlist</b></a><br><br><br>";

									$sql = "SELECT playlistid,name FROM Playlists where GlobalFlag = '1'";
									$result = $db->query($sql);

									echo "<table><tr><th><u>Global Playlists</u></th></tr>";

							 		while($row = $result->fetch_assoc()) 
 									{
										$id = $row['playlistid'];

										$result1 = mysqli_query($db, "SELECT songid FROM playlistsongs WHERE playlistid = $id limit 1");
							    		$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
										$song = $row1['songid'];

										$name = $row['name'];
										echo "<tr><td><a href = 'playlist.php?id=$id&song=$song'>$name</a></td></tr>";			
							 		}

						 	   		echo "</table>";

								?>
		
							</td>
					
							<td width="400px">
						
								<img align="right" alt='$title' src='welcome.jpg' height='300' width='300'>
						
							</td>
						
						</tr>

					</table>		
		
				</div>
			
			</div>
	
		</div>

   </body>
   
</html>