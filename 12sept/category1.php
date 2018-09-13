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

.rightApp_btn a{

}

.rightApp_btn a i{
    font-size: 15px;
    border: 1px solid gainsboro;
    width: 22px;
    height: 19px;
    margin-right: 5px;
    line-height: 20px;
    top: 0 !important;
}

.editPencil i{
color: #ed4d66;	
}

.editPencil:hover i{
color: #984cf3;	
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

// Instantiate the user class
$user=new user();
   $category = new Category();
//$userlist= $user->findcustomrow();

   $allCategories = $category->allcategorydetail();


   if(isset($_GET['delid'])){
	   $category->id	 = $_GET['delid'];
	   $category->delete();
	   $_SESSION['msgsuccess'] = "Category has been deleted successfully";
		redirectAdmin('category.php');
}
if(isset($_GET['delete'])){
	   $category->delete($_GET['catId']);
			$_SESSION['msgsuccess'] = "User has been deleted successfully";
			redirectAdmin('category.php');

   }

	?>

       <section class="main-container">
    <div class="header headerCntnt_wrapr">
      <div class="heading_top">
        <div class="page-title">Manage Services</div>
      </div>
      <!--<div class="links"><a href="addProject.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>  CREATE ESTIMATE REQUISITION</a></div>-->
    </div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn">
                        <table class="table datatable table-hover table-bordered dataTable_cstm datatable-header-basic fixTlb_hdr_minwidht">
            <thead>
							<tr>
								<th>S.no.
								<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
								<div class="sortMask"></div>
								</th>
								<th>Name
								<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
								<div class="sortMask"></div>
								</th>
								<th>Head
								<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
								<div class="sortMask"></div>
								</th>
								<th style="text-align:center;" class="no_Sort" style="width:70px;">Action</th>
							</tr>
                            </thead>

                                <tbody>
                                    <?php
										$i = 0;
											if(isset($allCategories) and is_array($allCategories) and count($allCategories)>0)
											{
												foreach($allCategories as $k=>$category){
													$i++
												?>
                                        <tr>
                                            <td style="width:100px;text-align:center;">
                                                <?php echo $i; ?>
                                            </td>

                                            <td>
                                                <?php echo $category['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $category['username']; ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <!--		<a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?');" href="<?php echo $config['SITE_URL']."category.php?delete=1&catId=".$category['id'];?>">Delete</a><a class="btn btn-primary btn-xs" href="<?php echo $config['SITE_URL']."editCategory.php?catId=".$category['id'];?>">Edit</a> -->
												<a href="<?php echo $config['SITE_URL']."editCategory.php?catId=".$category['id'];?>" class="editPencil"><i class="icon-pencil6 icn_sz_20"></i></a>

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