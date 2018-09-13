<?php include('include/header-files.php'); ?>

<!-- write your custom css and js here -->
<script>
	$(document).ready(function(){
		$('input[type="checkbox"]').on('change', function() {
			$('input[type="checkbox"]').not(this).prop('checked', false);
			$('input[type="checkbox"]').not(this).prop('required', false);
		});
	});
</script>

<!-- write your custom css and js here -->
<!-- Header begins -->
<?php include('include/header-new.php'); ?>

<?php
$fileBasePath = dirname(__FILE__).'/';
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/

$partner_code = new Publisher_code(); // Partner_code object
$col="numeric1";
$code=$partner_code->max($col);
$code=$code+1;

   $partner = new blogger();
 //  $allLanguages = $language->getColumns();
   if(isset($_POST['company_name'])){
	   $result= $partner->findcustomrow(array('publisher_name'=>trim($_POST['company_name'])));
	    if(empty($result)){

			$partner_code->numeric1=$code;
		   $partner_code->ref=$_POST['company_code'];
		   $partner_code->create();

		   $partner->publisher_name	 = trim($_POST['company_name']);
		   $partner->official_address	= trim($_POST['company_address']);
		   $partner->official_phone	 = trim($_POST['company_phone']);
		   $partner->official_email	 = trim($_POST['company_email']);
		   $partner->contact_person	 = trim($_POST['contact_person']);
		   $partner->Parent_name	 = $_POST['Parent_name'];
		   $partner->website_address	= trim($_POST['website_address']);
		   $partner->pan	 = trim($_POST['pan']);
		   $partner->service_tax	 = trim($_POST['stax']);

		   $partner->district	 = trim($_POST['company_district']);
		   $partner->state	= trim($_POST['company_state']);
		   $partner->country	 = trim($_POST['company_country']);
		   $partner->postal_code	 = trim($_POST['company_pincode']);
		   $partner->isIndian	 = (($_POST['company_country']=="India")?1:0);
		   $partner->company_code	 = trim($_POST['company_code']);
		   //$partner->company_type	= trim($_POST['comptype']);
		   $partner->company_cat	= trim($_POST['company_category']);
		   $dat = date("Y-m-d H:i:s");
		   $partner->created_at =  $dat;
		   $partner->create();
		   $_SESSION['msg'] = "blogger has been added successfully";
			redirectAdmin('manageBlogger.php');
		}
$_SESSION['msg'] = "blogger has been added already please check";
}


	//_d($allLanguages);
	?>

	
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Blogger Management</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="card card-inverse card-flat p-10 p-t-20 CrdTop_brdr">
                    <div class="card-block p-b-50 p-0">
                       <form role="form"  method='post' >
                            <div class="row">
                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Blogger Name</label>
										<input type="text" placeholder=" Name"  onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)"  name="company_name" class="form-control inptFld_sz"
											id="name"  onblur="edValueKeyPress()" required>	
									</div>
								</div><!-- done 1-->

								
                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Parent Company Name</label>
										<input type="text" placeholder=""     name="Parent_name" class="form-control inptFld_sz" required>
									</div>
                                </div><!-- done 2-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>Blogger Code</label>
										<input type="text" placeholder="" name="company_code" class="form-control inptFld_sz" id="company_code" required>
									</div>
                                </div><!-- done 3-->


                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										 <label>Blogger Email</label>
										  <input type="email" required placeholder="" name="company_email" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 4-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										 <label>Contact Person</label>
											<input type="text" placeholder="" name="contact_person" class="form-control inptFld_sz" required>
									</div>
                                </div><!-- done 5-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										 <label>Website address</label>
											<input type="text" required placeholder="" name="website_address" class="form-control inptFld_sz">
									</div>
                                </div><!-- done 6-->


                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										 <label>Blogger Category</label>
									   <select name='company_category' class='form-control inptFld_sz' required>
											<option value=''>Select Category</option>
											<option value='pvtltdcompany'>Pvt. LTD. Company</option>
											<option value='ltdcompany'>LTD. Company</option>
											 <option value='partnership'>Partnership</option>
											<option value='proprietorship'>Proprietorship</option>
											<option value='individual'>Individual</option>
									   </select>
									</div>
                                </div><!-- done 7-->


                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>PAN Number</label>
										<input type="text" required placeholder=""   name="pan" class="form-control inptFld_sz" id="pan" onblur="pan_card(this.value)" >
									</div>
                                </div><!-- done 8-->


                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Blogger Phone</label>
										<input type="text" placeholder=" Ex:- 9988776655"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"   name="company_phone" class="form-control inptFld_sz" required maxlength="10">
									</div>
                                </div><!-- done 9-->

                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										  <label>Country</label>
											<select  placeholder="" name="company_country" class="form-control inptFld_sz" id="country" required ></select>
									</div>
                                </div><!-- done 10-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>GST No.</label>
										<input type="text" required placeholder="" name="stax" class="form-control inptFld_sz">
									</div>
                                </div><!-- done 11-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>State</label>
										<select placeholder="" name="company_state" class="form-control inptFld_sz" id="state" required></select>
									</div>
                                </div><!-- done 12-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>Blogger Address</label>
										 <input type="text" required placeholder=""    name="company_address" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 13-->

                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>City </label>
										<input type="text" placeholder="District" name="company_district" class="form-control inptFld_sz" required>
									</div>
                                </div><!-- done 14-->


                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Pin code</label>
										 <input type="text" placeholder="" name="company_pincode" class="form-control inptFld_sz" required >
									</div>
                                </div><!-- done 15-->



                              
                            </div>


							<button type="submit" class="btn btn-primary ui-wizard-content float-right m-t-20" ><i class="icon-paperplane"></i> Submit</button>
							</form>
						
					</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
	 <script src="asset/js/Countries_States.js"></script>
<script>
function STN(a)
{
var pan = document.getElementById("pan").value;
//alert(pan);
//alert(a);
var res = a.substring(0, 10);
//alert(res);
if(a.length==15 && a!='')
{
		if( pan === res )
		{
		var val = a.replace(res,'').substring(0,2);
		//alert(val);
		//var b = val.substring(0,2);
				if(val=='ST' || val=='SD')
				{
					var endWord = a.substring(12,15);
					//alert(endWord);
					if(!isNaN(endWord)) alert("Vaild Service Tax Number No.");
				}
				else{
					alert('Invaild Service Tax Number No.');
				}

		}else{
		alert("Invaild Service Tax Number  No.");
		}
}
else{
	alert("Invaild Service Tax Number  No.");
}

}

</script>
<script>
/* This function validates for PAN Card No.*/
function pan_card(textObj)
{
//alert(textObj);
var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
/*C - Company
P - Person
H - HUF(Hindu Undivided Family)
F - Firm
A - Association of Persons (AOP)
T - AOP (Trust)
B - Body of Individuals (BOI)
L - Local Authority
J - Artificial Juridical Person
G - Govt.*/
var code= /([C,P,H,F,A,T,B,L,J,G])/;
var code_chk=textObj.substring(3,4);
if (textObj!=="")
{
if(regpan.test(textObj) == false)
{
alert("Invaild PAN Card No.")
return false;
}
if (code.test(code_chk)==false)
{
alert("Invaild PAN Card No.");
return false;
}
}
}
</script>
 <script>
    function edValueKeyPress()
    {
        var edValue = document.getElementById("name");
		var v=edValue.value;
        var splitted=[];
splitted = v.split(" ");
var y=[];
var str;
for(var i=0; i<splitted.length; i++)
{
	y[i]=splitted[i].charAt(0);

}

var str =y.join("").toUpperCase();

        var lblValue = document.getElementById("company_code");
		var code = "PB_"+<?php echo $code; ?>+"_"+str
        lblValue.value = code;

        //var s = $("#edValue").val();
        //$("#lblValue").text(s);
    }
</script>
<script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
</script>