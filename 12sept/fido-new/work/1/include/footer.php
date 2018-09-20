</section>
</div>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="asset/bootstrap/js/bootstrap.js"></script>
<script src="asset/plugins/jquery.slimscroll.min.js"></script>
<script src="asset/plugins/jquery.easing.min.js"></script>
<script src="asset/plugins/appear/jquery.appear.js"></script>
<script src="asset/plugins/jquery.placeholder.js"></script>
<script src="asset/plugins/fastclick.js"></script>
<!-- /core scripts -->
<script src="asset/plugins/switchery/switchery.js"></script>
<!-- page level scripts -->
<script src="asset/plugins/dropzone/dropzone.js"></script>
<script src="asset/plugins/chosen/chosen.jquery.min.js"></script>
<script src="asset/plugins/daterangepicker/moment.js"></script>
<script src="asset/plugins/daterangepicker/daterangepicker.js"></script>
<script src="asset/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="asset/plugins/timepicker/jquery.timepicker.min.js"></script>
<script src="asset/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="asset/plugins/bootstrap-colorpalette/bootstrap-colorpalette.js"></script>
<script src="asset/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<!-- /page level scripts -->
<!-- template scripts -->
<script src="asset/js/offscreen.js"></script>
<script src="asset/js/main.js"></script>
<script src="asset/js/function.js"></script>
<script src="asset/js/form-custom.js"></script>
<script src="asset/js/custom.js"></script>
<script>
$(document).ready(function() {
    $(".deepak").click(function() {
        console.log("durgesh");
        $(this).find('i').toggleClass('fa-chevron-circle-right fa-chevron-circle-left');
    });
});

</script>

</body>
<!-- /body -->
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    tfoot {
        display: table-header-group;
    }
</style>
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
</html>
