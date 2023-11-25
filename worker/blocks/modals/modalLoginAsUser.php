<script>


jQuery( document ).ready(function( $ ) {
	
	$('#modalLoginAsUser').on('hidden.bs.modal', function (e) {
	  //inject website name
	  $('#injectTextTitleLoginAsUser').html( 'Login as user:' );
	  
	  //show the loading div
	  $( '.modalLoadingDivWrapper' ).slideDown();
	  
	  //hide the table div
	  $( '#modalUserListTable' ).slideUp();
	});
	
	
	
	
	//dynamic onclick get user login link
	$( '#dumpHTMLHereUsersList' ).on("click", '.actionGetUserLoginLink', async function( e ) {
		e.preventDefault();
		
		var selectedNodeId = $(this).data('node-id');
		var selectedSiteId = $(this).data('site-id');
		var selecteduserId = $(this).data('user-id');
		
		$(this).html( '<i class="fas fa-spinner fa-spin me-1"></i>' );
		
		try {
			
			var oneTimeLoginLink = await getSiteUserLoginLink( $, selectedNodeId, selectedSiteId, selecteduserId );
			oneTimeLoginLink = oneTimeLoginLink.data[0]['one-time-login'];
		
			//update the href attribute
			$(this).attr("href", oneTimeLoginLink).removeClass('actionGetUserLoginLink btn-link').addClass('actionGetUserLoginLinkReady btn-warning ps-2 pe-2');
			
			//change the icon
			$(this).html( '<i class="fas fa-external-link-square-alt"></i> Ready' );
			
		} catch( err ) {
			$(this).attr("href", '#').removeClass('actionGetUserLoginLink btn-link').addClass('btn-danger ps-2 pe-2');
			$(this).html( '<i class="fas fa-external-link-square-alt"></i> Error' );
			swalWithBootstrapButtons.fire({
			  text: err.responseJSON.errorMsg, icon: 'error', showCancelButton: true, cancelButtonText: 'Dismiss', showConfirmButton: false,
			});
		}
  

	});
	
	
	
	
	

});
	
</script>



<div id="modalLoginAsUser" class="modal fade" tabindex="-1" role="dialog">

<div class="modal-dialog modal-lg" role="document" style="max-width:980px;">
	<div class="modal-content">
	
	
		<div class="modal-header">
			<h5 class="modal-title" id="injectTextTitleLoginAsUser">Login as user:</h5>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	  
	  
<form>  
<div class="modal-body">

		<div class="text-center mb-1 modalLoadingDivWrapper">
			<button type="button" class="btn btn-success btn-sm" disabled><i class="fas fa-spinner fa-spin me-1"></i> Loading</button>
		</div>
		
		
		<div id="modalUserListTable" style="display:none;">
		
			<table class="table table-striped mb-4">
			  <thead>
				<tr>
				  <th scope="col">ID</th>
				  <th scope="col">Login</th>
				  <th scope="col">Email</th>
				  <th scope="col">Display name</th>
				  <th scope="col">Roles</th>
				  <th scope="col">Registered date</th>
				  <th scope="col">Login</th>
				</tr>
			  </thead>
			  <tbody id="dumpHTMLHereUsersList">
			  </tbody>
			</table>

			<div id="otherAccessInfoHtmlDumpWrapper" class="row px-1"></div>
			
		</div>
		

</div>
</form>
	  
    </div>
  </div>
</div>