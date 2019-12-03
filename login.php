<?php
   include("config.php");
   session_start();
   
   $error = "\t";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") 
   {
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      //$hashedpwd = password_hash($mypassword, PASSWORD_DEFAULT);
      //var_dump($hashed_password);
      
      $sql = "SELECT password FROM users WHERE username = '$myusername'";
      $result = mysqli_query($db,$sql);
	  $row = mysqli_fetch_row($result);
      $hashedpwd = $row[0];
      
	  if(password_verify($mypassword, $hashedpwd)) {
         $_SESSION['login_user'] = $myusername;
         
         header("location: welcome.php");
      }else {
         $error = "Your Username or Password is invalid";
      }
   }
?>
<html>

	<head>
	
    	<title>myMusic</title>

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
        
		    <div style = "background-color:#333333; color:#FFFFFF; padding:3px;" align="center"><b>myMusic Login</b></div>
				
	            <div style = "margin:30px">
               
	               	<form action = "" method = "post">
	               
	               		<div class="auto-style1">
		                	
		                	<label>Username  :</label><input type = "text" name = "username" class = "box"/><br /><br />
		                	
		                	<label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
		                	
		                	<input type = "submit" value = " Login "/><br />
		                	
		                	<br><br>
		                	
		                	<a href="mailto:lamphear@gmail.com?subject=myMusic - Reset Password&body=Please provide your username to reset :: "><b>Reset Password</b></a>
		                	
		                	<br><br>
		                	
		                	<a href="mailto:lamphear@gmail.com?subject=myMusic: Sign Up New User&body=Please provide a desired username and password :: "><b>Sign Up</b></a>
	               		
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