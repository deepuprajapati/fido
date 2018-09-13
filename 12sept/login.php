<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
*	Admin Login Form
*/
include_once('include/guestHeader.php');
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/
if(isset($_COOKIE['user_info'])){
	header('Location: index.php');
	exit();
}
if(isset($_POST['userid']) and isset($_POST['password'])){
	$user  = new Admin();
    $userObj = new UserTypes();

		$user->email = $_POST['userid'];
	    $user->password = md5($_POST['password']);
		$userarray=$user->findCustom(Array('email'=>$user->email,'password'=>$user->password));

		if(isset($user->variables[0]['id'])){
		$getusertypeinfo = $userObj->find($user->variables[0]['type']);
            
            if($getusertypeinfo['type_category'] == 'I') {
           
            setcookie("isActive", true, time() + (60 * 20)); // 60 seconds ( 1 minute) * 20 = 20 minutes

			$_SESSION['admin_info'] = $user->variables[0];
			setcookie('user_info', json_encode($_SESSION['admin_info']));
            //$array_groups = explode(",",$user->variables[0]['groups']);
                $groups = array();
                foreach(explode(",",$user->variables[0]['groups']) as $key=>$value){
                    $urlforservice = $config['API_BASE_URL']."getGroupInfo/".$value;
                    $services = getCURL($urlforservice);
                    if(!empty($groups)){
				        $groups = array_merge($groups,$services['data']);
                    }
                    else
                    {
                        $groups = $services['data'];
                    }
                }
                $_COOKIE['user_info'] = json_encode($_SESSION['admin_info']);
                    $final_groups = array_unique($groups);
						setcookie('permission_info', json_encode($final_groups));
						//$_SESSION['msg'] = 'you have successfully Logged in';
						$id = $user->variables[0]['id'];
						$users = new Admin();
						$users->id	 = $id;
						$users->token = session_id();
						$users->save();
						/*$user->updated_at=date('y-m-d h:i:s');
						$user->id=$user->variables[0]['id'];
						$user->save();*/
        
            $people = array(11, 13, 3, 12,17);
       if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
           setcookie('url_info', 'dashboard.php');
           redirectAdmin($_GET['redirect']);
       } else {
       
            if (in_array($user->variables[0]['type'], $people))
                {
                    setcookie('url_info', 'dashboard.php');
                    redirectAdmin('dashboard.php');
            }
            else if($user->variables[0]['type'] == 5){
                    setcookie('url_info', 'dashboard.php');
                    redirectAdmin('dashboard.php');
            }
            else if($user->variables[0]['type'] == 4){
                    setcookie('url_info', 'dashboard.php');
                    redirectAdmin('dashboard.php');
            }
            else{
                    setcookie('url_info', 'dashboard.php');
                    redirectAdmin('dashboard.php');
            }
        }
        }else if($getusertypeinfo['type_category'] == 'E'){
                if($getusertypeinfo['is_publisher'] == 0){
                    $_SESSION['client_info'] = $user->variables[0];
			         setcookie('client_info', json_encode($_SESSION['client_info']));
                    $id = $user->variables[0]['id'];
                    $users  = new Admin();
                    $users->id	 = $id;
                    $users->token = session_id();
                    $users->save();
                    setcookie('url_info', 'client.php');
                    redirectAdmin('client.php');
                }
                if($getusertypeinfo['is_publisher'] == 1){
                    setcookie('url_info', 'publisher.php');
                    redirectAdmin('publisher.php');
                }

            }
            else{
                redirectAdmin('logout.php');
            }
		}
		else{
			$_SESSION['msgerror'] = "Invalid login details";
			redirectAdmin('login.php');
		}
}

?>
<script src="asset/js/jquery-1.8.0.min.js" type="text/javascript"></script>
<script src="asset/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" type="text/javascript"></script>

	<div class="fullWidth_flx">

        <div class="leftside_wrapper">
            <div class="leftside_logo_inner"><img src="asset/img/fido-logo.png" /></div>
        </div>
        <div class="rightside_wrapper">
		
            <div class="rightside_wrapper_inner">
				<div class="welcome_mess"><?php if(isset($_SESSION['logout'])) {  unset($_SESSION['logout']); ?><p> Thank you for visiting<br>Fido!</p><?php } else{ ?> <p>Good morning and<br> welcome back!<?php } ?></p></div>
                <div class="formHolder">
                <form role="form" action="" method='post'>
				
				<?php
				if(isset($_SESSION['msgerror'])){                                    
				?>
				<div class="alert alert-info alert-dismissible fade in myalert_style shake animated jSfadeOut_auto" >
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Danger!</strong> <?php echo $_SESSION['msgerror']; ?>
				</div>

				<?php
				unset($_SESSION['msgerror']);                     
				}
				?>
				<div class="formstyle">	
					<input type="text" class="form-control input-style" placeholder="Username" name='userid' autofocus required>
                    <input type="password" class="form-control lastinput input-style" placeholder="Password" name='password' required id="showmypass">
					<div class="show showStyle">
                        <div class="pull-right forgetStyle"><a href="forgotPassword.php">Forgot password?</a></div>
						<label class="checkbox_wpr"><div class="chkcNice"><input type="checkbox" onclick="showPassword()" value="remember-me"><span class="checkmark" ></span></div>Show password</label>
					</div>
					<button class="btn btn-primary btn-lg btn-block input_btn_style" type="submit">Sign in</button>
                    <div class="feedback"><p>For feedback - </p> <a href="mailto:save-quoNn3LxMFGB@3.basecamp.com">Email Us</a></div>
				</div>	
				</form>
				</div>
            </div>
        </div>
    </div>

<?php if(isset( $_COOKIE['already_visited_new'])) {
   
        $already_visited_new=$_COOKIE['already_visited_new'];
     $time=strtotime (date("Y-m-d 23:59:59")) -strtotime(date('Y-m-d h:i:s'));
    $newtime =time()+$time;
    setcookie('already_visited_new', '1', time() + $time);
    
}else
{
    $already_visited_new='';
    
    
}
?>

<script type="text/javascript">
		$(document).ready(function(){
			
			$('.jSfadeOut_auto').fadeOut(7000);
		});
		$(document).ready(function(){
			var today = new Date()
			var curHr = today.getHours()
			//var cookieValue = $.cookie("already_visited_new");
            	var cookieValue = '<?php echo $already_visited_new; ?>'
          
			if(cookieValue==1){
				var text='Welcome back!';
			}else{
				var text='Welcome to Fido!';
			}
            
            
			
                    if(cookieValue==2){


                        $('.welcome_mess p').html('Thank you for visiting<br>Fido!');

                   
                        

                    }else{
                        if (curHr < 12) {
                            $('.welcome_mess p').html('Good morning and<br>'+text);

                        } else if (curHr < 16) {
                            $('.welcome_mess p').html('Good afternoon and<br>'+text);

                        } else {
                            $('.welcome_mess p').html('Good Evening and<br>'+text);

                        }
                    }
               
		
		});
    function java_mktime(hour,minute,month,day,year) {
        currenttime= new Date(year, month - 1, day, hour, minutes, 0, 0) ;
        time= currenttime.getTime();
        return time;
    }
	
	
	function showPassword() {
		var x = document.getElementById("showmypass");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
	</script>
</body>

</html>
