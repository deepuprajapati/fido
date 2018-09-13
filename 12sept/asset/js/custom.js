if(data_search.length === 0 ){

$(function () {
$(document).ready(function() {
	
	
    $('#usertable th').on("click.DT", function (e) {
        //stop Propagation if clciked outsidemask
        //becasue we want to sort locally here
        if (!$(e.target).hasClass('sortMask')) {
            e.stopImmediatePropagation();
        }
    });
	
	var table = $('#usertable').DataTable( {
	pageLength: 50,
	fixedHeader: true,
	dom: 'Bfrtip',
	buttons: [
			'csv', 'excel', 
		],
	aoColumnDefs: [{
		bSortable: false,
		aTargets: ['nosort']
	}]	
	} );
	

    // Setup - add a text input to each footer cell
    $('#usertable thead th .src_inpt').each( function () { 
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#usertable').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
	


} );
	
	
    $('a.toggle-vis').on('click', function (e) {
        e.preventDefault();
        var table = $('#usertable').DataTable();
        // Get the column API object
        var column = table.column($(this).attr('data-column'));
        // Toggle the visibility
        column.visible(!column.visible());
    });
   // $('.dataTables_filter').css('float', 'left');
});
    
}else {
    var table = $('#usertable').DataTable( {
	pageLength: 50,
	fixedHeader: true,
	dom: 'Bfrtip',
	buttons: [
			'csv', 'excel', 
		],
	aoColumnDefs: [{
		bSortable: false,
		aTargets: ['nosort']
	}]	
	} );
        table.search(data_search).draw();
    
    
}
/* correct */
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var checkin = $('#startdate').datepicker({
    format: 'yyyy-mm-dd'
    , onRender: function (date) {
        return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
    if (ev.date.valueOf() > checkout.viewDate.valueOf()) {
        var newDate = new Date(ev.date)
        newDate.setDate(newDate.getDate() + 1);
        checkout.setValue(newDate);
    }
    checkin.hide();
    $('#startdate')[0].focus();
}).data('datepicker');
var checkout = $('#enddate').datepicker({
    format: 'yyyy-mm-dd'
    , onRender: function (date) {
        return date.valueOf() <= checkin.viewDate.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) { 
    checkout.hide();
}).data('datepicker');
var checkinv = $('#invdate').datepicker({
    format: 'yyyy-mm-dd'
    , onRender: function (date) {
        return date.valueOf() <= checkout.viewDate.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
    checkinv.hide();
}).data('datepicker');

function showhide(id) {
	//alert();
    if (jQuery('#check_' + id).is(':checked')) {
        $('#price_' + id).show();
        $('#comm_' + id).show();
    }
    else {
        $('#price_' + id).hide();
        $('#comm_' + id).hide();
    }
}
// Making all the check boxes into switch
$(document).ready(function () {
    var elem = document.querySelectorAll('.js-switch');
    var init = new Switchery(elem);
    $('.showpermission').click(function (event) {
        var pk = this.dataset.user;
        var type = this.dataset.userRole;
        ajax_request('permissionAjax.php', {
            pk: pk
            , type: type
        }, function () {})
    });
    $('select[name="type_cat"]').change(function () {
        var select_value = this.value;
        if (select_value == 'E') {
            $('#is_pulisher').removeClass('hidden');
        }
        else {
            $('#is_pulisher').addClass('hidden');
        }
    })
});


function myFunctionForClass(obj) {
    $(obj).find("span").toggleClass("glyphicon-minus glyphicon glyphicon-plus").addClass('glyphicon');;
}