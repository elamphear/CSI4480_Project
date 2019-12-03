<?php
	include('session.php');
      
   	$result = mysqli_query($db, "SELECT userid,adminflag FROM users WHERE username = '$login_session' ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$userid = $row['userid'];
    $adminflag = $row['adminflag'];
   
   	$error = "\t";

   	if($_SERVER["REQUEST_METHOD"] == "POST") 
   	{
      
      	$myplaylistname = mysqli_real_escape_string($db,$_POST['playlistname']);
      	$myglobalflag = mysqli_real_escape_string($db,$_POST['globalflag']);
      	$myremoveplaylist = mysqli_real_escape_string($db,$_POST['removeplaylistid']);
      
		if($myplaylistname != "" && $myremoveplaylist !="")
		{
			$error = "ERROR: Please only select one option at a time.";	
		}

      	elseif($myplaylistname != "")
		{
            		
      		if($myglobalflag == 1)
      		{
	  	  		$sql = "INSERT INTO `playlists`(`playlistid`, `name`, `globalflag`, `userid`) VALUES ('','$myplaylistname',1,NULL)";
				$result = mysqli_query($db,$sql);

        		$error = "Playlist Added";         
      		}
 
	  		elseif($myglobalflag == 0)
      		{      
	    		$sql = "INSERT INTO `playlists`(`playlistid`, `name`, `globalflag`, `userid`) VALUES ('','$myplaylistname',0,$userid)";
      			$result = mysqli_query($db,$sql);

        		$error = "Playlist Added";
      		}
      
      		else 
      		{
        		$error = "ERROR: All fields required";
      		}
		}

		elseif($myremoveplaylist !="")
		{
		    $sql = "DELETE FROM `playlistsongs` where playlistid = '$myremoveplaylist'";
	      	$result = mysqli_query($db,$sql);

		    $sql = "DELETE FROM `playlists` where playlistid = '$myremoveplaylist'";
	      	$result = mysqli_query($db,$sql);
	      	
	        $error = "Playlist Removed";
		}
		
		else
		{
			$error = "ERROR: No option selected";		
		}
	}
?>

<html>

	<head>
	
    	<title>myMusic - Add/Remove Playlist</title>

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
			    
            		<b>myMusic -- <a href = "welcome.php">Home Page</a> -- <a href = "logout.php">Sign Out</a>	</b>
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
            
           			<!--Add Playlist-->
               
            	   	<form action = "" method = "post">
            
				       	<div class="auto-style1">
            
		      				<label>Playlist Name  : </label><input type = "text" name = "playlistname" class = "box"/><br /><br />

						  	<label>Availablity : </label>

							<form>
		  						<select name="globalflag">

		    						<option selected="selected" value="0">Personal</option>

		    						<option value="1">Global</option>

			 					</select>

						</form> 
						
						<br><br>

		                <input type = "submit" value = " Add Playlist "/><br><br><br>

						<!--Remove Playlist-->
			
						<?php
							$sql = "SELECT playlistid,name FROM playlists where userid = $userid";
							$result = $db->query($sql);

							echo "<label>Playlist to Delete  : </label><select name='removeplaylistid' style='width: 200px;'><option selected value>";

 							while($row = $result->fetch_assoc()) 
 							{
								$removeplaylistid = $row['playlistid'];
								$name = $row['name'];						
								echo "<option value='$removeplaylistid'>$removeplaylistid - $name</option>";
				 			}

							echo "</select></form>   ";
							echo "<input type = 'submit' value = ' Delete Playlist '/><br /><br><br>";
                   
						?>

		               <br><a href='welcome.php'><font size ='2'><b>Back to Home</b></font></a>
               
					</div>

               	</form>
                              
               	<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?>
               	
               	</div>
					
	           </div>

			</div>
			
		</div>

	</body>

</html>