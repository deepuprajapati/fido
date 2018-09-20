<?php include('include/header-files.php'); ?>

<!-- write your custom css and js here -->
	<style>
	
	.pageSub_icn:before{
		    content: "\ea48";
	}
	
	</style>
<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>
<?php
/**
*	THIS FILE IS FOR ADMIN LOGIN LOGOUT	5/4/2014
**/
$fileBasePath = dirname(__FILE__).'/';
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
	<!-- Page container begins -->
	<section class="main-container">
		
			<!-- Page header -->
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">User Profile</div>
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
			<!-- /Page header -->

			<div class="container-fluid page-content">

				<div class="row">
					<div class="col-lg-3 col-sm-4">

						<!-- User thumbnail -->
						<div class="card card-block">
							<div class="thumb thumb-rounded">
								<img src="http://via.placeholder.com/200x200" alt="">
							</div>
							<div class="caption text-center">
								<h3 class="m-t-20"><?php echo $userlist['name']?></h3>
								
							</div>
						</div>
						<!-- /user thumbnail -->



						
					</div>

					<div class="col-lg-9 col-sm-8">


						<div class="card card-inverse card-flat">
							<div class="card-header">
								<div class="card-title"><i class="icon-user position-left"></i>About - <?php echo $userlist['name']?></div>
							</div>
							<table class="table table-borderless table-striped">
								<tbody>
									<tr>
										<td><strong>Phone</strong></td>
										<td><a href="javascript:void(0)"><?php echo $userlist['phone']?></a></td>
									</tr>
									<tr>
										<td><strong>Employee code</strong></td>
										<td><a href="javascript:void(0)"><?php echo $userlist['address']?></a></td>
									</tr>
									</tbody>
							</table>
						</div>
						
						<div class="page-subtitle pageSub_icn">User profile setting</div>
						
						<div class="card-group card-group-control card-group-control-right accordion" id="accordion-control-right">
							<div class="card card-inverse">
								<div class="card-header">
									<div class="card-title">
										<a data-toggle="collapse" data-parent="#accordion-control-right" class="collapsed" href="#accordion-control-right-group1">User Profile Update</a>
									</div>
								</div>
								<div id="accordion-control-right-group1" class="card-collapse collapse">
									<div class="card-block">
										<div class="col-md-8" style="margin: 0px auto;">
										
										<form role="form"  method='post'>
										<div class="form-group">
										<label>Name: </label>
										<div class="input-group input-group-md">
											<span class="input-group-addon"><i class=" icon-profile3"></i></span>
											<input style="height: 36px;" name="name" type="text" class="form-control" value='<?php echo $userlist['name']?>'>
											<input type="hidden" placeholder="Email"  name="email" class="form-control" value='<?php echo $userlist['email']?>'>
										</div>
										</div>
										
										<div class="form-group">
										<label>Phone: </label>
										<div class="input-group input-group-md">
											<span class="input-group-addon"><i class="icon-phone2"></i></span>
											<input style="height: 36px;" name="phone" type="text" class="form-control" value='<?php echo $userlist['phone']?>'>
										</div>
										</div>
										
										<div class="form-group">
										<label>Employee Code: </label>
										<div class="input-group input-group-md">
											<span class="input-group-addon"><i class="icon-qr-code"></i></span>
											<input style="height: 36px;" name="address" type="text" class="form-control" value='<?php echo $userlist['address']?>'>
										</div>
										</div>
										<button type="submit" class="btn btn-primary ui-wizard-content float-right marg_b_40" id="add-step"><i class="icon-paperplane"></i> Update Profile</button>
										</form>
										</div>
									</div>
								</div>
							</div>

							<div class="card card-inverse">
								<div class="card-header">
									<div class="card-title">
										<a data-toggle="collapse" data-parent="#accordion-control-right" class="collapsed" href="#accordion-control-right-group2">Change Password</a>
									</div>
								</div>
								<div id="accordion-control-right-group2" class="card-collapse collapse">
									<div class="card-block">
										<div class="col-md-8" style="margin: 0px auto;">
										 <form  role="form" id="chng_forget_pwd"  method='post'>
										<div class="form-group">
										<label>Old Password: </label>
										<div class="input-group input-group-md">
											<span class="input-group-addon"><i class="icon-qr-code"></i></span>
											<input style="height: 36px;"  class="form-control" type="password" placeholder=" Old Password"   name="oldpassword" required>
										</div>
										</div>
										
										<div class="form-group">
										<label>New Password: </label>
										<div class="input-group input-group-md">
											<span class="input-group-addon"><i class="icon-qr-code"></i></span>
											<input style="height: 36px;"  class="form-control" id='pwd' type="password" placeholder="New Password"  name="password" required>
										</div>
										</div>
										
										<div class="form-group">
										<label>Confirm New Password: </label>
										<div class="input-group input-group-md">
											<span class="input-group-addon"><i class="icon-qr-code"></i></span>
											<input style="height: 36px;"  class="form-control" id="confirm" type="password" placeholder="Confirm New Password"  name="confirm" required>
										</div>
										</div>
										<button type="submit" class="btn btn-primary ui-wizard-content float-right marg_b_40"><i class="icon-paperplane"></i> Update Password</button>
										</form>
										</div>
									</div>
								</div>
							</div>


						</div>
					
						
					</div>
				 </div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?> 
			<!-- /Footer -->
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
