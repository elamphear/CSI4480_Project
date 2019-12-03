<?php
   include('session.php');
      
   	$result = mysqli_query($db, "SELECT userid,adminflag FROM users WHERE username = '$login_session' ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$userid = $row['userid'];
	$adminflag = $row['adminflag'];
   
	$error = "\t";

   if($_SERVER["REQUEST_METHOD"] == "POST") 
   {

      	$mytitle = mysqli_real_escape_string($db,$_POST['title']);
		$myartist = mysqli_real_escape_string($db,$_POST['artist']);
		$myalbum = mysqli_real_escape_string($db,$_POST['album']);
		$mygenre = mysqli_real_escape_string($db,$_POST['genre']);
		$mysongfilepath = mysqli_real_escape_string($db,$_POST['songfilepath']);
		$myalbumartpath = mysqli_real_escape_string($db,$_POST['albumartpath']);
		$mypremiumflag = mysqli_real_escape_string($db,$_POST['premiumflag']);
		$myremovesong = mysqli_real_escape_string($db,$_POST['removesong']);
		      
		      
		if ($myremovesong == "")
		{

			if($mytitle == "" && $myalbum == "" && $mygenre == "" && $mysongfilepath == "" && $myalbumartpath == "" && $myremovesong == "")
			{
			         $error = "ERROR: No option selected.";		
			}

			elseif($mytitle == "" || $myalbum == "" || $mygenre == "" || $mysongfilepath == "" || $myalbumartpath == "" || $mypremiumflag == "" && $myremovesong == "")
			{
			         $error = "ERROR: All fields required to add a new song.";		
			}

	      	elseif($mytitle != "" && $myalbum != "" && $mygenre != "" && $mysongfilepath != "" && $myalbumartpath != "" && $mypremiumflag != "")
	      	{
      
			    $sql = "INSERT INTO `songs`(`songid`,`title`,`album`,`artist`,`genre`,`songfilepath`,`albumartfilepath`,`premiumflag`) VALUES ('','$mytitle','$myalbum','$myartist','$mygenre','MusicFiles/$mysongfilepath','AlbumArt/$myalbumartpath','$mypremiumflag')";
		      	$result = mysqli_query($db,$sql);

   				$result = mysqli_query($db, "SELECT songid FROM songs WHERE title = '$mytitle' and artist = '$myartist' ");
    			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				$addedsongid = $row['songid'];
				
			    $sql = "INSERT INTO `playlistsongs`(`playlistid`,`songid`) VALUES (1,$addedsongid)";
		      	$result = mysqli_query($db,$sql);

	      
		        $error = "Song Added";

	        }
        }

		elseif ($myremovesong != "")
		{

	      	if($mytitle != "" || $myalbum != "" || $mygenre != "" || $mysongfilepath != "" || $myalbumartpath != "")
			{
		         $error = "ERROR: Please only select one option at a time.";		
			}


    	 	elseif($mytitle == "" && $myalbum == "" && $mygenre == "" && $mysongfilepath == "" && $myalbumartpath == "" && $myremovesong != "")
 			{

			    $sql = "DELETE FROM `playlistsongs` where songid = $myremovesong";
		      	$result = mysqli_query($db,$sql);

			    $sql = "DELETE FROM `songs` where songid = $myremovesong";
		      	$result = mysqli_query($db,$sql);
		      
		        $error = "Song Removed";   		

 			}

		}
				            		
		else
		{
			$error = "ERROR: No option selected";		
		}

   }
 
?>

<html>

	<head>
	
    	<title>myMusic - Add/Remove Songs from Database</title>

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

					<!--Add Song-->

                  	<div class="auto-style1" align="center">
                  
						<table align="center">
							<tr>
		                  		<td valign="top"><label>Name  : </label></td><td><input type = "text" name = "title" class = "box"/><br /><br /></td>
							</tr>

		                  	<tr>
		                  		<td valign="top"><label>Artist   : </label></td><td><input type = "text" name = "artist" class = "box"/><br /><br /></td>
		                  	</tr>
		                  	
		                  	<tr>
		                  		<td valign="top"><label>Album    : </label></td><td><input type = "text" name = "album" class = "box"/><br /><br /></td>          	
		                  	</tr>
					
							<tr>
                  				<td valign="top"><label>Genre    : </label></td><td><input type = "text" name = "genre" class = "box"/><br /><br /></td>
                  			</tr>
                  			
                  			<tr>
	                			<td valign="top"><label>MP3 File : </label></td><td><input type = "text" name = "songfilepath" class = "box"/><br /><br /></td>
                  			</tr>
                  			
                  			<tr>
                  				<td valign="top"><label>Album Art File : </label></td><td><input type = "text" name = "albumartpath" class = "box"/><br /><br /></td>
                  			</tr>

						</table>
						
				  		<label>Premium  : </label>

							<form>
		  						<select name="premiumflag">

			    					<option selected="selected" value="0">Free Song</option>

			    					<option value="1">Premium</option>
		 				
								</select>
						
							</form> 
						
						<br><br>

                  		<input type = "submit" value = " Add Song "/><br /><br><br>

						<br><br>

               			<!--Remove Song-->
               	               
						<?php
						
							$sql = "SELECT songid,title,artist FROM SONGS";
							$result = $db->query($sql);

							echo "<label>Song to Delete : </label><select name='removesong' style='width: 300px;'><option selected value>";

 							while($row = $result->fetch_assoc()) 
 							{

								$songid = $row['songid'];
								$title = $row['title'];						
								$artist = $row['artist'];
								echo "<option value='$songid'>$songid - $title - $artist</option>";

				 			}

							echo "</select>";
							echo "<input type = 'submit' value = ' Delete Song '/><br /><br><br>";
                   
						?>
               
    	          	</div>
    
	           	</form>
               
               	<div style = "font-size:11px; color:#cc0000; margin-top:10px">
               
               		<?php echo $error; ?>
               
				</div>
					
            </div>
				
         </div>
			
      </div>

   </body>

</html>