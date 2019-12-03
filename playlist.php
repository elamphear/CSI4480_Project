<?php
   include('session.php');

	$id = $_GET['id'];
	$song = $_GET['song'];

	$result = mysqli_query($db, "SELECT userfname, userlname, username, adminflag FROM users WHERE username = '$login_session' ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $userfname = $row['userfname'];
    $userlname = $row['userlname'];
    $adminflag = $row['adminflag'];

	$result = mysqli_query($db, "SELECT name, globalflag from playlists where playlistid = $id");
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$playlistname = $row['name'];
	$globalflag = $row['globalflag'];

?>

<html>

	<head>
	
    	<title>myMusic - Play Playlist</title>

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

					<b>myMusic -- <a href = "welcome.php">Home Page</a> -- <a href = "logout.php">Sign Out</a></b>
					
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

							<td valign="top">
      
								<?php

									$sql = "SELECT songid,title,artist FROM SONGS where exists (select * from playlistsongs where playlistsongs.playlistid = $id and songs.songid = playlistsongs.songid)";
									$result = $db->query($sql);

									echo "<table><tr><th><u>$playlistname</u><br><br></th></tr>";

						 			while($row = $result->fetch_assoc()) 
	 								{
										$songid = $row['songid'];
										$title = $row['title'];
										$artist = $row['artist'];
										echo "<tr><td><font size='2'><a href = 'playlist.php?id=$id&song=$songid'>$title</a></font></td><td><font size='2'><i>$artist</i></font></td></tr>";			
	 								}

						    	  	if($globalflag == 0 || $adminflag == 1)
	 					    	 	{
										echo "<td><br><a href='playlist_songs.php?id=$id'><font size ='2'><b>Add/Remove Songs</b></font></a></td>";
									}

								    echo "<tr><td><br><a href='welcome.php'><font size ='2'><b>Back to Home</b></font></a></td></tr>";

						 		   	echo "</table></td><td>";

									$sql = "SELECT songid,title,artist,album,songfilepath,albumartfilepath FROM SONGS where songid = '$song'";
									$result = $db->query($sql);
	
									echo "<b><table>";
			
									while($row = $result->fetch_assoc()) 
						 			{
										$title = $row['title'];
										$artist = $row['artist'];
										$album = $row['album'];
										$songfile = $row['songfilepath'];
										$albumart = $row['albumartfilepath'];
			
										echo "<tr><th>$title<br><i>$artist</i><br><i>$album</i><br><br></th></tr><tr><td><img alt='$title' src='$albumart' height='300' width='300'></td></tr><tr><td><audio autoplay src='$songfile' style='width: 300px;' controls='controls'></audio></td></tr>";			
	 								}
	
						 		   	echo "</table></b>";
	
								?>

							</td>
						
						</tr>
					
					</table>

				</div> 
		
			</div> 
		
		</div>
		
   </body>

</html>