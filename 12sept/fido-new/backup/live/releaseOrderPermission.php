<?php include('include/header-files.php'); ?>


<!-- write your custom css and js here -->
<style>

.select2-hidden-accessible{
		position: initial !important;
}


.fa, .toggle_drpdown i{color: #909090;}

.icons-list>li:first-child {
    margin-left: 0;
}


.toggle_drpdown{
    background: none;
    padding: 0;
    line-height: initial;
}

.toggle_drpdown:hover , .toggle_drpdown:active, .toggle_drpdown:focus{
    background: none;
    box-shadow: none;
}

.tooltip_cstm{
    background: none;
    padding: 0;
    line-height: initial;
}

.tooltip_cstm:hover , .tooltip_cstm:active, .tooltip_cstm:focus{
    background: none;
    box-shadow: none;
}

.tooltip_cstm i{
    margin-top: 8px;
}

a.disabled:hover{
background: #ebeaf0;
    color: #9f9999;
}

.popImg_mdl_style object{
    width: 100%;
}

.dataTable_cstm tbody td {
font-size: 10px !important;}

.btn-xs{
	    font-size: 9px;
}


/** Start individual page css **/

.result{
	position: absolute;
	background:#212027;
	z-index: 1;
}


.result .show{
    color: #fff;
    border-bottom: 1px solid gainsboro;
    padding: 3px 7px 3px 7px;
    cursor: pointer;
}

.result .show:hover{
    background: #565090;	
}

.result .show strong{
   font-weight:normal !important;
}

/** End individual page css **/

</style>
<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>

<?php

$project = new Project();
$mdata = new mediadata();
if(isset($_GET['upadted']) && isset($_GET['rowId'])){
    $rowid = $_GET['rowId'];
	$ro_discription = new RO_discription();
	$cond = "media_id = ".$rowid;
	$result = $ro_discription->findWhere($cond);
	if(empty($result)){
	$ro_discription->media_id =  $rowid;
	$ro_discription->discription =  $_GET['upadted'];
	$ro_discription->create();
	}
	else{
	$ro_discription->id =  $result[0]['id'];
	$ro_discription->discription =  $_GET['upadted'];
	$ro_discription->save();
	}

}
$allproject = $mdata->getMediaCampaignPermission()
?>


    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Release Order Permission</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
				<div class="min_hght_440">
					<div class="card card-inverse card-flat p-10 CrdTop_brdr p-t-20">
						<div class="card-block p-0">
							
							<form action="phpexl.php" enctype="multipart/form-data" method="post">
							 <div class="row">
								<div class="col-md-8 col-sm-12" style="margin:0px auto !important">
								<div class="row marg_b_20">
									<div class="col-md-12 col-sm-12">
										<div class="form-group select_srch"><label>Select Campaign :</label>
											<select id="campaign" name='campaign' class="selectpicker form-group form-control select" required>
												<option value=''>Select</option>
												<?php foreach($allproject as $k=>$projectData){ ?>
												<option value='<?php echo $projectData['campaignId']; ?>'><?php $pname=$project->findCustomRow(array('id'=>$projectData['campaignId']));
												echo $pname['project_name']."--".$pname['W_O']; ?></option>
												<?php  }  ?>
											</select>
										</div>
									</div>
								</div>
								<button class="btn btn-primary ui-wizard-content float-right marg_t_20 m-t-15 m-b-30" ><i class="icon-paperplane"></i> Submit</button>
								</div>
								 </div>
							</form>
							
						</div>
							
					</div>
					
									<?php if(isset($_GET['campaign'])){
$uid = $_GET['campaign'];
$camplist = $mdata->allMedia($uid,$userinfo['id']);

 $val = $mdata->getMedia($uid);
$val['SUM(rate)'];
								?>

						<div class="card card-inverse card-flat p-10 p-b-30">
						<div class="card-header brdr-b p-b-15 p-l-0">
							<div class="card-title">Media Plan</div>
						</div>
						<div class="table-responsive"><!-- tblRspnv_actionbtn -->
							<table class="table table-bordered dataTable_cstm marg_b_20">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;">Site </th>
                                                    <th>Section </th>
                                                    <th>Adunit </th>
                                                    <th>Deal</th>
													<th style="width: 20px;">Database </th>
													<th>Adsize </th>
                                                    <th>Open </th>
													<th>Clicks </th>
                                                    <th>Leads </th>
													<th>Rate </th>
                                                    <th>Cost </th>
													<th>eCPL </th>
                                                    <th>Search Pub </th>
                                                    <td>update </td>
                                                    <th style="text-align: center;width: 138px;">Action</th>
                                                    <th>View RO</th>
                                                    <th>Update Discription</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											<?php foreach($camplist as $key=>$value){ ?>
                                                <tr>

                                                    <td>
                                                        <span class="pd-l-sm"></span><?php echo $value['site'] ?></td>
                                                    <td><?php echo $value['section'] ?></td>
                                                    <td class="txt_cntr"><?php echo $value['adunit'] ?></td>
													<td class="txt_cntr"><?php echo $value['deal'] ?></td>
                                                    <td class="txt_cntr"><?php echo $value['databaseMedia'] ?></td>
													<td class="txt_cntr"><?php echo $value['adsize'] ?></td>
                                                    <td class="txt_cntr"><?php echo $value['open'] ?></td>
													<td class="txt_cntr"><?php echo $value['click'] ?></td>
                                                    <td class="txt_cntr"><?php echo $value['leads'] ?></td>
													<td class="txt_cntr"><?php echo $value['rate'] ?></td>
                                                    <td class="txt_cntr"><?php echo $mdata->moneyFormat($value['cost']); ?></td>
													<td class="txt_cntr" ><?php echo $value['ecpl'] ?></td>
                                                    <td class="txt_cntr"><?= (empty($value['publisher'])? '<div class="form-group" id="'.$value['id'].'_form">

                                <div class="inputval">
                                    <input style="padding: 6px 3px 6px 4px;font-size: 11px;width: 110px;" type="text" class="search form-control"  placeholder="Search Publisher" value="" name="pubname">
                                </div>
                                <div class="result">
                                 </div>
                            </div>' : '<button type="button" value="" class="btn btn-success btn-xs p-b-2" style="cursor: default" >Done</button>') ?></td>
                            <td class="txt_cntr">
<?= (empty($value['publisher'])? '<button type="button" value="'.$value['id'].'" class="pubupdate btn btn-success btn-xs p-b-2">Done</button>' : '') ?>
                            </td>


                                                    <td class="txt_cntr">
													<div class="btn-group" data-toggle="buttons">
													<?php if($value['permission']==1)
									 {
									 //echo'<a style="margin-right: 1px;" href="javascript:;" class="btn btn-success btn-xs" target="_blank">R.O.</a>';
									 echo'<label style="margin-right: 1px;"><a class="btn btn-success btn-xs p-b-2" href="javascript:;" target="_blank">R.O.</a></label>';
									 }
									 else
									 {
								     //echo'<button style="margin-right: 1px;" type="button" value="'.$value['id'].'" class="btn btn-warning btn-xs allow"  target="_blank">Allow</button>';
								     echo'<label style="margin-right: 1px;"><button class="btn btn-warning btn-xs p-b-2 allow" style="background-color: #f0ad4e;border-color: #f0ad4e;" type="button" value="'.$value['id'].'">Allow</button></label>';
									 }

                                     if($value['permission']==2)
									 {
									 //echo'<button style="margin-right: 1px;" type="button" value="'.$value['id'].'" class="btn btn-danger btn-xs onhold"  target="_blank">Onhold</button>';
									 echo'<label style="margin-right: 1px;"><button class="btn btn-danger btn-xs p-b-2 onhold" style="background-color: #c9302c;border-color:#c9302c" type="button" value="'.$value['id'].'">Onhold</button></label>';
									 }
                                    else{
										//echo'<button style="margin-right: 1px;" type="button" value="'.$value['id'].'" class="btn btn-warning btn-xs onhold"  target="_blank">Onhold</button>';
										 echo'<label style="margin-right: 1px;"><button class="btn btn-warning btn-xs p-b-2 onhold" style="background-color: #f0ad4e;border-color: #f0ad4e;" type="button" value="'.$value['id'].'">Onhold</button></label>';
									}

                                  if($value['permission']==3)
									 {
									 //echo'<button  style="margin-right: 1px;"type="button" value="'.$value['id'].'" class="btn btn-danger btn-xs Block"  target="_blank">Block</button>';
									  echo'<label style="margin-right: 1px;"><button class="btn btn-danger btn-xs p-b-2 Block" style="background-color: #c9302c;border-color:#c9302c" type="button" value="'.$value['id'].'">Block</button></label>';
									 }
                                    else{
										//echo'<button style="margin-right: 1px;" type="button" value="'.$value['id'].'" class="btn btn-warning btn-xs Block"   target="_blank">Block</button>';
										echo'<label style="margin-right: 1px;"><button class="btn btn-warning btn-xs p-b-2 Block" style="background-color: #f0ad4e;border-color: #f0ad4e;" type="button" value="'.$value['id'].'">Block</button></label>';
									}
									 ?>
									
                                     </td>
                                <td class="txt_cntr">
									<a class="imgshow" href="publisherInvioce.php?id=<?php echo $value['id']?>" target="_blank" class="Block"><i class="fa fa-file-pdf-o icn_sz_20 tbl_txt_lnk"></i></a>
								</td>
                                <td class="txt_cntr"><button type="button" value="<?php echo $value['id']?>" data-toggle="modal" data-target=".bs-example-modal-sm" class="updatedes btn btn-success btn-xs p-b-2">Update</button></td>
                                                </tr>
												<?php } ?>
												<tr>
                                                    <td style="background: #e8e8e8; text-align:right" colspan="7" ><b>Total</b></td>
                                                    <td style="background: #e8e8e8;"><b><?php echo $val['SUM(click)']; ?></b></td>
                                                    <td style="background: #e8e8e8;"><b><?php echo $val['SUM(leads)']; ?></b></td>
													<td style="background: #e8e8e8;"><b><?php echo $val['SUM(rate)']; ?></b></td>
                                                    <td style="background: #e8e8e8;"><b><?php echo $mdata->moneyFormat($val['SUM(cost)']); ?></b></td>
													<td><b><?= ($val['SUM(leads)']!='' && $val['SUM(leads)']!=0 ? $val['SUM(cost)']/$val['SUM(leads)']:'');  ?></b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>	
						</div>
					</div>

								<?php  }   ?>
					
									
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
	 
	     <!--   <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  			<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Description</h4>
      </div>
      <div class="modal-body">
      <div class="form-group">
      <form class="" action="" method="GET">
        <textarea name="upadted" class="form-control" required rows="3"></textarea>
        </div>
        <input type="hidden" value="" name="rowId" id="rowId">
        <input type="hidden" value="" name="campaign" id="campaignid">
        <button type="submit" class="btn btn-default">Confirm Update</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
		</div>-->
		
	
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title">Update Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	   <form class="" action="" method="GET">
      <div class="modal-body">
		<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
			<div class="input-group">
			<textarea name="upadted" class="form-control" rows="5"></textarea>
			<input type="hidden" value="" name="rowId" id="rowId">
			<input type="hidden" value="" name="campaign" id="campaignid">
			</div>
			</div>
		</div>
		</div> 
      </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		 <button type="submit"  class="btn btn-primary">Confirm Update</button>
      </div>
		</form>
	  </div>
    </div>
  </div>	
		
<script type="text/javascript">
  $(document).ready(function(){

    var IMEI = $(".allow");
    IMEI.click(function(){
		var cls = $(this);
      var value = $(this).val();
	  var c = "publisherInvioce.php?id=" + value;
	  //alert(value);

      if(value !=='')
      {
    $.ajax({
    type: "POST",
    data: {status : value},
    cache: false,
    url: "roPermission.php",
    beforeSend: function(){
    },
    success: function(data)
    {
      //alert(data);
        if(data == 1)
        {
			//cls.closest('td').find('button:first').hide();
			cls.closest('td .btn-group').append('<label style="margin-right: 1px;"><a class="btn btn-success btn-xs p-b-2" href="javascript:;" target="_blank">R.O.</a></label>');
			cls.closest('td .btn-group').find('label:first').hide();
			cls.closest('td').find('a:first').attr("href", c);
			//cls.removeClass("btn-warning");
			//cls.addClass("btn-success");
        }
        else
        {
        alert("not done");
        }
    }
});
  }
});
  });
  /////////////////////////////////////////
  $(document).ready(function(){

    var hold = $(".onhold");
    hold.click(function(){
		var cls = $(this);
      var value = $(this).val();
	  //var c = "publisherInvioce.php?id=" + value;
	  //alert(value);

      if(value !=='')
      {
    $.ajax({
    type: "POST",
    data: {onhold : value},
    cache: false,
    url: "roPermission.php",
    beforeSend: function(){
    },
    success: function(data)
    {
      alert(data);
        if(data == 1)
        {

			cls.removeClass("btn-warning");
			cls.addClass("btn-danger");
        }
        else
        {
        alert("not done");
        }
    }
});
  }
});
  });
  /////////////////
  $(document).ready(function(){

    var Block = $(".Block");
    Block.click(function(){
		var cls = $(this);
      var value = $(this).val();
	  //var c = "publisherInvioce.php?id=" + value;
	  //alert(value);

      if(value !=='')
      {
    $.ajax({
    type: "POST",
    data: {block : value},
    cache: false,
    url: "roPermission.php",
    beforeSend: function(){
    },
    success: function(data)
    {
      alert(data);
        if(data == 1)
        {

			cls.removeClass("btn-warning");
			cls.addClass("btn-danger");
        }
        else
        {
        alert("not done");
        }
    }
});
  }
});
  });
  </script>


<script type="text/javascript">
$(function(){

$(".search").keyup(function()
{
var $this = $(this);
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: "search.php",
    data: dataString,
    cache: false,
    success: function(html)
    {
    $this.closest('div').next(".result").html(html).show();
    }
    });
}return false;
});

jQuery(".result").on("click",function(e){
    var _this = this;
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $(this).prev('.inputval').find("input[name='pubname']").val(decoded);
    //$('#searchid').val(decoded);
});
jQuery(document).on("click", function(e) {
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search")){
    jQuery(".result").fadeOut();
    }
});
$('#searchid').click(function(){
    jQuery(".result").fadeIn();
});
});
</script>

<script>
$(document).ready(function(){
    $(".pubupdate").click(function(){
        var _this = this;
        var clkvalue = _this.value;
        //alert(clkvalue);
        var inputpubvalue = $(_this).closest('td').prev('td').find("input[name='pubname']").val();
        //alert(inputpubvalue);
        var $this = $(this);
        var dataString = 'pvalue='+ inputpubvalue+'&mid=' +clkvalue;
        if(inputpubvalue!='')
        {
            $.ajax({
            type: "POST",
            url: "search.php",
            data: dataString,
            cache: false,
            success: function(data)
            {
            if(data ==1){
                alert("done");
                $this.closest('td').prev('td').find("input[name='pubname']").attr('disabled', 'disabled');
            }
            }

            });
        }
    });
});

$(document).ready(function(){

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

    $(".updatedes").click(function(){
    var camp = getUrlParameter('campaign');
        var disid = $(this).attr("value");
        console.log(camp);
        $('#rowId').val(disid);
        $('#campaignid').val(camp);

    });
});

</script>
