<?php include('include/header-files.php'); ?>

<!-- write your custom css and js here -->

<style>
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

.drpDwn_rprt{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0px 10px;
}


.ttlWth_icn{
width: 100%;
}

.ttlWth_icn i.icnDrp_lft{
    top: 0 !important;
    position: static;
    font-size: 14px;
    vertical-align: middle;
    margin-right: 4px;
}


.ttlWth_icn a.rprt_ttl{
    font-size: 13px;
}

.rightApp_btn{
    width: 55px;
    text-align: center;
    display: flex;
}


/*
.pageLinsk_top{
    padding: 0px 24px;
    margin-bottom: 20px;
    display: flex;
}

.pageLinsk_top a{
    font-size: 11px;
}

.pageLinsk_top i{
    font-size: 11px;
}
*/

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
   $partner  = new Partner();
   $allpartner = $partner->all();
    $Publisher  = new Publisher();
	$allPublisher = $Publisher->all();
 $commisonSection=new PartnerCommisionSection();

  $info = new customer_contact_info();
   if(isset($_GET['delete'])){
	   $partner->delete($_GET['id']);
			$_SESSION['msg'] = "Partner has been deleted successfully";
			redirectAdmin('managePartner.php');

   }
   if(isset($_GET['block']) && isset($_GET['partner'])){
		if($partner->blockUser(array('id'=>$_GET['id']),0)){
			$_SESSION['msg'] = "Partner has been blocked successfully";
			redirectAdmin('managePartner.php');
		}
   }
   if(isset($_GET['unblock']) && isset($_GET['partner'])){
		if($partner->blockUser(array('id'=>$_GET['id']),1)){
			$_SESSION['msg'] = "Partner has been unblock successfully";
			redirectAdmin('managePartner.php');
		}
   }
    if(isset($_GET['block']) && isset($_GET['publisher'])){
		if($Publisher->blockUser(array('id'=>$_GET['id']),0)){
			$_SESSION['msg'] = "Publisher has been blocked successfully";
			redirectAdmin('managePartner.php');
		}
   }
   if(isset($_GET['unblock']) && isset($_GET['publisher'])){
		if($Publisher->blockUser(array('id'=>$_GET['id']),1)){
			$_SESSION['msg'] = "Publisher has been unblocked successfully";
			redirectAdmin('managePartner.php');
		}
   }


	?>
	
        <!-- Page container begins -->
       <section class="main-container">
    <div class="header headerCntnt_wrapr moreMenu_flxNone">
      <div class="heading_top">
        <div class="page-title">Customer Management</div>
      </div>
     <!--<div class="links"><a href="addProject.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>  CREATE ESTIMATE REQUISITION</a></div>-->
	<div class="pageTgle" id="openLnks"><i class="icon-menu7 navIcon_size"></i></div>
		<div class="links linksMore" id="slideLinks">
			<a href="addPartner.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b>add customer</a>
			<a href="<?php echo $config['SITE_URL']."include/ClientMaster.xlsx "; ?>" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-pencil6 icn_sz_15"></i></b>form for client</a>
			<a href="add-gst.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>upadte gst</a>
			<a href="userAssign.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-user-check icn_sz_16"></i></b>user assign</a>
		</div>
    </div>


            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn" id="myHeader">
                        <table class="table datatable table-bordered dataTable_cstm datatable-header-basic fixTlb_hdr_minwidht">
            <thead>
                                <tr>

                  <th>S.No.
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Company Name
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Official Address
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Country
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
					<th class="no_Sort">Action</th>
                  </tr>
                            </thead>
                                <tbody class="content">
										<?php $i=1; foreach($allpartner as $k=>$value){ ?>
                                        <tr>
											<td class="txt_cntr" style="width:70px;"><?php echo $i; ?></td>
											<td>
											<?php echo $value['partner_name']; ?>
											</td>
											<td>
											<?php echo $value['official_address']; ?>
											</td>
											<td>
											<?php $pro_dis = $info->findCustom(array('client_id'=>$value['id']));
											$cond = "partner_id = '".$value['id']."' and service_id = 2";
											$client_comm = $commisonSection->findWhere($cond);
											echo $value['country'];
											?>
											</td>
											<td class="txt_cntr">
												<ul class="icons-list" style="text-align: center;">
													<li class="dropdown">
													<button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="true"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
													<ul class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;">
													
													<a class="dropdown-item" onclick="return confirm('Delete <?php echo $value['partner_name']; ?> ?');" href="<?php echo $config['SITE_URL']."managePartner.php?delete=1&id=".$value['id'];?>">Delete</a>
													
													<a class="dropdown-item" href="<?php echo $config['SITE_URL']."editpartner.php?id=".$value['id'];?>">Edit</a>
													
													<?php if($value['status']==1){
													?> <a class="dropdown-item" href="<?php echo $config['SITE_URL']."managePartner.php?partner=1&block=0&id=".$value['id'];?>">Block</a>
													<?php	} else { ?> 
													<a class="dropdown-item" href="<?php echo $config['SITE_URL']."managePartner.php?partner=1&unblock=0&id=".$value['id'];?>">Unblock</a>
													<?php  } ?>
													
													<a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#change_contact" onclick='f1(<?php echo json_encode($pro_dis); ?>)' >Edit Contact Person</a>
													
													<a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#change_commision" onclick='f2(<?php echo json_encode($client_comm); ?>)' >Edit Commision</a>
													
													
													</ul>
													</li>
												</ul>
											</td>
                                        </tr>
                                        <?php $i++;
										}

										?>
                                </tbody>
                        </table>
                    </div>
                </div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
   
  <script>
    /* Start datatable js code for table and header fixed */
    
    $(function() {
      'use strict';

      $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
          search: '_INPUT_',
          lengthMenu: '<span>Show:</span> _MENU_',
          paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        lengthMenu: [ 20, 50, 75, 100 ],
        displayLength: 50,
        "bLengthChange": false
      });
      
      $('.datatable-header-basic thead th').on("click.DT", function (e) {
        if (!$(e.target).hasClass('sortMask')) {
          e.stopImmediatePropagation();
        }
      });
	  
	  var tblHead_fix = true;
	  var wdnsWdth = $(window).width();
	  
		if(wdnsWdth <= 1080 ){
			var tblHead_fix = false;
			$('.table-responsive').removeClass('tblRspnv_actionbtn');
		}else{
			var tblHead_fix = true;
			$('.table-responsive').addClass('tblRspnv_actionbtn');
		}
	  
	$(window).resize(function(){
	var wdnsWdth = $(window).width();	
		//alert(wdnsWdth);
		if(wdnsWdth <= 1080 ){
			var tblHead_fix = false;
			$('.table-responsive').removeClass('tblRspnv_actionbtn');
		}else{
			var tblHead_fix = true;
			$('.table-responsive').addClass('tblRspnv_actionbtn');
		}
		
	});

      // Basic initialization
      var table_basic = $('.datatable-header-basic').DataTable({
        fixedHeader: tblHead_fix,
        buttons: {
          dom: {
            button: {
              className: 'btn btn-secondary'
            }
          },
          buttons: [
            {
              extend: 'colvis',
              text: '<i class="icon-table2"></i> <span class="caret"></span>',
              className: 'btn btn-secondary',
              collectionLayout: 'fixed'
            },
            {extend: 'copy', className: 'copyButton' },
            {extend: 'csv', className: 'csvButton' },
            {extend: 'excel', className: 'excelButton' },
            {extend: 'print', className: 'printButton' }
          ]
        }
      });
      
      
      // Individual column searching with text inputs
      $('.datatable-header-basic th .src_inpt').each(function () {
        $(this).html('<input type="text" class="form-control" placeholder="Search" />');
      });
      table_basic.columns().every( function () {
        var that = this;
        $( 'input', this.header() ).on( 'keyup change', function () {
          if ( that.search() !== this.value ) {
            that
              .search( this.value )
              .draw();
          }
        } );
      });
      

      
      
      

      // Add placeholder to the datatable filter option
      $('.dataTables_filter input[type=search]').attr('placeholder','Type to search...');
      $('.dataTables_filter input[type=search]').attr('class', 'form-control');

      // Enable Select2 select for the length option
      /*$('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
      });*/
    });
    
    
    /* End datatable js code for table and header fixed */
  </script>
  
  
    <script>
		$(document).ready(function(){
			
			$('#openLnks').click(function(){
				$('#slideLinks').slideToggle();
			})
				
		});
    </script>
  <script>
function f1(data)
    {
        $html='<thead> <th>S.No.</th><th style="width: 23%;">Name</th><th>Email Id</th><th style="width: 17%;">Phone No</th><th style="width: 10%;">Save</th><th style="width: 10%;">Delete</th></thead><tbody>';
        for(i=0;i<data.length; i++)
            {
                if(i==0){
                $html+='<input type="hidden" class="clientId" value="'+data[i].client_id+'">';
                }
                $html+='<tr role="row">';
                $html+='<td><input type="hidden" class="rowId" value="'+data[i].id+'">'+(i+1)+'</td>';
                $html+='<td><input type="text" class="form-control name" value="'+data[i].name+'"></td>';
                $html+='<td><input type="text" class="form-control email" value="'+data[i].email+'"></td>';
                $html+='<td><input type="text" class="form-control phone" value="'+data[i].designation+'"></td>';
				$html+='<td class="txt_cntr"><a href="javascript:;" class="edit" style="color:#8ac90e"><i class="icon-checkmark3"></i></a></td>';
                $html+='<td class="txt_cntr"><a href="javascript:;" class="delete"><i style="color:#FF8F9D" class="icon-trash"></i></a></td>';
                $html+='</tr>';
                
            } 
          $html+='</tbody>';
         $('.bootstraptablebody').html($html);
    }
    function f2(data)
    {
        $html='<thead> <th>S.No.</th><th>Commision</th><th style="width: 10%;">Save</th><th style="width: 10%;">Delete</th></thead><tbody>';
        for(i=0;i<data.length; i++)
            {
                if(i==0){
                $html+='<input type="hidden" class="clientId" value="'+data[i].	partner_id+'">';
                }
                $html+='<tr role="row">';
                $html+='<td><input type="hidden" class="rowId" value="'+data[i].id+'">'+(i+1)+'</td>';
                $html+='<td><input type="text" class="form-control comm" value="'+data[i].commision+'"></td>';   
                $html+='<td class="txt_cntr"><a href="javascript:;" class="edit" style="color:#8ac90e"><i class="icon-checkmark3"></i></a></td>';
                $html+='<td class="txt_cntr"><a href="javascript:;" class="delete"><i style="color:#FF8F9D" class="icon-trash"></i></a></td>';
                $html+='</tr>';
                
            } 
          $html+='</tbody>';
         $('.bootstraptablebodyforcommison').html($html);
         
    }
</script>

<!--<div class="modal fade" id="change_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div style="width:950px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cotact Person Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="toolbar"><a id="new" href="javascript:;" class="btn btn-primary mb15 ml15">Add New Cotact Person</a></div>
                    </div>
                </div>
                <table class="bootstraptablebody display table table-bordered table-striped mg-t datatable editable-datatable"></table><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
        </div>
    </div>
</div>-->

<div class="modal fade" id="change_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;max-width:950px;" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Contact Person Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="estimate.php" enctype="multipart/form-data">
      <div class="modal-body">
		<button id="new" type="button" class="btn btn-info marg_b_10" >Add New Cotact Person</button>	
		<table class="bootstraptablebody table table-bordered table-striped datatable"></table>

     </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
      </div>
    </div>
  </div>
  
  
  
  
  
	
    <script>
    $('#new').on('click', function() {
    $('.bootstraptablebody').find('tbody').append('<tr role="row"><td>'+(i+1)+'</td><td><input class="form-control name" value=""><td><input class="form-control email" value=""><td><input class="form-control phone" value="" ><td class="txt_cntr"><a href="javascript:;" class="edit"><i class="icon-upload"></i></a></td><td class="txt_cntr"><a href="javascript:;" class="delete"><i style="color:#FF8F9D" class="icon-trash"></i></a></td>');
        i++;
    return false; //prevent form submission
});

$('.bootstraptablebody').on('click', '.delete', function() {
    if (!confirm('Are you sure? ')) return false;
    $(this).parents("tr").remove();
    i--;
    var personId = $(this).parents("tr").find(".rowId").val();
    //console.log(personId);
    $.ajax
        ({
            url: 'ajax.php?action=client_contact_person_delete',
            data: {
                id:personId
            },
            type: "POST",
            dataType: "json",
            cache: false, 
            success: function(result)
            {
              
            }
        });

    return false; 
});
$('.bootstraptablebody').on('click', '.edit', function() {
    var clientId = $(this).parents("table").find(".clientId").val();
    var rowId = $(this).parents("tr").find(".rowId").val();
    var name = $(this).parents("tr").find(".name").val();
    var email = $(this).parents("tr").find(".email").val();
    var phone = $(this).parents("tr").find(".phone").val();
    $.ajax
        ({
            url: 'ajax.php?action=change_est_contact_person',
            data: {
                id:rowId,
                name:name,
                email:email,
                phone:phone,
                clientidContact:clientId
            },
            type: "POST",
            dataType: "json",
            cache: false, 
            success: function(result)
            {
              
            }
        });
});
    </script>

<!--<div class="modal fade" id="change_commision" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div style="width:950px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Media Commison Information</h4> 
            </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="toolbar">
                                    <a id="newCommision" href="javascript:;" class="btn btn-primary mb15 ml15">Add New Commison</a>
                                </div>
                            </div>
                        </div>
                        <table  class="bootstraptablebodyforcommison display table table-bordered table-striped mg-t datatable editable-datatable" >
				  
				  
			             </table>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
        </div>
    </div>	
</div>	-->


<div class="modal fade" id="change_commision" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;max-width:950px;" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Media Commison Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="estimate.php" enctype="multipart/form-data">
      <div class="modal-body">
		<button id="newCommision" type="button" class="btn btn-info marg_b_10">Add New Commison</button>	
		<table  class="bootstraptablebodyforcommison table table-bordered table-striped datatable" ></table>

     </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
      </div>
    </div>
 </div>


    <script>
    $('#newCommision').on('click', function() {
    $('.bootstraptablebodyforcommison').find('tbody').append('<tr role="row"><td>'+(i+1)+'</td><td><input class="form-control comm" value=""><td class="txt_cntr"><a href="javascript:;" class="edit"><i class="icon-upload"></i></a></td><td class="txt_cntr"><a href="javascript:;" class="delete"><i style="color:#FF8F9D" class="icon-trash"></i></a></td></tr>');
        i++;
    return false; //prevent form submission
});

$('.bootstraptablebodyforcommison').on('click', '.delete', function() {
    if (!confirm('Are you sure? ')) return false;
    $(this).parents("tr").remove();
    i--;
    return false; 
});
$('.bootstraptablebodyforcommison').on('click', '.edit', function() {
    var clientId = $(this).parents("table").find(".clientId").val();
    var rowId = $(this).parents("tr").find(".rowId").val();
    var comm = $(this).parents("tr").find(".comm").val();
    
    console.log(clientId);
    $.ajax
        ({
            url: 'ajax.php?action=change_client_commision',
            data: {
                id:rowId,
                newComm:comm,
                clientidContact:clientId
            },
            type: "POST",
            dataType: "json",
            cache: false, 
            success: function(result)
            {
              
            }
        });
});
    </script>
