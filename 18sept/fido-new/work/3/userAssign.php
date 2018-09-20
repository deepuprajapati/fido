<?php include('include/header-files.php'); ?>


<!-- write your custom css and js here -->
<style>

.addRmv_btn{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    flex-direction: column;
}

.addRmv_btn button{
    width: 120px;
    margin: 5px;
}

.cstmSlct_style{
	height:280px !important;
	font-size:13px;
}

select option, select[multiple] option{
padding: 5px 12px !important;}

</style>
<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>
<?php
$fileBasePath = dirname(__FILE__).'/';
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/
$userarray=array(1,6,14);
if(!in_array($userinfo['type'], $userarray)){
	header('Location: logout.php');
}
  $company=new Partner();
  $clientlist=$company->getPartners();
  $user = new User();
  $query="SELECT * FROM users WHERE partnerid=0 and type=2 and status=1 order by name asc";
  $alluser = $user->customQuery($query);


// Instantiate the user class

	//_d($allSettings);
	?>
	
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Users Management</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
				<div class="min_hght_440">
					<div class="card card-inverse card-flat p-10 CrdTop_brdr">
						<div class="card-block p-b-50 p-0">
							<form name="Example" method="post">
								<div class="row">
									<div class="col-lg-5 col-md-5 col-sm-12 marg_b_20">
										<div class="form-group">
											<label>Select</label>
											<select name ="user" class="inptFld_sz form-control" id="user">
												<option value="">Select User</option>
												<?php foreach($alluser as $key=>$value){ ?>
												<option value='<?php echo $value['id'] ?>' ><?php echo $value['name'] ;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
                                </div>
                                <div class="row">
									<div class="col-lg-5 col-md-5 col-sm-12 marg_b_20">
										<div class="form-group">
											<label>Select</label>
											
											<select name="Features" multiple="multiple" class="form-control cstmSlct_style" >
												<?php foreach($clientlist as $key=>$value){ ?>
												<option value='<?php echo $value['id'] ?>' ><?php echo $value['partner_inhouse_name'] ;?></option>
												<?php } ?>
											</select>
											
										</div>
									</div>
									
									<div class="col-lg-2 col-md-2 addRmv_btn">
										
											<button type="Button" class="btn btn-primary" onClick="SelectMoveRows(document.Example.Features,document.Example.FeatureCodes,1)">Add <i class="addIcon icon-arrow-right32"></i></button>
											<button type="button" class="btn btn-primary" onClick="SelectMoveRows(document.Example.FeatureCodes,document.Example.Features,0)"><i class="remIcon icon-arrow-left32"></i> Remove</button>
										
									</div>
									
									<div class="col-lg-5 col-md-5">
										<div class="form-group">
											<label>Assigned</label>
											<select name="FeatureCodes" size="9" MULTIPLE class="form-control cstmSlct_style" id="FeatureCodes">

											</select>
										</div>
									</div>
									
								</div> <button type="Button" class="btn btn-primary  float-right marg_t_30" name="submit" id="submit"><i class="icon-paperplane"></i> Submit </button></form>
								

<ul id="showclient"></ul>

						</div>
					</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
<script>


	
function chgIcon(){
	var width = $(window).width();
	if(width < 768){
		$('.addIcon').addClass('icon-arrow-down32').removeClass('icon-arrow-right32');
		$('.remIcon').addClass('icon-arrow-up32').removeClass('icon-arrow-left32');
	}else{
		$('.addIcon').addClass('icon-arrow-right32').removeClass('icon-arrow-down32');
		$('.remIcon').addClass('icon-arrow-left32').removeClass('icon-arrow-up32');
	}
	//console.log(width);
}

chgIcon();

$(window).resize(function(){	
	chgIcon();	
})

</script>	 
	 
	<script language="Javascript">
function SelectMoveRows(SS1,SS2,x)
{
    var SelID='';
    var SelText='';
    // Move rows from SS1 to SS2 from bottom to top
    for (i=SS1.options.length - 1; i>=0; i--)
    {
        if (SS1.options[i].selected == true)
        {
            SelID=SS1.options[i].value;
            SelText=SS1.options[i].text;
            if(x == 1){
            var newRow = new Option(SelText,SelID);
            SS2.options[SS2.length]=newRow;
            }
            if(x == 0){
                SS1.options[i]=null;
            }
            
        }
    }
    SelectSort(SS2);
}
function SelectSort(SelList)
{
    var ID='';
    var Text='';
    for (x=0; x < SelList.length - 1; x++)
    {
        for (y=x + 1; y < SelList.length; y++)
        {
            if (SelList[x].text > SelList[y].text)
            {
                // Swap rows
                ID=SelList[x].value;
                Text=SelList[x].text;
                SelList[x].value=SelList[y].value;
                SelList[x].text=SelList[y].text;
                SelList[y].value=ID;
                SelList[y].text=Text;
            }
        }
    }
}
$(document).ready(function (){
	 $("#submit").click(function(evt){
    var user = $('#user option:selected').val();

	var val= new Array();
        if(user!=''){
            $("#FeatureCodes option").each(function()
            {
                val.push($(this).val());
            });
            if(val.length == 0)
            {
                alert("Please select client.");
            }else{
                $.ajax({
                        cache: false,
                        type: "POST", 
                        url: "ajax.php",
                        data: {'userforclients':user,'client':val},
                        success: function(msg)
                        {
                            alert("Done");
                        }
                });
            }
        }
        else{
                alert("Please select user.");
            }

     });
});
        
$(document).ready(function (){
    $("#user").change(function (){
       var end = this.value;
        if(end!=''){
        $("#FeatureCodes").empty();
	       $.ajax({
				cache: false,
				type: "POST",
				url: "ajax.php",
				data: {'checkuser':end},
				success: function(msg)
                {
                    //alert(msg);
                    $("#FeatureCodes").append(msg);
                }
	       });
        }
        else{
            $('#userForClient').focus();
            $('.alert-warning').show();
        }
    });
});
</script>
