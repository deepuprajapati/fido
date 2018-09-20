</head>
<body id="top">
<div id="body-wrapper" class="body-container">
    <header class="main-nav clearfix">

        <!-- Searchbar 
        <div class="top-search-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="search-input-addon">
                            <span class="addon-icon"><i class="icon-search4"></i></span>
                            <input type="text" class="form-control top-search-input" placeholder="Enter your keyword...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
         Searchbar -->
        <!-- Branding -->
        <div class="navbar-left float-left deskTop_logo">
            <div class="clearfix">
                <ul class="left-branding float-left">
                    <li class="visible-handheld"><span class="left-toggle-switch"><i class="icon-menu7"></i></span></li>
                    <li>
                        <!--<a href="index.html"><div class="logo"></div></a>-->
                        <a href="<?php echo $_COOKIE['url_info']; ?>" style=""><img src="asset-new/img/fido-logo.png" style=""></a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="navbar float-right navbar-toggleable-sm">
            <div class="clearfix">
                <ul class="float-right top-icons">
                    <!-- Quick apps dropdown -->
                        <li class="dropdown apps-dropdown hidden-xs-down">
                            <a href="#" class="dropdown-toggle red_noti" id="apps_dropdown" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
                                <div class="bg-danger"> 
                                    <span class="bubble count-red">1</span>
                                </div>
                                <i class="icon-bell2 navIcon_size"></i>
                            </a>
                           
                            
                        <div class="dropdown-menu animated notifications" style="width:360px;padding-bottom:0" aria-labelledby="apps_dropdown">
                            <div class="topnav-dropdown-header">
                                <span>Notifications</span>
                            </div>
                            <div class="drop-scroll">
                                <ul class="media-list  menu-red">
                                    
                                </ul>
                            </div>
                            <!--<div class="topnav-dropdown-footer">
                                <a href="activities.html">View all Notifications</a>
                            </div>-->
                        </div>
                            
                        </li>
                        
                        <li class="dropdown apps-dropdown hidden-xs-down">
                            <a href="#" class="dropdown-toggle green_noti" id="apps_dropdown" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
                                <div class="bg-success animated"> 
                                    <span class="bubble bubble_grn count-green">2</span>
                                </div>
                                <i class="icon-bell2 navIcon_size"></i>
                            </a>
                           
                            
                        <div class="dropdown-menu animated notifications" style="width:360px;padding-bottom:0" aria-labelledby="apps_dropdown">
                            <div class="topnav-dropdown-header">
                                <span>Notifications</span>
                            </div>
                            <div class="drop-scroll">
                                <ul class="media-list menu-green">
                                    
                                    
                                </ul>
                            </div>
                            <!--<div class="topnav-dropdown-footer">
                                <a href="activities.html">View all Notifications</a>
                            </div>-->
                        </div>
                            
                        </li>
                        
                    <!--<li class="dropdown apps-dropdown hidden-xs-down">
                        <a href="#" class="dropdown-toggle" id="apps_dropdown" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"><i class="icon-grid2"></i></a>
                        <div class="dropdown-menu animated fadeIn" aria-labelledby="apps_dropdown">

                            <ul class="shortcuts clearfix">
                                <li>
                                    <a href="emails.html">
                                        <img src="img/icons/emails.png"/>
                                        <span class="apps-noty">4</span>
                                        <span class="apps-label">Email</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="messages.html">
                                        <img src="img/icons/messages.png"/>
                                        <span class="apps-noty">8</span>
                                        <span class="apps-label">Messages</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="people.html">
                                        <img src="img/icons/people.png"/>
                                        <span class="apps-label">People</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="invoice_list.html">
                                        <img src="img/icons/invoices.png"/>
                                        <span class="apps-label">Invoices</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="projects_list.html">
                                        <img src="img/icons/projects.png"/>
                                        <span class="apps-label">Projects</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ecom_cart.html">
                                        <img src="img/icons/cart.png"/>
                                        <span class="apps-noty">3</span>
                                        <span class="apps-label">Cart</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </li>-->
                    <!-- /Quick apps dropdown -->

                    <!-- Rightbar -->
                    <!--<li><a class="toggle_rightbar" href="#" onclick="open_rightbar()"><i class="icon-list-unordered navIcon_size"></i></a></li>-->
                    
                    <!-- User dropdown -->
                     <?php
                        $userarray=array(1,6,5);
                        if(in_array($userinfo['type'], $userarray)){
                    ?>
                    <li class="dropdown user-dropdown userdrpDwn_cstm">
                        <a href="#" class="toggle_rightbar" data-toggle="dropdown"><i class="icon-list-unordered navIcon_size"></i></a>
                        <div class="dropdown-menu animated no-p">
                            <ul class="user-links">
                                 <?php 
                             $usermediaarray=array(5);
                            if(in_array($userinfo['type'], $usermediaarray)){?>
                            <li><a href="partner.php" >Publisher Management</a></li>
                                <?php }else{ ?>
								<li><a href="managePartner.php">Client Management</a></li>
                                <li><a href="partner.php">Publisher Management</a></li>
                                <li><a href="userManagement.php">User Management</a> </li>
                                <li><a href="category.php">Manage Services</a></li>
                                <li><a href="finance.php">Finance Management</a></li>
                                <li><a href="payment.php">Client Payment</a></li>
                                <li><a href="saleRegister.php">Sale Register</a></li>
                                <li><a href="javascript:;">Purchase Register</a></li>
                                <li><a href="projection.php">AOP </a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </li>
                     <?php } ?>
                    <!-- /User dropdown --> 


                    <!-- User dropdown -->
                    <li class="dropdown user-dropdown">
                        <!--<a href="#" class="btn-user dropdown-toggle hidden-xs-down" data-toggle="dropdown"><img src="asset-new/img/demo/img1.jpg" class="rounded-circle user" alt=""/></a>-->
						<a href="#" class="btn-user dropdown-toggle hidden-xs-down" data-toggle="dropdown" style=" padding: 0;"><i class="icon  icon-profile" style="font-size: 27px;"></i></a>
                        <a style="padding-top: 19px;" class="user-name hidden-xs-down" data-toggle="dropdown"><?php echo (isset($userinfo['name']))?ucfirst($userinfo['name']):'';?></small></a>
                        <a href="#" class="dropdown-toggle hidden-sm-up" data-toggle="dropdown"><i class="icon-more"></i></a>
                        <div class="dropdown-menu animated no-p">
                            <ul class="user-links">
                                <li><a href="profile.php"><i class="icon-profile"></i> My profile</a></li>
                                <li><a href="profile.php"><i class="icon-cogs"></i> Change Password</a></li>
                            </ul>
                            <div class="text-center p-10"><a href="logout.php" class="btn btn-block"><i class="icon-exit3 i-16 position-left"></i> Logout</a></div>
                        </div>
                    </li>
                    <!-- /User dropdown -->

                </ul>
            </div>
        </div>
        <!-- /Navbar icons -->

    </header>
     <!-- Sidebar -->
        <aside class="menu">
            <div class="left-aside-container">

                <!-- User profile -->
                <div class="user-profile"></div>
                <!-- /User profile -->


                <!-- Main menu -->
                <div class="menu-container"></div>
                <!-- /Main menu -->

            </div>
        </aside>
        <!-- /Sidebar -->

