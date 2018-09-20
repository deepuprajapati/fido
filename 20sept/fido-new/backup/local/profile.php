<?php
/**
*	THIS FILE IS FOR ADMIN LOGIN LOGOUT	5/4/2014
**/
$fileBasePath = dirname(__FILE__).'/';
include_once('include/header.php');
include_once('include/sidebar.php');
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/
$partner = new Partner();
$user  = new Admin();
$usermeta=new usermeta();


if(isset($userinfo['id']))
{
	$userid=$userinfo['id'];
	$userlist=$user->findCustomRow(array('id'=>$userid));
}

$userpermission=new userPermission();
$partnerlist=$partner->all();

 //  $allLanguages = $language->getColumns();
if(isset($_POST['email'])){

$result= $user->findcustomrow(array('email'=>$_POST['email']));

if(empty($result) || $result['email'] ==$_POST['email'] )
{



	$user->id=$userid;
	$user->name = trim($_POST['name']);

	//$user->email	 = trim($_POST['email']);
	$user->address	 = $_POST['address'];
	$user->phone	 = $_POST['phone'];

	

	$user->updated_at=date('Y-m-d H:i:s');
    $user->last_login=date('Y-m-d H:i:s');
	$_SESSION['msgsuccess'] = "User has been saved successfully";
	$user->save();
	
	
	redirectAdmin('profile.php');

}
else
{
$_SESSION['msgsuccess'] = "This Email id already EXists";
	redirectAdmin('profile.php');
}
}




	//_d($allLanguages);
	?>
	            <!-- Right side column. Contains the navbar and content of the page -->
 <section class="main-content">
   <div class="content-wrap">
	  <div class="wrapper">
					<section class="content-header">
					<h1>
						Users Profile

					</h1>
					
					</section>
            <div class="row">
                    <div class="col-md-6">
					<section class="panel">

                            <div class="panel-body">
                                <form class="parsley-form" role="form"  method='post'>

                                  
                                            <div class="form-group">
                                                <label>Name</label>
                                                <div>
                                                    <input type="text" placeholder=" Name"   name="name" class="form-control" value='<?php echo $userlist['name']?>' required>
                                                     <input type="hidden" placeholder="Email"  name="email" class="form-control" value='<?php echo $userlist['email']?>'>
                                                </div>
                                            </div>


                                           <!-- <div class="form-group">
                                                <label>Email</label>
                                                <div>
                                                    <input type="email" placeholder="Email"  name="email" class="form-control" value='<?php echo $userlist['email']?>' >
                                                </div>
                                            </div>-->


                                                


                                           
                                        
                                           <!-- <div class="form-group">
                                                <label>Username</label>
                                                <div>
                                                    <input type="text" required placeholder="username"  name="username" class="form-control" value='<?php echo $userlist['username']?>'>
                                                </div>
                                            </div>-->

                                            <div class="form-group">
                                                <label>Phone</label>
                                                <div>
                                                    <input type="text" placeholder="18005551234"   name="phone" class="form-control" value='<?php echo $userlist['phone']?>' >
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label>Employee code</label>
                                                <div>
                                                    <input type="text" placeholder="Address" required name="address" class="form-control"  value='<?php echo $userlist['address']?>' >
                                                </div>
                                            </div>

                                       

										
										
                                      
                                            <div class="form-group text-center">
                                                <label></label>
                                                <div>
                                                    <button class="btn btn-primary btn-block btn-lg btn-parsley">Submit</button>
                                                </div>
                                            </div>
                                        
                                </form>
                        </div>
                            
                        </section>
                </div>
                 <div class="col-md-6">
          
                        <section class="panel">

                            <div class="panel-body">
                                <form class="parsley-form" role="form" id="chng_forget_pwd"  method='post'>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <div>
                                                    <input type="password" placeholder=" Old Password"   name="oldpassword" class="form-control" value='' required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <div>
                                                    <input id='pwd' type="password" placeholder="New Password"  name="password" class="form-control" value='' required >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm New Password</label>
                                                <div>
                                                    <input id="confirm" type="password" placeholder="Confirm New Password"  name="confirm" class="form-control" value='' required >
                                                </div>
                                            </div>
                                            
                                                <div class="form-group text-center">
                                                <label></label>
                                                <div>
                                                    <button class="btn btn-primary btn-block btn-lg btn-parsley" value="">Change Password</button>
                                                </div>
                                            </div>
                                        
                                            
                                        </div>
                                      
                                    </div>
                                </form>
                            </div>
                        </section>
					</div>
				</div>
       </div>
     </div>
                            <a class="exit-offscreen"></a>
  </section><!-- /.right-side -->
<?php
include_once('include/footer.php');

?>
<script>
    $('#chng_forget_pwd').submit(function(e){
        e.preventDefault();
        curpwd=$('#confirm').val();
        newpwd=$('#pwd').val();
        url='ajax.php?changepwd';
        formdata=$('#chng_forget_pwd').serialize();
        if(curpwd==newpwd)
            {
                jQuery.ajax({
                    timeout: 10000,
                    type: 'post',
                    url: url,
                    data: formdata,
                    dataType: 'json',
                    success: function(res) {
                        
                        if(res.result==0)
                            {
                                 alert('Password Changed Successfully.');
                            }
                        else if(res.result==1)
                            {
                                 alert('Your have enter wrong password in current password');
                            }
                        else{
                             alert('New Password and confirm Password Field should match.');
                        }
                        
                    },
                    error:function (res){

                    }
                }); 
            }
        else{
            alert('New Password and confirm Password Field should match.');
        }
        
        
    })

	$('#usertype').change(function(){
		var usertype=$("#usertype option:selected").val();

		if(usertype=='7' || usertype=='8' || usertype=='9' || usertype=='10' )
		{
			if(usertype=='10'){
				$('.finance').show();
				$('.finance input').each(function(){
				$(this).attr('required','required');
			});
			}
			else{
				$('.finance').hide();
				$('.finance input').each(function(){
				$(this).attr('required',false);
			})
			}
			$('.both').show();
			$('#partner').attr('required','required');
		}
		else{
			$('.finance').hide();
			$('.finance input').each(function(){
				$(this).attr('required',false);
			});

			$('.both').hide();
			$('#partner').attr('required', false);
		}

	})
</script>
