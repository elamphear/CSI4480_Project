<?php
   include('session.php');
      
   	$result = mysqli_query($db, "SELECT userid,adminflag FROM users WHERE username = '$login_session' ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$userid = $row['userid'];
	$adminflag = $row['adminflag'];
   
	$error = "\t";

   if($_SERVER["REQUEST_METHOD"] == "POST") 
   {

      	$myusername = mysqli_real_escape_string($db,$_POST['username']);
		$mypassword = mysqli_real_escape_string($db,$_POST['password']);
		$myfname = mysqli_real_escape_string($db,$_POST['fname']);
		$mylname = mysqli_real_escape_string($db,$_POST['lname']);
		$myemail = mysqli_real_escape_string($db,$_POST['email']);
		$mypremiumflag = mysqli_real_escape_string($db,$_POST['premiumflag']);
		$myadminuser = mysqli_real_escape_string($db,$_POST['adminuser']);
		$myremoveuser = mysqli_real_escape_string($db,$_POST['removeuser']);
		      
		      
		if ($myremoveuser == "")
		{

			if($myusername == "" && $mypassword == "" && $myfname == "" && $mylname == "" && $myemail == "" && $myremoveuser == "")
			{
			         $error = "ERROR: No option selected.";		
			}

			elseif($myusername == "" || $mypassword == "" || $myfname == "" || $mylname == "" || $myemail == "" && $myremoveuser == "")
			{
			         $error = "ERROR: All fields required to add a new user.";		
			}

	      	elseif($myusername != "" && $mypassword != "" && $myfname != "" && $mylname != "" && $myemail != "" && $mypremiumflag != "" && $myadminuser != "")
	      	{
      
				$hashedpwd = password_hash($mypassword, PASSWORD_DEFAULT);
			    $sql = "INSERT INTO `users`(`userid`,`username`,`password`,`userfname`,`userlname`,`email`,`subscriptionstatus`,`adminflag`) VALUES ('','$myusername','$hashedpwd','$myfname','$mylname','$myemail','$mypremiumflag','$myadminuser')";
		      	$result = mysqli_query($db,$sql);
	      
		        $error = "User Added";
	        }
        }

		elseif ($myremoveuser != "")
		{

	      	if($myusername != "" || $mypassword != "" || $myfname != "" || $mylname != "" || $myemail != "")
			{
		         $error = "ERROR: Please only select one option at a time.";		
			}


    	 	elseif($myusername == "" && $mypassword == "" && $myfname == "" && $mylname == "" && $myemail == "" && $myremoveuser != "")
 			{
			    $sql = "DELETE FROM `playlistsongs` where exists (select * from playlists where playlistsongs.playlistid = playlists.playlistid and userid = $myremoveuser)";
		      	$result = mysqli_query($db,$sql);

			    $sql = "DELETE FROM `playlists` where userid = '$myremoveuser'";
		      	$result = mysqli_query($db,$sql);
		      
			    $sql = "DELETE FROM `users` where userid = '$myremoveuser'";
		      	$result = mysqli_query($db,$sql);

		      
		        $error = "User Removed";   		
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
	
    	<title>myMusic - Add/Remove Users</title>

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
               
				<!--Add User-->
               
				<div class="auto-style1" align="center">
                  
					<table align="center">
					
						<tr>
                  			<td valign="top"><label>Username : </label></td><td><input type = "text" name = "username" class = "box"/><br /><br /></td>
						</tr>

                  		<tr>
                  			<td valign="top"><label>Password : </label></td><td><input type = "text" name = "password" class = "box"/><br /><br /></td>
                  		</tr>
                  	
                  		<tr>
                  			<td valign="top"><label>First Name : </label></td><td><input type = "text" name = "fname" class = "box"/><br /><br /></td>          	
                  		</tr>
					
						<tr>
                  			<td valign="top"><label>Last Name : </label></td><td><input type = "text" name = "lname" class = "box"/><br /><br /></td>
                  		</tr>
                  	
                  		<tr>
	                		<td valign="top"><label>Email Address : </label></td><td><input type = "text" name = "email" class = "box"/><br /><br /></td>
                  		</tr>

					</table>
				  	
				  	<label>Subscription Status : </label>
					
					<form>

  						<select name="premiumflag">

    						<option selected="selected" value="0">Free User</option>

    						<option value="1">Premium User</option>

 						</select>
					
					</form> 
					
					<br><br>

				  	<label>Admin User :</label>
					
  					<select style="width:100px" name="adminuser">
  						
    					<option selected="selected" value="0">Normal User</option>
    				
						<option value="1">Admin User</option>

 					</select>

					<br><br><br>

                  	<input type = "submit" value = " Add User "/>
                  	
                  	<br><br><br>

					<!--Remove User-->
               	               
						<?php
				
							$sql = "SELECT userid,username FROM users";
							$result = $db->query($sql);

							echo "<label>User to Delete  : </label><select name='removeuser' style='width: 300px;'><option selected value>";

 							while($row = $result->fetch_assoc())
 							{
 						
								$userid = $row['userid'];
								$username = $row['username'];						
								echo "<option value='$userid'>$userid - $username</option>";
				 		
				 			}

							echo "</select>";
							echo "<input type = 'submit' value = ' Delete User '/><br /><br><br>";
                   
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