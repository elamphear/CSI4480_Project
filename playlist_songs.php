<?php
   include('session.php');
   
	$id = $_GET['id'];
		   
   	$result = mysqli_query($db, "SELECT userid,adminflag FROM users WHERE username = '$login_session' ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$userid = $row['userid'];
    $adminflag = $row['adminflag'];


   	$result = mysqli_query($db, "SELECT name FROM playlists WHERE playlistid = $id ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$playlistname = $row['name'];
   
   	$error = "\t";
   
   	if($_SERVER["REQUEST_METHOD"] == "POST") 
   	{
      
		$myaddsong = mysqli_real_escape_string($db,$_POST['addsong']);
		$myremovesong = mysqli_real_escape_string($db,$_POST['removesong']);
      
      	if($myaddsong == "" && $myremovesong == "")
		{
		         $error = "ERROR: No selection made";		
		}

		elseif($myaddsong != "" && $myremovesong != "")
		{
		         $error = "ERROR: Please only select one option at a time.";		
		}
		            		
      	elseif($myaddsong != "")
      	{
      
		    $sql = "INSERT INTO `playlistsongs`(`playlistid`, `songid`) VALUES ('$id',$myaddsong)";
	      	$result = mysqli_query($db,$sql);
      
	        $error = "Song Added";
        }
        
        elseif($myremovesong != "")
        {
		    $sql = "DELETE FROM `playlistsongs` where playlistid = '$id' and songid = '$myremovesong'";
	      	$result = mysqli_query($db,$sql);
	      
	        $error = "Song Removed";  
      	}      		
   }
?>

<html>

	<head>
	
    	<title>myMusic - Add/Remove Songs from Playlist</title>

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

            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;" align="center">

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
               
				<form action = "" method = "post">

               		<div class="auto-style1">

						<b><?php echo "Add/Remove Songs for $playlistname" ?></b><br><br><br>
                   
	               	  	<?php

							//Add Song
							$sql = "SELECT songid,title,artist FROM SONGS where not exists (select * from playlistsongs where playlistsongs.playlistid = $id and playlistsongs.songid = songs.songid)";
							$result = $db->query($sql);

							echo "<label>Song to Add  : </label><form><select name='addsong' style='width: 300px;'><option selected value>";

	 						while($row = $result->fetch_assoc()) 
	 						{
								$songid = $row['songid'];
								$title = $row['title'];						
								$artist = $row['artist'];
								echo "<option value='$songid'>$title - $artist</option>";
					 		}

							echo "</select>   ";
							echo "<input type = 'submit' value = ' Add Song '/><br /><br><br>";
                                      
							//Remove Song
							$sql = "SELECT songid,title,artist FROM SONGS where exists (select * from playlistsongs where playlistsongs.playlistid = $id and playlistsongs.songid = songs.songid)";
							$result = $db->query($sql);

							echo "<label>Song to Delete  : </label><select name='removesong' style='width: 300px;'><option selected value>";

 							while($row = $result->fetch_assoc()) 
 							{
								$songid = $row['songid'];
								$title = $row['title'];						
								$artist = $row['artist'];
								echo "<option value='$songid'>$title - $artist</option>";
				 			}

							echo "</select></form>   ";
							echo "<input type = 'submit' value = ' Delete Song '/><br /><br><br>";
                   
              				$result1 = mysqli_query($db, "SELECT songid FROM playlistsongs WHERE playlistid = $id limit 1");
 				   			$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
							$songid = $row1['songid'];

                   
	                   		echo "<td><br><a href='playlist.php?id=$id&song=$songid'><font size ='2'><b>Back to Playlist</b></font></a></td>";

		                   	echo "<br><br><a href='welcome.php'><font size ='2'><b>Back to Home</b></font></a>";
                   
	                   	?>

 
               		</div>

				</form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>

</html>