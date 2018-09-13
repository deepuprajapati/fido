<?php include('include/header-files.php'); ?>
<!-- write your custom css and js here -->
<style type="text/css">
.highcharts-title {
    font-family: "OpenSans",sans-serif;
    fill: #444 !important;
    font-size: 11px !important;
}
</style>

<!-- write your custom css and js here -->
<!-- Header begins -->
<?php include('include/header-new.php'); 

$dashboard = new dashborad_info();
$type=$userinfo['type'];
$projection = new projection();
$project  = new project();
$mformate = new mediadata();
$media_invoice = new media_invoice();
$year=date('Y');
$date=date("Y-03-31");
$currentdate=date("Y-2-d");
if(strtotime($date) > strtotime($currentdate))
{
    $year= date("Y").'-'.(date('Y')+1);
}else
{
    $year= (date("Y")-1).'-'.(date('Y'));
}
$allprojectiondata = $projection->fordashbord($year,$userinfo['id']);
//print_r(max($allprojectiondata));
//dd($allprojectiondata);
$max_client = array();
$variablesToChk = 0;
foreach($allprojectiondata as $key=>$value){
    if($value['client_id'] != 0){
        if($value['total'] > $variablesToChk)
        {
             $aopid=$value['aopid'];
            $max_client = $value;
            $variablesToChk = $value['total'];
        }
    }
}
//dd($max_client);
@$revenue = $project->clientViseRevenue($max_client['client_id']);
$total_revenue = array_sum(array_column($revenue, 'revenue')); 

@$percent = ($total_revenue*100)/($max_client['total']*100000);

$media_revenue_lose_for_dashbord = $project->media_revenue_lose();

$paymentDetail = $project->getPaymentDetail();
$outstanging_payment = $project->outstangingPayment();

$partner = new Partner();

$recods = $partner->aboutToExpireContract();

$serviceVise = $project->serviceViseClientBilling();
$allmediaBillingForClient = $project->mediaBillingForClient();
//dd($serviceVise);
$allpartially = $project->partially_invoiced_estimates();

$category = new Category();
$allcategory = $category->all();
$cat_arry;
foreach($allcategory as $key=>$value)
{
    $cat_arry[$value['id']] = $value['name'];
}
$allPO = $project->pendingUploadPO($userinfo['id'],'2018-19');

$pendingPO = $project->pendingInvoice($userinfo['id'],'2018-19'); 
$pendingPOApproval = $project->pendingPOapproval($userinfo['id'],'2018-19');



$pdn_est =  count($project->pending_estimate());
$no_est_lst =  count($project->no_po_estimate_list());
$pdn_po_app =  count($project->pending_po_approval_estimate_list());
$slct_est =  count($project->selectallEstimateWithQuery(''," and process = 1 and po_approvel = 1 and  reconciliation = 0 "));
$req_inv =  count($project->requisition_to_invoice());
$inv_est =  count($project->invoiced_estimates());
?>


       
    <!-- Page container begins -->
    <section class="main-container">
        <h1 style="display:none">Empty Heading</h1>


              <div class="container-fluid page-content">
                 <?php 
                        $type = 11; 
                        if($type == 3) { 
                            $tech_partially = $project->partially_invoiced_estimates_tech(8);
                            $tech_active = $project->active_projects(8);
                            include "include/tech_dashboard.php"; }
                        elseif($type == 11) { 
                            $tech_partially = $project->partially_invoiced_estimates_tech(5);
                             $tech_active = $project->active_projects(5);
                            include "include/seo_dashboard.php"; }
                        elseif($type == 4) { 
                            $pr_partially = $project->partially_invoiced_estimates_tech(6);
                             $pr_active = $project->active_projects(6);
                            include "include/digitalPR_dashboard.php"; }
                        elseif($type == 12) { 
                            $tech_partially = $project->partially_invoiced_estimates_tech(29);
                             $tech_active = $project->active_projects(29);
                            include "include/content_dashboard.php"; } 
                        elseif($type == 13) { 
                            $tech_partially = $project->partially_invoiced_estimates_tech(1);
                             $tech_active = $project->active_projects(1);
                            include "include/social_dashboard.php"; }
                        elseif($type == 6) { 
                            include "include/finance_dashboard.php"; }
                        elseif($type == 5) { 
                            $media_partially = $project->partially_invoiced_estimates_media();
                             $media_active = $project->active_projects(2);
                            include "include/media_dashboard.php"; }
                        else{
							
							$logid_js = "var ttl_no = parseInt($('.nojs_1').text()) + parseInt($('.nojs_2').text()) + parseInt($('.nojs_3').text()) + parseInt($('.nojs_4').text()) + parseInt($('.nojs_5').text()) + parseInt($('.nojs_6').text());"
							
                        ?>


                <div class="p-t-28">
                        <div class="card card-inverse card-flat border-none resCd_dsh_crd">
                            <div class="card-block cardBlck_cstm p-b-10">
                                <div class="row p-t-10 p-b-10 m-0 resCd_pd0">
                                    <!-- Leads -->
                                    <div class="col-lg-2 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Pending Estimates Requisitions</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_1"><?php echo count($project->pending_estimate())?></span> <a href="<?php echo $config['SITE_URL']."estimate.php?action=pending_estimates_requisition";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_1_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_1_txt">
														
													</div>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-4 col-4 no-p text-right"><i class="icon-comment x6 text-grey-100 m-t-15"></i></div>--></div>
                                        <div style="display:none" id="leads"></div>
                                    </div>
                                    <!-- /Leads -->
                                    <!-- Payments -->
                                    <div class="col-lg-2 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Approved Estimates</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_2"><?php echo count($project->no_po_estimate_list()); ?></span> <a href="<?php echo $config['SITE_URL']."estimate.php?action=no_po";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_2_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_2_txt">
													 
													</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display:none" id="payment"></div>
                                    </div>
                                    <!-- /Payments -->
                                    <!-- Sales -->
                                    <div class="col-lg-2 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Estimates with PO</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_3"><?php echo count($project->pending_po_approval_estimate_list()); ?></span> <a href="<?php echo $config['SITE_URL']."estimate.php?action=pending_po_approval";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_3_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_3_txt">
													 
													</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display:none" id="sales"></div>
                                    </div>
                                    <!-- /Sales -->
                                    <!-- Sales -->
                                    <div class="col-lg-2 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Unbilled Estimates</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_4"><?php echo count($project->selectallEstimateWithQuery(''," and process = 1 and po_approvel = 1 and  reconciliation = 0 ")); ?></span> 
                                                <a href="<?php echo $config['SITE_URL']."estimate.php?action=pending_requisition_to_invoice";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_4_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_4_txt">
													 
													</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display:none" id="sales"></div>
                                    </div>
                                    <!-- /Sales -->
                                    <!-- Sales -->
                                    <div class="col-lg-2 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd cardBx_dashbrd_mrg0">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Estimates with Requisition to Invoice</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_5"><?php echo count($project->requisition_to_invoice()); ?></span> 
                                                <a href="<?php echo $config['SITE_URL']."estimate.php?action=requisition_to_invoice";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_5_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_5_txt">
													 
													
													</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display:none" id="sales"></div>
                                    </div>
                                    <!-- /Sales -->
                                    <!-- Orders -->
                                    <div class="col-lg-2 col-sm-6 p-l-0 p-r-0 resCode_dsh_cart">
                                        <div class="cardBx_dashbrd cardBx_dashbrd_mrg0">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Invoiced</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_6"><?php echo count($project->invoiced_estimates()); ?></span> 
                                                <a href="<?php echo $config['SITE_URL']."estimate.php?action=invoiced_estimates";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_6_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_6_txt">
													 
													
													</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display:none" id="orders"></div>
                                    </div>
                                    <!-- /Orders -->
                                </div>
                            </div>
                        </div>
                    </div>
                
                
            <div class="cstmRow cstmRow_flex resCodedashBrd_tbl">
                <div class="chartsemi_section flx_cntWidth_33 p-0 bgWhite resCodeSng_cart">
                    <!-- Semi circle donut -->
                    <div class="card card-inverse card-flat box_border_0 m-b-0">
                        <!--<div class="card-header brdr-b">
                            <div class="card-title">Semi circle donut</div>
                        </div>-->
                        <div class="card-header brdr-b">
                            <div class="card-title">Target detail</div>
                            <div class="elements elemnts_thrdot">
                                <ul class="icons-list m-0">
                                    <li class="m-0">
                                        <a ><i class="icon-more iconMore_chrt_optn" id="chrtoption_btn" ></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block p-b-0 p-t-10 chartOptn_menu">
                            <div class="chartOption_wrpr">
                                <form>
                                    <label class="control-label m-b-15">Select Client</label>
                                    <select id='dropdownclient' onchange="changechart()" name="select" class="form-control">
                                     <?php foreach($allprojectiondata as $key=>$value) { ?>
                                            <option value='<?php echo $value['client_id'] ; ?>' <?php if( $value['client_id']== $max_client['client_id']) echo 'selected'; ?>><?php echo $value['client_name']; ?></option>
                                    <?php } ?>
                                    </select>
                                    <div style="clear:both"></div>
                                    <div class="btnGroup_cstm">
                                        <label class="btn btn-md btn-secondary "><input type="radio" name="timetype" checked value="yearly" onclick="changechart()">yearly</label>
                                        <label  class="btn btn-md btn-secondary"><input type="radio" name="timetype" value="quaterly" onclick="changechart()">Quaterly</label>
                                        <label  class="btn btn-md btn-secondary"><input type="radio" name="timetype" value="monthly" onclick="changechart()">Monthly</label>
                                    </div>
                                </form> 
                            </div>
                            <div id="semi-donut"></div>
                        </div>
                    </div>
                    <!-- /Semi circle donut -->
                </div>
                <div class="quicklink_section flx_cntWidth_33 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Quick Link</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <ul class="quick_link_list">
<li><a href="<?php echo $config['SITE_URL']; ?>addProject.php" class="list-group-item">Create Estimates Requisition</a></li>
<li><a href="<?php echo $config['SITE_URL']; ?>estimate.php?action=no_po" class="list-group-item">Upload PO/PR Number and Signed Estimate</a></li>
<li><a href="<?php echo $config['SITE_URL']; ?>estimate.php?action=pending_requisition_to_invoice" class="list-group-item">Requisition for Invoicing</a></li>
</ul>
                    </div>
                    <!-- /Bordered table -->
                </div>

                <div class="quicklink_section flx_cntWidth_33 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                   <div class="card card-inverse card-flat box_border_0">
                            <div class="p-0 bgWhite">
                                <div class="card-header brdr-b">
                                    <div class="card-title">Contract About to Expire</div>
                                </div>
                                <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                                <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                                    <table class="table table-bordered table-hover">
                                    <tbody>
                                      <?php foreach($recods as $k=>$v){ 
                                      echo "<tr><td>".$v['partner_name']."</th><th>".$v['expire_date']."</td></tr>";
                                       } ?> 
                                    </tbody>
                                    </table>
                         </div>
                                </div>
                            </div>
                        </div>
                    <!-- /Bordered table -->
                </div>
            </div>
            
            
            <div class="cstmRow cstmRow_flex resCodedashBrd_tbl">
                <div class="flx_cntWidth_45 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Service wise Target</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                            <table class="table table-bordered table-hover tableSml_dash_style">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Achived</th>
                                        <th>Target</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $j=1;
                                foreach($allmediaBillingForClient as $key=>$value) { 
                                    if($j == 2) break;
                              ?>
                              <tr><td>Media</td><td><?php echo $mformate->numberToCurrency($value['revenue']) ?></td><td><?php echo $projection->servicewisetotal('Media'); ?></td></tr>
                              <?php $j++; } 
                               $i=1;
                                $arry_chk = array();
                                foreach($serviceVise as $key=>$value1) { 
                                    if($i == 5) break;
                                    //print_r($value1);
                                    if (!in_array($value1['service_id'], $arry_chk)){ ?>
                                        <tr><td><?php echo $cat_arry[$value1['service_id']]; ?></td><td><?php echo $mformate->numberToCurrency($value1['sum(d.money)']);
                                            $arry_chk[] = $value1['service_id'];
                                            ?></td><td><?php echo $projection->servicewisetotal($cat_arry[$value1['service_id']]); ?></td></tr>
                                  <?php  }else{
                                        
                                    }
                               $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <!-- /Bordered table -->
                </div>
                <div class="flx_cntWidth_55 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Partially Invoiced</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                            <table class="table table-bordered table-hover tableSml_dash_style">
                                <thead>
                                    <tr>
                                        <th>Brand</th>
                                        <th>Estiamte</th>
                                        <th>Estiamte Money</th>
                                        <th>Invoiced</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $i=1;
                        foreach($allpartially as $key=>$value) { 
                              if($i == 6) break;
                              ?>
                        <tr>
                            <td><?php echo $value['partner_name'] ?></td>
                            <td><?php echo $value['W_O'] ?></td>
                            <td><?php echo $mformate->numberToCurrency($value['totalprice']) ?></td>
                             <td><?php echo $mformate->numberToCurrency($value['invoiceMoney']) ?></td>
                            <td><?php echo $mformate->numberToCurrency($value['totalprice']-$value['invoiceMoney']) ?></td>
                              </tr>
                        <?php $i++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <!-- /Bordered table -->
                </div>
            </div>



            <div class="cstmRow cstmRow_flex resCodedashBrd_tbl">
                <div class="flx_cntWidth_45 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Client wise Target</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                            <table class="table table-bordered table-hover tableSml_dash_style">
                                <thead>
                                    <tr><th>Brand</th><th>Target</th><th>Achieved</th></tr>
                                </thead>
                                <tbody>
                             <?php $i=1;
                                          foreach($allprojectiondata as $key=>$value) { 
                                              if($i == 6) break;
                                             $project  = new project();
                                        $revenue = $project->clientViseRevenue($value['client_id']);
                                        $totalrevenue=0;
                                        if(!empty($revenue))
                                        {   

                                        foreach($revenue as $key=>$value1)
                                        {
                                        #  echo '<pre>'; print_R($value); echo '<pre>';
                                        $totalrevenue+=$value1['revenue'];
                                        }
                                        }
                                              
                                              ?>
                                        <tr>
                                            <td><?php echo $value['client_name'] ?></td>
                                            <td><?php echo $value['total'] ?></td>
                                            <td><?php echo $totalrevenue; ?></td>
                                             
                                              </tr>
                                        <?php $i++;
                                                } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <!-- /Bordered table -->
                </div>
                <div class="flx_cntWidth_55 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Media Revenue loss</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                            <table class="table table-bordered table-hover tableSml_dash_style">
                                <thead>
                                   <tr><th>Brand</th><th>PO Amount</th><th>ROs Raised</th><th>Revenue Lose</th></tr>
                                </thead>
                                <tbody>
                              <?php $i=1;
                        foreach($media_revenue_lose_for_dashbord as $key=>$value) { 
                              if($i == 6) break;
                              ?>
                        <tr>
                            <td><?php echo $value['partner_name'] ?></td>
                            <td><?php echo $mformate->numberToCurrency($value['samt']) ?></td>
                             <td><?php echo $mformate->numberToCurrency($value['scost']) ?></td>
                            <td><?php echo $mformate->numberToCurrency($value['sbal']) ?></td>
                              </tr>
                        <?php $i++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <!-- /Bordered table -->
                </div>
            </div>



            <div class="cstmRow cstmRow_flex">
                <div class="col-md-12 p-0 bgWhite">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Top 5 Outstanding Payment</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                            <table class="table table-bordered table-hover tableSml_dash_style">
                            <thead>
                            <tr><th>#</th><th>Total</th><th>30 Days</th><th>60 Days</th><th>90 Days</th><th>120 Days</th><th>180+ Days</th></tr>
                            </thead>
                            <tbody>
                                <?php $i=1;
                                        foreach($paymentDetail as $key=>$value) { 
                                          if($i == 6) break;
                                          ?>
                                        <tr>
                                        <td><?php echo $value['partner_name'] ?></td>
                                        <td><?php echo $mformate->numberToCurrency($value['amt']) ?></td>
                                         <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                          </tr>
                                        <?php $i++;
                                            } ?>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <!-- /Bordered table -->
                </div>

            </div>
 <?php } ?>
		<?php include('include/footer-new.php'); ?>
		
<script>
	
	$(document).ready(function(){
		
		<?php echo $logid_js;?>	
		
		if(ttl_no != 0){
		
		 var no_ind_1 = parseInt($('.nojs_1').text())/ttl_no*100;
		 var no_ind_2 = parseInt($('.nojs_2').text())/ttl_no*100;
		 var no_ind_3 = parseInt($('.nojs_3').text())/ttl_no*100;
		 var no_ind_4 = parseInt($('.nojs_4').text())/ttl_no*100;
		 var no_ind_5 = parseInt($('.nojs_5').text())/ttl_no*100;
		 var no_ind_6 = parseInt($('.nojs_6').text())/ttl_no*100;
		
		}else{
			
		 var no_ind_1 = parseInt($('.nojs_1').text());
		 var no_ind_2 = parseInt($('.nojs_2').text());
		 var no_ind_3 = parseInt($('.nojs_3').text());
		 var no_ind_4 = parseInt($('.nojs_4').text());
		 var no_ind_5 = parseInt($('.nojs_5').text());
		 var no_ind_6 = parseInt($('.nojs_6').text());
		 
		}
		
		
		 
		 var fnl_perc_v1 = no_ind_1.toFixed(0);
		 var fnl_perc_v2 = no_ind_2.toFixed(0);
		 var fnl_perc_v3 = no_ind_3.toFixed(0);
		 var fnl_perc_v4 = no_ind_4.toFixed(0);
		 var fnl_perc_v5 = no_ind_5.toFixed(0);
		 var fnl_perc_v6 = no_ind_6.toFixed(0);
		 
		$('.nojs_1_css').css("width", fnl_perc_v1+"%");
		$('.nojs_1_txt').text(fnl_perc_v1+"%");
		
		$('.nojs_2_css').css("width", fnl_perc_v2+"%");
		$('.nojs_2_txt').text(fnl_perc_v2+"%");
		
		$('.nojs_3_css').css("width", fnl_perc_v3+"%");
		$('.nojs_3_txt').text(fnl_perc_v3+"%");
		
		$('.nojs_4_css').css("width", fnl_perc_v4+"%");
		$('.nojs_4_txt').text(fnl_perc_v4+"%");
		
		$('.nojs_5_css').css("width", fnl_perc_v5+"%");
		$('.nojs_5_txt').text(fnl_perc_v5+"%");
		
		$('.nojs_6_css').css("width", fnl_perc_v6+"%");
		$('.nojs_6_txt').text(fnl_perc_v6+"%");
		
	});

</script>
		
   </div>
            <!-- Footer -->
     <?php 
     if($type != 6) { 
            ?>    
<script>
    function showhalfcircle(clientname,total, achieved){
    Highcharts.chart('semi-donut', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false,
            width: null,
            height: 200,
            backgroundColor: chart_bg,
            spacingBottom: -80,
            spacingTop: -40,
            spacingLeft: 0,
            spacingRight: 0,
        },
        title: {
            text: clientname,
            align: 'center',
            verticalAlign: 'middle',
            y: -100,
            style: { "fontSize": "11px" }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -50,
                    style: {
                        fontWeight: 'bold',
                        color: 'white'
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%']
            }
        },
        series: [{
            type: 'pie',
            name: 'Total',
            innerSize: '50%',
            colorIndex: 2,
            data: [
                ['Target',   total],
                ['Achieved',     achieved]
            ]
        }]
    });
}
    function changechart()
{    
        $type=$('input[name=timetype]:checked').val();
        $clientid=$('#dropdownclient').val();
        aopid='<?php echo $aopid; ?>';
        $year='<?php echo $year; ?>';
        var url =   'ajax.php?action=dashboardpie&type='+$type+'&clientid='+$clientid+'&aopid='+aopid+'&year='+$year; 
        jQuery.ajax({
            timeout: 10000,
                url: url,
                dataType: 'json',
                success: function(res) {
                        showhalfcircle( res.client_name, parseInt(res.total),parseInt(res.revenue));
                },
                error:function (res){

                }
        });
    
   
}
showhalfcircle('<?php echo $max_client['client_name'] ?>',parseInt(<?php echo (int)$max_client['total'] ?>),parseInt(<?php echo (int)$total_revenue ?>));
</script>
<script>
$(document).ready(function(){
    $('#chrtoption_btn').on("click",function(){
        $('.chartOption_wrpr').toggleClass('act');
        $(this).toggleClass('icon-cross2 act');
    });
    
    $('.btnGroup_cstm label input').on("click",function(){
        $(this).parent().addClass('btn-info');
        $(this).parent().siblings('label').removeClass('btn-info');
    });
})
</script>


<?php } ?>
<!-- /Core scripts -->

