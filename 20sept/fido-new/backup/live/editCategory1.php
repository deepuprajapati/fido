<?php include('include/header-files.php'); ?>


<!-- write your custom css and js here -->
<script src="js/Countries_States.js"></script>
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
$user =new User();
$userlist= $user->all();

 $category = new Category();
if(isset($_GET['catId']))
{
	$catId=$_GET['catId'];
	$catlist=$category->findCustomRow(array('id'=>$catId));
}

 //  $allLanguages = $language->getColumns();
if(isset($_POST['name'])){
//echo '<pre>';
//print_r($_POST);
$result= $category->findcustomrow(array('name'=>$_POST['name']));

if(empty($result) || $result['name'] ==$_POST['name'] )
{

	$category->id=$catId;
	 $category->name	 = $_POST['name'];
		$category->cateogry_head	 = $_POST['head'];


	$category->created_at=date('Y-m-d H:i:s');
	$_SESSION['msg'] = "Category has been saved successfully";
	$category->save();
	redirectAdmin('category.php');


}
else
{
$_SESSION['msg'] = "This name id already EXists";
	redirectAdmin('editCategory.php');
}
}

	//_d($allLanguages);
	?>
	
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Edit Category</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
				 <div class="min_hght_440"><!-- min height 440 -->
                <div class="card card-inverse card-flat p-10 p-t-20 CrdTop_brdr">
                    <div class="card-block p-b-50 p-0">
                       <form role="form"  method='post'>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Name</label>
										<input type="text" placeholder=" Name" data-parsley-required="true" data-parsley-trigger="change" value='<?php echo $catlist['name'] ?>'  name="name" class="form-control inptFld_sz" required>
									</div>
								</div><!-- done 1-->

								
                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group both" id='partner'>
										<label>Category Head</label>
										<select  name='head' class="form-control inptFld_sz" required>
										<option value='0' >Select Category Head Office</option>
											<?php foreach($userlist as $key=>$value){ ?>
											<option value='<?php echo $value['id'] ?>' <?php if($value['id']==$catlist['cateogry_head']) echo 'selected' ; ?>><?php echo $value['name'] ?></option>
											<?php } ?>
										</select>
									</div>
                                </div><!-- done 2-->

                             
                            </div>


							<button class="btn btn-primary ui-wizard-content float-right marg_t_30" >Update Category</button>
							</form>
						
					</div>
				</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
<?php include('include/footer-new.php'); ?>  
