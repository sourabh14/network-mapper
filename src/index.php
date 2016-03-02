<?php session_start(); /* Starts the session */
	
	/* Check Login form submitted */	
	if(isset($_POST['Submit'])){
		/* Define username and associated password array */
		$logins = array('admin' => 'test');
		
		/* Check and assign submitted Username and Password to new variable */
		$Username = isset($_POST['Username']) ? $_POST['Username'] : '';
		$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
		
		/* Check Username and Password existence in defined array */		
		if (isset($logins[$Username]) && $logins[$Username] == $Password){
			/* Success: Set session variables and redirect to Protected page  */
			$_SESSION['UserData']['Username']=$logins[$Username];
			header("location:homePage.html");
			exit;
		} else {
			/*Unsuccessful attempt: Set error message */
			$msg="<span style='color:red'>Invalid Login Details</span>";
		}
	}
?>
<head> 
<style type="text/css"> 
.centerDiv { 
 position: fixed;
        width: 40%; /* Set your desired with */
        z-index: 2; /* Make sure its above other items. */
        top: 40%;
        left: 40%;
        margin-top: -10%; /* Changes with height. */
        margin-left: -10%; /* Your width divided by 2. */

        /* You will not need the below, its only for styling   purposes. */
        padding: 10px;
        border: 2px solid #555555;
        
        border-radius: 5px;
        text-align: center;
	background-color: white;
} 
body {
    background-image: url("images.png");
    
}
Button3 {
left: 50%;
}

</style>
 </head>
 <body> <div class="centerDiv">  
<form action="" method="post" name="Login_Form">
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
    <?php if(isset($msg)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2" align="left" valign="top"><h3><center><img src="2.png"></center></h3></td>
    </tr>
    <tr>
      <td align="right" valign="top">Username</td>
      <td><input name="Username" type="text" class="Input"></td>
    </tr>
    <tr>
      <td align="right">Password</td>
      <td><input name="Password" type="password" class="Input"></td>
    </tr>
    <tr>
      <td> </td>
      <td><input name="Submit" type="submit" value="Login" class="Button3"></td>
    </tr>
  </table>
</form>
</div> </body>

