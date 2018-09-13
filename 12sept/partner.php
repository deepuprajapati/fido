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
		<div class="header headerCntnt_wrapr">
			<div class="heading_top">
				<div class="page-title">Publisher Management</div>
			</div>
			<div class="pageTgle" id="openLnks"><i class="icon-menu7 navIcon_size"></i></div>
			<div id="slideLinks" class="links"><a href="addPublisher.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>CREATE PUBLISHER</a></div>
		</div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn">
                        <table class="table datatable table-bordered dataTable_cstm datatable-header-basic fixTlb_hdr_minwidht">
						<thead>
                                <tr>
									
									<th>Publisher Name
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Official Address
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Official Email
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Official Phone
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th class="no_Sort">Action</th>
								</tr>
                            </thead>
							<tbody>
							<?php
							
							 foreach($allPublisher as $k=>$value){ ?>
							<tr>
								
								<td><?php echo $value['publisher_name']; ?></td>
								<td>
								   <?php echo $value['official_address']; ?>
								</td>
								<td>
									<?php echo $value['official_email']; ?>
								</td>
								<td style="width:100px;">
									 <?php echo $value['official_phone']; ?>
								</td>
									<td class="txt_cntr">
										<ul class="icons-list" style="text-align: center;">
											<li class="dropdown">
											<button type="button" class="btn btn-secondary toggle_drpdown" id="dropdownMenu2" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="false"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
												<ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="width: 170px;">
												<a href="<?php echo $config['SITE_URL']."editPublisher.php?id=".$value['id'];?>" class="dropdown-item">Edit</a>
												<a class="dropdown-item" onclick="return confirm('Are you sure?');" href="<?php echo $config['SITE_URL']."managePartner.php?delete=1&id=".$value['id'];?>"> Delete</a>
												<?php if($value['status']==1){ ?>          
													<a class="dropdown-item"  href="<?php echo $config['SITE_URL']."managePartner.php?publisher=1&block=0&id=".$value['id'];?>">Block</a>
												<?php } else { ?> 
													<a class="dropdown-item" href="<?php echo $config['SITE_URL']."managePartner.php?publisher=1&unblock=0&id=".$value['id'];?>">Unblock</a>
												<?php } ?>
										</ul>
											</li>
										</ul>
									</td>

                                        </tr>
                                        <?php
                                        
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