<script>


jQuery( document ).ready(function( $ ) {
	
	
	//bind modal close event
	$('#modalBackupRestore').on('hidden.bs.modal', function (e) {
	  //inject website name
	  $( '#injectTextTitleBackupRestore' ).html( 'Backups of site:' );
	  $( '#btnTakeSiteBackupNow' ).removeClass( 'disabled' ).html( 'Click here to take backup now' );
	  
	  //show the loading div
	  $( '.modalLoadingDivWrapper' ).slideDown();
	  
	  //hide injectSiteBackupData
	  $( '#injectSiteBackupData' ).slideUp();
	  
	});
	
	
	//on btnTakeSiteBackupNow click start
	$( '#btnTakeSiteBackupNow' ).click(function( e ){
		e.preventDefault();
		
		var selectedNodeId = $(this).data('node-id');
		var selectedSiteId = $(this).data('site-id');
		var buttonOldHtml = $(this).html();
		
		$(this).addClass( 'disabled' ).html( '<i class="fas fa-spinner fa-spin me-1"></i> Registering your backup request...' );
		
		takeSiteBackup( $, selectedNodeId, selectedSiteId )
		.done( function( apiData ){
			
			swalWithBootstrapButtons.fire({
			  title: 'successfully queued',
			  text: apiData.msg,
			  icon: 'success', confirmButtonText: 'Got it!', showConfirmButton: true,
			});
			
		})
		.fail( function( err ){
			swalWithBootstrapButtons.fire({
			  text: err.responseJSON.errorMsg, icon: 'error', showCancelButton: true, cancelButtonText: 'Dismiss', showConfirmButton: false,
			});
		})
		.always(function (){
			$( '#btnTakeSiteBackupNow' ).removeClass( 'disabled' ).html( buttonOldHtml );
		});
		
	});
	//on btnTakeSiteBackupNow click ends
	
	
	
	
	//dynamic btnRestoreSiteBackupNow click start
	$( '#injectSiteBackupData' ).on( 'click', '.btnRestoreSiteBackupNow', function( e ) {
		e.preventDefault();
		
		var selectedNodeId = $(this).closest('table').data('node-id');
		var selectedSiteId = $(this).closest('table').data('site-id');
		var selectedNonce = $(this).closest('tr').data('nonce-id');
		var buttonOldHtml = $(this).html();
		var buttonElement = $(this);
		
		$(this).addClass( 'disabled' ).html( '<i class="fas fa-spinner fa-spin me-1"></i>' );
		
		restoreSiteBackup( $, selectedNodeId, selectedSiteId, selectedNonce )
		.done( function( apiData ){
			
			swalWithBootstrapButtons.fire({
			  title: 'successfully queued',
			  text: apiData.msg,
			  icon: 'success', confirmButtonText: 'Got it!', showConfirmButton: true,
			});
			
		})
		.fail( function( err ){
			swalWithBootstrapButtons.fire({
			  text: err.responseJSON.errorMsg, icon: 'error', showCancelButton: true, cancelButtonText: 'Dismiss', showConfirmButton: false,
			});
		})
		.always(function (){
			buttonElement.removeClass( 'disabled' ).html( buttonOldHtml );
		});
		
		
	});
	//dynamic btnRestoreSiteBackupNow click ends
	
	
	
	
	
	/*
	//dynamic btnRestoreSiteBackupNow click start
	$( '#injectSiteBackupData' ).on( 'click', '.btnRestoreSiteBackupNow', async function( e ) {
		e.preventDefault();
		
		var selectedNodeId = $(this).closest('table').data('node-id');
		var selectedSiteId = $(this).closest('table').data('site-id');
		var selectedNonce = $(this).closest('tr').data('nonce-id');
		var buttonOldHtml = $(this).html();
		var buttonElement = $(this);
		
		$(this).addClass( 'disabled' ).html( '<i class="fas fa-spinner fa-spin me-1"></i>' );
		
		try {
			
			await restoreSiteBackup( $, selectedNodeId, selectedSiteId, selectedNonce ).done( function( apiData ){
				swalWithBootstrapButtons.fire({
				  title: 'successfully queued',
				  text: apiData.msg,
				  icon: 'success', confirmButtonText: 'Got it!', showConfirmButton: true,
				});
			});
			
		} catch( err ) {
			swalWithBootstrapButtons.fire({
			  text: err.responseJSON.errorMsg, icon: 'error', showCancelButton: true, cancelButtonText: 'Dismiss', showConfirmButton: false,
			});
		}
		
		buttonElement.removeClass( 'disabled' ).html( buttonOldHtml );
		
	});
	//dynamic btnRestoreSiteBackupNow click ends
	*/

});


</script>



<div id="modalBackupRestore" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	

	<div class="modal-header">
		<h5 class="modal-title" id="injectTextTitleBackupRestore">Backups of site:</h5>
		<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
		
	<div class="modal-body pb-0">
		<div><a id="btnTakeSiteBackupNow" class="btn btn-success btn-md" data-node-id="0" data-site-id="0">Click here to take backup now!</a></div>
		<hr />
	</div>
	<div id="" class="text-center my-2 modalLoadingDivWrapper">
		<button type="button" class="btn btn-success btn-sm" disabled><i class="fas fa-spinner fa-spin me-1"></i> Loading</button>
	</div>
	
	<div class="modal-body">
		<div id="injectSiteBackupData" style="display:none;"></div>
	</div>
	  
	  

</div>	  
</div>
</div>