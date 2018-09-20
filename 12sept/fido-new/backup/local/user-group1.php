<?php include('include/header-files.php'); ?>
<!-- write your custom css and js here -->
<style>
.fa, .toggle_drpdown i{color: #909090;}

.icons-list>li:first-child {
    margin-left: 0;
}

.chkbox_cstm_wpr .chbx_style{
    margin: 0px auto;
}

.chkbox_cstm_wpr .chbx_style span:after{
    top: 4px;
    left: 4px;	
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

if(isset($_POST['permission_submit']))
{
 if(!empty($_POST['groups'])){
  $array_groups = implode(",",$_POST['groups']);
 }else
 {
      $array_groups ='';
 }
  $userid = $_POST['userid'];
  $admin  = new Admin();
  $admin->id=$userid;
	$admin->groups=$array_groups;
	$admin->save();
}

$admin  = new Admin();

$allUsers = $admin->all('id');


$url = $config['API_BASE_URL'].'roles';
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
$output = curl_exec($ch);
curl_close($ch);
//print_r($output);

$groups = json_decode($output, true);
$group_array = array();
foreach ($groups['data'] as $key => $value) {
  $group_array[$value['id']] = $value['group_name'];
}

/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/
?>
        <!-- Page container begins -->
       <section class="main-container">
    <div class="header headerCntnt_wrapr">
      <div class="heading_top">
        <div class="page-title">Users Group</div>
      </div>
     <!--<div class="links"><a href="addProject.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>  CREATE ESTIMATE REQUISITION</a></div>-->
    </div>
	
	<div class="pageLinsk_top">
		<div class="links"><a href="addUser.php" class="btn btn-primary m-r-10">Add user</a></div>
		<div class="selectOptn">
			<ul class="icons-list m-0">
				<li class="dropdown">
					<button style="" type="button" class="btn btn-secondary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Option <i class="icon-three-bars position-right"></i></button>
					<ul class="dropdown-menu dropdown-menu-sm dropdown-menu-left" style="width: 170px;">
						<a style="font-size:12px;" class="dropdown-item" id="url_for_group" href="group.php">Add /Edit To Groups</a>
					</ul>
				</li>
			</ul>
		</div>
	</div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn">
					<input type="hidden" name="userid" value="<?php echo $userid ?>">
                        <table class="table datatable table-bordered table-hover dataTable_cstm datatable-header-basic">
							<thead>
						  <tr>
							<th width="70px" class="no_Sort txt_cntr">Checkbox</th>
							<th>User Name<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div></th>
							<th>Groups<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div></th>
							</tr>
							</thead>
							<tbody id="group_table">
									<?php
									foreach ($allUsers as $key => $value) {
								?>
										<tr>
											<!--<td class="txt_cntr"><input type="radio" name="users" class="option-input checkbox" value="<?php echo $value['id'] ?>"/></td>-->
											<td class="txt_cntr">
												<div class="chkbox_cstm_wpr">
													<label class="marg_0">
														<div class="chbx_style">
														<input class="shwInput unalocated shwInput" type="radio" name="users"  value="<?php echo $value['id'] ?>">
														<span class="radio_stl"></span></div>
													</label>
												</div>
											</td>
											<td><?php echo $value['name'] ?></td>
											<td><?php
										  if(!empty($value['groups'])){
											$groupsarry =  explode(",", $value['groups']);
											$i=0;
											foreach ($groupsarry as $key => $value) {  if($i!=0) echo",";?>
											  <a href="javascript:;"> <?php echo $group_array[$value] ?><a/>&nbsp;
											<?php $i++; }
										  }
										   ?></td>

								  </tr>
									<?php } ?>
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

      var table_basic = $('.datatable-header-basic').DataTable({
        fixedHeader: tblHead_fix,
        buttons: {
          dom: {
            button: {
              className: 'btn btn-secondary'
            }
          },
          buttons: [
           /* {
              extend: 'colvis',
              text: '<i class="icon-table2"></i> <span class="caret"></span>',
              className: 'btn btn-secondary',
              collectionLayout: 'fixed'
            },
            {extend: 'copy', className: 'copyButton' },
            {extend: 'csv', className: 'csvButton' },
            {extend: 'excel', className: 'excelButton' },
            {extend: 'print', className: 'printButton' }*/
          ]
        }
      });
      
      
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
      

      $('.dataTables_filter input[type=search]').attr('placeholder','Type to search...');
      $('.dataTables_filter input[type=search]').attr('class', 'form-control');

    });
    /* End datatable js code for table and header fixed */
  </script>
  
  
<script>
$(document).ready(function(){
  $("input[name='users']").change(function(){
    //var val = $('input[name=users]:checked').val();
    var val = $(this).val();
    var url = 'group.php?id='+val;
    $("#url_for_group").attr("href", url);
      
});

  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#group_table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  
});

</script>
