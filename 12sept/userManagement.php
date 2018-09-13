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
$userarray=array(1,6);
if(!in_array($_SESSION['admin_info']['type'], $userarray)){
	header('Location: logout.php');
}
   $admin  = new Admin();
   $allUsers = $admin->all();
   if(isset($_GET['approval'])){
	   $admin->id = $_GET['userId'];
	   $admin->approval_status = $_GET['approval'];
	   $admin->save();
		$_SESSION['msgsuccess'] = "Approval status has been updated successfully";
		redirectAdmin('userManagement.php');
   }
   if(isset($_GET['block'])){
		if($admin->blockUser(array('id'=>$_GET['userId']),0)){
			$_SESSION['msg'] = "User has been blocked successfully";
			redirectAdmin('userManagement.php');
		}
   }
   if(isset($_GET['delete'])){
	   $admin->delete($_GET['userId']);
			$_SESSION['msg'] = "User has been deleted successfully";
			redirectAdmin('userManagement.php');

   }
   if(isset($_GET['unblock'])){
		if($admin->blockUser(array('id'=>$_GET['userId']),1)){
			$_SESSION['msg'] = "User has been unblocked successfully";
			redirectAdmin('userManagement.php');
		}
   }
// Instantiate the user class

	//_d($allSettings);
	?>
        <!-- Page container begins -->
       <section class="main-container">
    <div class="header headerCntnt_wrapr moreMenu_flxNone">
      <div class="heading_top">
        <div class="page-title">Users Management</div>
      </div>
		
		<div class="pageTgle" id="openLnks"><i class="icon-menu7 navIcon_size"></i></div>
		<div class="links linksMore" id="slideLinks">
			<a href="userAssign.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>add user assign</a>
			<a href="user-group.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>add user permission</a>
			<a href="group-list.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>add user permission groups</a>
			<a href="user-arrage.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>add user hierchy</a>
			<a href="addUser.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>add user</a>
		</div>
    
	</div>

            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn" id="myHeader">
                        <table class="table datatable table-bordered dataTable_cstm datatable-header-basic fixTlb_hdr_minwidht">
            <thead>
                                <tr>

                  <th>Name
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Email
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Employee Code
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Phone
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Role
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
					<th class="no_Sort">Action</th>
                  </tr>
                            </thead>
                                <tbody class="content">
                                    <?php foreach($allUsers as $k=>$userData){
										if($userData['type']!=1){
										if($userData['type']==2) $type='Brand Solution Team';
                                        elseif($userData['type']==3) $type='Tech Team';
                                        elseif($userData['type']==15) $type='Business Head';
                                        elseif($userData['type']==16) $type='Business Development';
										elseif($userData['type']==17) $type='Inbound Team';
										elseif($userData['type']==11) $type='Seo Team';
										elseif($userData['type']==12) $type='Sem Team';
										elseif($userData['type']==13) $type='Social Team';
                                        elseif($userData['type']==14) $type='Head BS Team';
										elseif($userData['type']==5) $type='Media Team';
										elseif($userData['type']==6) $type='Finance Team';
										elseif($userData['type']==7) $type='Client Media';
										elseif($userData['type']==8) $type='Client finance';
										elseif($userData['type']==9) $type='Publisher Media';
										elseif($userData['type']==10) $type='Publisher finance';
										elseif($userData['type']==4) $type='Digital PR';
										else $type= "guest";?>
                                        <tr>
                                            <td>
                                                <?php echo $userData['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $userData['email']; ?>
                                            </td>
                                            <td>
                                                <?php echo $userData['address']; ?>
                                            </td>
                                            <td>
                                                <?php echo $userData['phone']; ?>
                                            </td>
                                            <td>
                                                <?php echo $type; ?>
                                            </td>
											<td class="txt_cntr">
												<ul class="icons-list" style="text-align: center;">
													<li class="dropdown">
													<button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="true"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
													<ul class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;">
													
													<a onclick="return confirm('Are you sure?');" href="<?php echo $config['SITE_URL']."userManagement.php?delete=1&userId=".$userData['id'];?>" class="dropdown-item">Delete</a></a>
													
													<a href="<?php echo $config['SITE_URL']."editUser.php?userId=".$userData['id'];?>" class="dropdown-item">Edit</a>
													
													<?php if($userData['status']==0){
													?> <a class="dropdown-item" href="<?php echo $config['SITE_URL']."userManagement.php?unblock=0&userId=".$userData['id'];?>">UnBlock</a>
													<?php
													}
													else
													{
													?> <a class="dropdown-item" href="<?php echo $config['SITE_URL']."userManagement.php?block=0&userId=".$userData['id'];?>">Block</a>
													<?php  									}
													?>
													</ul>
													</li>
												</ul>
											</td>
                                        </tr>
                                        <?php
										}
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
$('html, body,.main-content').on('scroll',function() {
    console.log('Log this');
 });
</script> 
<script>
$('html, body,.main-content').scroll(function() {
    didScroll = true;
    console.log("Calling this function");
});
</script>
<script>


var header = document.getElementById("myHeader");
var sticky = header.offsetTop;
    
function myFunction() {
  console.log("Calling this function");
}
    $(document).ready(function(){
  var elementOffset = $('#myHeader').offset().top;
});
</script> 