<?php
/**
*	THIS FILE IS FOR ADMIN LOGIN LOGOUT	5/4/2014
**/
$fileBasePath = dirname(__FILE__).'/';
include_once('include/header.php');
include_once('include/sidebar.php');


?>

<section class="main-content">
                <div class="content-wrap">
                    <div class="wrapper">
                        <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">Get Information</header>
                                    <div class="panel-body">
                                        <form class="form-inline" role="form">
                                            <div class="form-group mr5">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="text" class="form-control"  placeholder="">
                                            </div>
                                            <div class="form-group mr5">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="text" class="form-control"  placeholder="">
                                            </div>
                                            <div class="checkbox mr5">
                                                <label>
                                                    <input type="checkbox">Remember me
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default">Sign in</button>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        
                    </div>
    </div>
</section>