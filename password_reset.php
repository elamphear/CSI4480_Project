<?php
   include('session.php');
      
   	$result = mysqli_query($db, "SELECT userid,adminflag FROM users WHERE username = '$login_session' ");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$userid = $row['userid'];
	$adminflag = $row['adminflag'];
   
	$error = "\t";

   if($_SERVER["REQUEST_METHOD"] == "POST") 
   {

      	$oldpass = mysqli_real_escape_string($db,$_POST['oldpass']);
		$newpass1 = mysqli_real_escape_string($db,$_POST['newpass1']);
		$newpass2 = mysqli_real_escape_string($db,$_POST['newpass2']);
		      
		$sql = "SELECT password FROM users WHERE userid = '$userid'";
      	$result = mysqli_query($db,$sql);
	  	$row = mysqli_fetch_row($result);
      	$oldhashedpwd = $row[0];

		$newhashedpwd = password_hash($newpass1, PASSWORD_DEFAULT);

		if ($oldpass == "" || $newpass1 == "" || $newpass2 == "")
		{
			$error = "ERROR: All fields required";		
		}

		elseif (! password_verify($oldpass, $oldhashedpwd))
		{
			$error = "ERROR: Old password does not match.";		
        }
		      
		elseif ($newpass1 != $newpass2)
		{
			$error = "ERROR: New passwords do not match.";		
        }
				            		
		else
		{
			$sql = "UPDATE users SET password = '$newhashedpwd' WHERE userid = '$userid'";
      		$result = mysqli_query($db,$sql);
   	  	
 	        $error = "Password Updated";   		

		}

   }
 
?>

<html>

	<head>
	
    	<title>myMusic - Change Password</title>

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
               
				<!--Change Password-->
               
				<div class="auto-style1" align="center">
                  
					<table align="center">
					
						<tr>
                  			<td valign="top"><label>Old Password        : </label></td><td><input type = "text" name = "oldpass" class = "box"/><br /><br /></td>
						</tr>

                  		<tr>
                  			<td valign="top"><label>New Password        : </label></td><td><input type = "text" name = "newpass1" class = "box"/><br /><br /></td>
                  		</tr>
                  	
                  		<tr>
                  			<td valign="top"><label>Verify New Password : </label></td><td><input type = "text" name = "newpass2" class = "box"/><br /><br /></td>          	
                  		</tr>
					
					</table>
				  	
					<br>

                  	<input type = "submit" value = " Change Password "/>
                  	
                  	<br><br><br>
               
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