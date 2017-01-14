
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
<?php 
        session_start();
/*
Module		: WEB Programming using PHP (2016_17)

*/
?> 
	<head>
        <title> Module Results </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <h1> Please log in to access Module Results </h1>

        <?php
        // Declare variables
        $username = "";
        $password = "";
        $username_incorrect = "";
        $password_incorrect = "";
        $form_is_submitted = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
			// Validate Username   
            if (!empty($_POST['username'])){
                $username = trim($_POST['username']);
                $username = htmlentities($username);

            } else { 
                $username_incorrect = 'Please enter valid username!';  
            } 
            // Validate Password 
            if (empty($_POST['password'])){
                $password_incorrect = 'Please enter valid password!';
            } else {
            	$password = trim($_POST['password']);
                $password = htmlentities($password); 
                $last_check = check_data($username);

                if ($last_check == $password){
                    $_SESSION['user'] = $username;
                    $_SESSION['validated'] = true;
                    header('location: index.php');
                } else {
                    $password_incorrect = 'Please enter a valid username or password';
                }
            }
        }

        function check_data($username){
            $username_in_data = array();
            $password_in_data =array();
            // open the file 
            $handle = fopen ('users.txt','r');

            while(!feof($handle)){
                $find = fgets($handle, 1024);

                if(strlen($find)>0)){
                    $find = explode(' ',$find);
                    $user = $find[3];
                    $username_in_data[] = $user;
                    $password =$find[4];
                    $password_in_data[] = $password;
                }
            }

            if(in_array($username,$username_in_data)){
                $user_present = array_search($username,$username_in_data);
                $data_accepted = $password_in_data[$user_present];
                $data_accepted = rtrim($data_accepted, "\n");
                return $data_accepted;
            }
            // close the file
            fclose($handle);
        }
			?>
		
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <fieldset>
			<legend>Login</legend>
                <label for="username">User Name</label>
                    <input type="text" name="username" id="username">
                    <span> <?php echo $username_incorrect ?></span>
                </div>
                <div>            
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password">
                    <span> <?php echo $password_incorrect ?></span>
                </div>
                <div>            
                    <input type="submit" name="submit" value="Login">
                    <p>Please click for main page <a href= "index.php">Index</a> here.</p>
                </div>
            </fieldset>
        </form>
    </body>
</html>