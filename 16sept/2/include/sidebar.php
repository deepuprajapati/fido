        <div class="sidemenu_hlder">
			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="home-shifting.php">HOME SHIFTING</a>
			   </div>
			</div>
			
			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="office-relocation-services.php">OFFICE RELOCATION SERVICES</a>
			   </div>
			</div>

			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="long-short-term-storage.php">LONG & SHORT-TERM STORAGE</a>
			   </div>
			</div>

			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="vehicle-moving.php">VEHICLE MOVING</a>
			   </div>
			</div>


			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="international-relocations.php">INTERNATIONAL RELOCATIONS</a>
			   </div>
			</div>


			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="insurance-services.php">INSURANCE SERVICES</a>
			   </div>
			</div>


			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="home-assist.php">HOME ASSIST</a>
			   </div>
			</div>


			<div class="lftbar_sngle_menu">
			  <div class="content">
					<a href="fine-art-move-experts.php">FINE ART MOVE EXPERTS</a>
			   </div>
			</div>
        </div>
		
		
<script>



$(function () {
    setNavigation();
});

function setNavigation() {
   
	var pathname = window.location.href;
	var sortpath = pathname.substring(pathname.lastIndexOf('/') + 1);
	

    $(".sidemenu_hlder .content a").each(function () {
        var href = $(this).attr('href');
		console.log(href);
		
		if(sortpath == href){
			$(this).parent().addClass('active');
			
		}
		
        /*if (sortpath.substring(0, href.length) === href) {
            $(this).closest('.content').addClass('active');
        }*/
    });
}
		
</script>		