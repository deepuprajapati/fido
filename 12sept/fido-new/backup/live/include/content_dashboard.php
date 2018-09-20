<?php 
$logid_js = "var ttl_no = parseInt($('.nojs_1').text()) + parseInt($('.nojs_2').text()) + parseInt($('.nojs_3').text()) + parseInt($('.nojs_4').text());";
?>
<div class="p-t-28">
                         <div class="card card-inverse card-flat border-none resCd_dsh_crd">
                            <div class="card-block cardBlck_cstm p-b-10">
                                <div class="row p-t-10 p-b-10 m-0 resCd_pd0">
                                    <div class="col-lg-3 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Active project</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_1"><?php echo count($project->selectallEstimateWithQuery('9'," and p.po_approvel = 1 and p.process = 0 ")); ?></span>
                                                <a href="<?php echo $config['SITE_URL']."globelServices.php?action=active_project";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_1_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_1_txt"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Leads -->
                                    <div class="col-lg-3 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Upcoming Project</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_2"><?php echo count($project->selectallEstimateWithQuery('9'," and p.po_approvel !=1 "))?></span> <a href="<?php echo $config['SITE_URL']."globelServices.php?action=upcoming_project";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_2_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_2_txt"></div>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-4 col-4 no-p text-right"><i class="icon-comment x6 text-grey-100 m-t-15"></i></div>--></div>
                                        <div style="display:none" id="leads"></div>
                                    </div>
                                    <!-- /Leads -->
                                    <!-- Sales -->
                                    <div class="col-lg-3 col-sm-6 p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
                                        <div class="cardBx_dashbrd cardBx_dashbrd_mrg0">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Project With Requisition For Invoice</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_3"><?php echo count($project->selectallEstimateWithQuery('9'," and p.process = 1 and p.reconciliation = 0 ")); ?></span>
                                                <a href="<?php echo $config['SITE_URL']."globelServices.php?action=requisition_for_invoice";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_3_css" ></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_3_txt"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display:none" id="sales"></div>
                                    </div>
                                    <!-- /Sales -->
                                    <!-- Sales -->
                                    <div class="col-lg-3 col-sm-6 p-l-0 p-r-0 resCode_dsh_cart">
                                        <div class="cardBx_dashbrd cardBx_dashbrd_mrg0">
                                            <div class="col-md-12 col-12">
                                                <h4 class="text-uppercase text-muted no-m">Invoiced</h4>
                                                <div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_4"><?php echo count($project->selectallEstimateWithQuery('9'," and p.process = 1 and  p.reconciliation = 1 ")); ?></span>
                                                <a href="<?php echo $config['SITE_URL']."globelServices.php?action=invoiced";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="procesBar_in_cart">
                                                    <div class="float-left" style="width:75%;padding-right: 7px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success-100 nojs_4_css"></div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right text-semibold text-muted nojs_4_txt"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                            <li><a href="<?php echo $config['SITE_URL']?>estimate.php?action=pending_requisition_to_invoice" class="list-group-item">Requisition for Invoice</a></li>
                        </ul>
                    </div>
                    <!-- /Bordered table -->
                </div>
				
                <div class="quicklink_section flx_cntWidth_33 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Welcome to the freshly designed FIDO</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
						<ul class="linkWdth_btn">
						<li><span>Any Feedback? </span> <a href="https://goo.gl/forms/WkPB3MyHmge2ejBX2" target="_blank" class="btn btn-xs  pull-right icnlnk_cards"><i class="icon-arrow-right42"></i></a></li>
						<li><span>Don't Know your Role in FIDO? </span> <a href="https://goo.gl/ebhx1U" target="_blank" class="btn btn-xs  pull-right icnlnk_cards"><i class="icon-arrow-right42"></i></a></li>
						<li><span>Want to know more about FIDO? </span> <a href="https://public.3.basecamp.com/p/72oD88NCautA23fUDByJy8vE" target="_blank" class="btn btn-xs pull-right icnlnk_cards"><i class="icon-arrow-right42"></i></a></li>
						
						</ul>
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
                                    <tr>
                                        <th>Brand</th><th>Target</th><th>Achieved</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                   <?php $i=1;
                          foreach($allprojectiondata as $key=>$value) { 
                              if($i == 5) break;
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
                              if($i == 5) break;
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
                            <div class="card-title">Active Projects</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                            <table class="table table-bordered table-hover tableSml_dash_style">
                                <thead>
                                   <tr><th>Client Name</th><th>Project Name</th><th>Amount</th><th>Estimate No</th></tr>
                                </thead>
                                <tbody>
                            <?php $i=1;
                        foreach($media_revenue_lose_for_dashbord as $key=>$value) { 
                              if($i == 5) break;
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
                <div class="flx_cntWidth_55 p-0 bgWhite resCodeSng_cart">
                    <!-- Bordered table -->
                    <div class="card card-inverse card-flat box_border_0">
                        <div class="card-header brdr-b">
                            <div class="card-title">Partially Payment Recieved</div>
                        </div>
                        <!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
                        <div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
                            <table class="table table-bordered table-hover tableSml_dash_style">
                                <thead>
                                    <tr><th>Invoiced</th><th>Payment Recieved</th><th>Balance </th><th> Days</th></tr>
                                </thead>
                                <tbody>
                               <?php $i=1;
                        foreach($paymentDetail as $key=>$value) { 
                              if($i == 5) break;
                              ?>
                        <tr>
                          
                            <td><?php echo $mformate->numberToCurrency($value['amt']) ?></td>
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