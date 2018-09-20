<aside class="sidebar offscreen-left">
    <ul class="nav navbar-nav" style="float:right;">
                        
                    </ul>
                <!-- main navigation -->
                <nav class="main-navigation" data-height="auto" data-size="6px" data-distance="0" data-rail-visible="true" data-wheel-step="10">
                   <!--  <div class="menuTlge">
                    <a href="javascript:;" class="toggle-sidebar deepak">
                        <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                        </a>
                        </div>-->
                    <ul class="nav">
                        <!-- dashboard -->
                        <li>
                            <a href="dashboard.php" >
                               <i class="fa fa-tachometer" aria-hidden="true" style="font-size:19px;"></i>

                                <span class="">Dashboard</span>
                            </a>
                        </li>
                        <?php  $userarray=array(1,6,14,2,16,15);
						if(in_array($userinfo['type'], $userarray)){  ?>
                         <li>
                            <a href="estimate.php" >
                                <i class="fa fa-file-text" aria-hidden="true" style="font-size:19px"></i>

                                <span>Estimate Management</span>
                            </a>
                        </li>
                        
			<?php  } 
                        $userarray=array(3,11,13,17);
						if(in_array($userinfo['type'], $userarray)){  ?>
                         <li>
                            <a href="globelServices.php" >
                                <i class="fa fa-file-text" aria-hidden="true" style="font-size:19px"></i>

                                <span class="animated fadeInUpmenu">Estimate Management</span>
                            </a>
                        </li>
			<?php } 
                    $userarray=array(1,12);
						if(in_array($userinfo['type'], $userarray)){  ?>
                         <li>
                            <a href="content.php" >
                                <i class="fa fa-file-text" aria-hidden="true" style="font-size:19px"></i>

                                <span class="animated fadeInUpmenu">Estimate Management</span>
                            </a>
                        </li>
                <?php }
                $userarray = array(1,14);
                if(in_array($userinfo['type'], $userarray)){  ?>
						<li>
                            <a href="userAssign.php" >
                                <i class="fa fa-user-plus" aria-hidden="true" style="font-size:19px;"></i>

                                <span>Client Assign</span>
                            </a>
                        </li>
                        <?php } ?>
						
						 <!--<li>
                            <a href="estimate.php">
							<i class="toggle-accordion"></i>
                                <i class="ti-layout-media-overlay-alt-2"></i>
                                <span>Estimate Management</span>
                            </a>
							<ul class="sub-menu" style="">
                <li>
                                    <a href="addProject.php">
                                        <span>Create a new requisition</span>
                                    </a>
                                </li>
                                <!--
								<li>
                                    <a href="project.php">
                                        <span>Estimates</span>
                                    </a>
                                </li>

                            </ul>
                        </li>-->
						<!--<li>
						 <a href="javascript:;">
                                <i class="toggle-accordion"></i>
                                <i class="ti-layers"></i>
                                <span>Services</span>
                            </a>
                            <ul class="sub-menu">
							
                                <li>
                                    <a href="seo.php">
                                        <span>Seo</span>
                                    </a>
                                </li>
								<li>
                                    <a href="sem.php">
                                        <span>Sem</span>
                                    </a>
                                </li>

						
                        
                                <li>
                                    <a href="content.php">
                                        <span>Content</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="reimbursement.php">
                                        <span>Reimbursement</span>
                                    </a>
                                </li>
								<?php 
						$userarray=array(1,6,33);
						if(in_array($userinfo['type'], $userarray)){
						?>
								<li>
                                    <a href="social.php">
                                        <span>Social</span>
                                    </a>
                                </li>
                            <?php
						} ?>
                            </ul>


                        </li>-->

						<?php
						$userarray=array(1,5);
						if(in_array($userinfo['type'], $userarray)){
						?>
						 <li>
                            <a href="mediaClient.php" >
                               <i class="fa fa-sort-numeric-desc" aria-hidden="true" style="font-size:19px"></i>

                                <span>Media Management</span>
                            </a>
							
                        </li>
						<?php
						}
						$userarray=array(1,6);
						if(in_array($userinfo['type'], $userarray)){
						?>
					    <li>
                            <a href="invoiceSection.php" >
                                <i class="fa fa-file-text" aria-hidden="true" style="font-size:19px"></i>
                                <span>Invoice Management</span>
                            </a>

                        </li>
          <!--
						<li>
                            <a href="Ros.php">
                                <i class="fa fa-list-alt"></i>
                                <span>R.O.s</span>
                            </a>
                        </li>
						<li>
                            <a href="javascript:;">
							<i class="toggle-accordion"></i>
                                <i class="ti-layout-media-overlay-alt-2"></i>
                                <span>General Setting</span>
                            </a>
							<ul class="sub-menu" style="">

								<li>
                                    <a href="dashboardSetting.php">
                                        <span>Dashboard Setting</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="projection.php">
                                        <span>Projection</span>
                                    </a>
                                </li>

                            </ul>

                        </li>

						<li>
                            <a href="javascript:;">
							<i class="toggle-accordion"></i>
                                <i class="ti-star"></i>
                                <span>R.O. Register</span>
                            </a>
							<ul class="sub-menu" style="">
								<li>
                                    <a href="publishersInformation.php">
                                        <span>R.O. Register</span>
                                    </a>
                                </li>
								<li>
                                    <a href="roRegister.php">
                                        <span>Client's R.O.</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="roexldownload.php">
                                        <span>R O report.</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
						<li>
                            <a href="javascript:;">
							<i class="toggle-accordion"></i>
                                <i class="ti-write"></i>
                                <span>Sale Register</span>
                            </a>
							<ul class="sub-menu" style="">
								<li>
                                    <a href="saleRegister.php">
                                        <span>Sale Register</span>
                                    </a>
                                </li>
								<li>
                                    <a href="payment.php">
                                        <span>Payment Register</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
						<li>
                            <a href="javascript:;">
							<i class="toggle-accordion"></i>
                                <i class="fa fa-institution"></i>
                                <span>ARM Traffic</span>
                            </a>
							<ul class="sub-menu" style="">
								<li>
                                    <a href="estsummwithwip.php">
                                        <span>Est. summ with WIP</span>
                                    </a>
                                </li>
								<li>
                                    <a href="payment.php">
                                        <span>Summary Sheet</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
						<li>
                            <a href="javascript:;">
							<i class="toggle-accordion"></i>
                                <i class="ti-write"></i>
                                <span>Publisher Register</span>
                            </a>
							<ul class="sub-menu" style="">
								<li>
                                    <a href="billRegister.php">
                                        <span>Bill</span>
                                    </a>
                                </li>
								<li>
                                    <a href="paymentRegister.php">
                                        <span>Payment</span>
                                    </a>
                                </li>

                            </ul>
                        </li> -->
						<?php }
						$userarray=array(1);
						if(in_array($userinfo['type'], $userarray)){
						?>
                        
                            
                                <li>
                                    <a class="menu" href="addBlogger.php" >
                                        <i class="fa fa-sitemap" aria-hidden="true" style="font-size:19px"></i>
                                        <span>Add Blogger</span>
                                    </a>
                                </li>
								
                              
            
                          <?php } 
                        
						$userarray=array(111,4);
						if(in_array($userinfo['type'], $userarray)){
						?>
                                
                                <li>
                                    <a href="digitalPR.php">
                                        <i class="fa fa-file-text" aria-hidden="true" style="font-size:19px"></i>
                                        <span class="animated fadeInUpmenu">Digital PR</span>
                                    </a>
                                </li>
                        <?php } ?>
                    </ul>
                </nav>
            </aside>
            <!-- sidebar menu -->