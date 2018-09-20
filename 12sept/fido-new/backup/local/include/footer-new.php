            <!-- footer -->
            <footer class="footer-container p-l-0 p-r-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 p-l-0 p-r-0">
                            <div class="float-left">All Right © Reserved Fido 2018.</div>
                            <div class="float-right">
                                <div class="badge badge-danger">version: 2.0.0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- /footer -->

        </section>
        <!-- /Page Container ends -->

        <!-- ScrolltoTop -->
        <!--<a id="scrollTop" href="#top"><i class="icon-arrow-up12"></i></a>-->
        <!-- /ScrolltoTop -->

    </div>



<!-- Layout settings -->
<div class="layout"></div>
<span class="is_hidden" id="jquery_vars">
    <span class="is_hidden switch-active"></span>
    <span class="is_hidden switch-inactive"></span>
    <span class="is_hidden chart-bg"></span>
    <span class="is_hidden chart-gridlines-color"></span>
    <span class="is_hidden chart-legends-text-color"></span>
    <span class="is_hidden chart-grid-text-color"></span>
    <span class="is_hidden chart-data-color-option1"></span>
    <span class="is_hidden chart-data-color-option2"></span>
    <span class="is_hidden chart-data-color-option3"></span>
    <span class="is_hidden chart-data-color-option4"></span>
    <span class="is_hidden chart-data-color-option5"></span>
    <span class="is_hidden chart-data-color-option6"></span>
    <span class="is_hidden chart-data-color-option7"></span>
    <span class="is_hidden chart-data-color-option8"></span>
</span>
<!-- /Layout settings -->

<!-- Global scripts -->
<script src="asset-new/js/core/jquery/jquery.js"></script>
<script src="asset-new/js/deepCode.js"></script>
<script src="asset-new/js/core/jquery/jquery.ui.js"></script>
<!--<script src="asset-new/js/isotope-docs.min.js"></script>-->
<script src="asset-new/js/core/tether.min.js"></script>
<script src="asset-new/js/core/bootstrap/bootstrap.js"></script>
<script src="asset-new/js/core/bootstrap/jasny_bootstrap.min.js"></script>
<script src="asset-new/js/core/navigation/nav.accordion.js"></script>
<script src="asset-new/js/core/hammer/hammerjs.js"></script>
<script src="asset-new/js/core/hammer/jquery.hammer.js"></script>
<script src="asset-new/js/core/slimscroll/jquery.slimscroll.js"></script>
<script src="asset-new/js/extensions/smart-resize.js"></script>
<script src="asset-new/js/extensions/blockui.min.js"></script>
<script src="asset-new/js/forms/uniform.min.js"></script>
<script src="asset-new/js/forms/switchery.js"></script>
<script src="asset-new/js/forms/select2.min.js"></script>
<script src="asset-new/js/plugins/ekko-lightbox.min.js"></script>
<!-- /Global scripts -->
<!--<script src="asset-new/js/forms/form.min.js"></script>
<script src="asset-new/js/forms/form_wizard.min.js"></script>
<script src="asset-new/js/pages/forms/form_wizard.js"></script>
<script src="asset-new/js/pages/forms/form_checkboxes_radios.js"></script>-->
<script src="asset-new/js/forms/datepicker.min.js"></script>
<script src="asset-new/js/forms/datepicker.en.js"></script>
<script src="asset-new/js/charts/highcharts.js"></script>
<script src="asset-new/js/charts/highcharts-more.js"></script>
<script src="asset-new/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="asset-new/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="asset-new/js/plugins/tables/datatables/extensions/fixed_header_fido.min.js"></script>
<script src="asset-new/js/core/app/layouts.js"></script>
<script src="asset-new/js/core/app/core.js"></script>
		<!-- Core scripts -->
<script src="asset/js/custom.js"></script>
<script src="asset/js/function.js"></script>
<script>
$(document).ready(function(){
 
 function load_unseen_notification_red(view = '')
 {
  $.ajax({
   url:"ajax.php?action=load_notification_red",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    
       $('.menu-red').html(data.notification);
        if(data.unseen_notification > 0)
        {
            $('.bg-danger').css("display","block");
            $('.count-red').html(data.unseen_notification);
        }
       else{
           $('.bg-danger').css("display","none");
       }
       
   }
  });
 }
    
function load_unseen_notification_green(view = '')
 {
  $.ajax({
   url:"ajax.php?action=load_notification_green",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    
       $('.menu-green').html(data.notification);
        if(data.unseen_notification > 0)
        {
            $('.bg-success').css("display","block");
            $('.count-green').html(data.unseen_notification);
        }
       else{
           $('.bg-success').css("display","none");
       }
       
   }
  });
 }
    $(".red_noti").click(function() {
        $('.bg-danger').css("display","none");
        $('.count-red').html('');
        load_unseen_notification_red('yes');
    });
    
    $(".green_noti").click(function() {
        $('.bg-success').css("display","none");
        $('.count-green').html('');
        load_unseen_notification_green('yes');
    });
    load_unseen_notification_red();
    load_unseen_notification_green();
    /*
    setInterval(function(){ 
      load_unseen_notification_red();
      load_unseen_notification_green();
     }, 5000);
    */
});
</script>
<script>

if(data_search.length === 0){
    }else{
        $('#usertable_filter').css("display","none");
    }
    
</script>

</body>
</html>