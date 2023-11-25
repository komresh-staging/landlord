<script>


jQuery( document ).ready(function( $ ) {
	
	
	//bind modal close event
	$('#modalUpdateSite').on('hidden.bs.modal', function (e) {
	  //inject website name
	  $('#injectTextTitleUpdateSite').html( 'Update site:' );
	  
	  //show the loading div
	  $( '.modalLoadingDivWrapper' ).slideDown();
	  
	  //hide form
	  $( '#updateSiteForm' ).slideUp();
	  
	});
	
	
	
	//on updateRemovePasswordProtection check uncheck
	$('#updateRemovePasswordProtection').click(function(){
		if( $(this).prop("checked") == true ){
			
			$('#updatePasswordProtection').val('').prop( "disabled", true );
			
		}else if( $(this).prop("checked") == false ){
			$('#updatePasswordProtection').prop( "disabled", false );
		}
		
	});
	
	
	
	
	
	//on updateSiteForm submit
	$( '#updateSiteForm' ).submit(function( e ){
		e.preventDefault();
		showLoadingButtonMessage( $, false, '#updateSiteButtonSubmit', 'working....' );
		
		var updateSiteNodeId = $( '#updateSiteSelectedNodeId' ).val();
		var updateSiteSiteId = $( '#updateSiteSelectedSiteId' ).val();
		
		var paramteres = { 'user':'superduper', 'key':API_KEY, 'node-id':updateSiteNodeId, 'site-id':updateSiteSiteId };
		
		//optional paramaters:
		var updateSiteDomain = $( '#updateSiteDomain' ).val();
		if( updateSiteDomain !== '' ){
			paramteres['domain'] = updateSiteDomain;
		}
		//wp-version
		var updateSiteWpVer = $( '#updateSiteWpVer' ).val();
		if( updateSiteWpVer !== '' ){
			paramteres['wp-version'] = updateSiteWpVer;
		}
		//php-version
		var updateSitePhpVer = $( '#updateSitePhpVer' ).val();
		if( updateSitePhpVer !== '' ){
			paramteres['php-version'] = updateSitePhpVer;
		}
		//restrictions id
		var updateSiteRestrictionGroupId = $( '#updateSiteRestrictionGroupId' ).val();
		if( updateSiteRestrictionGroupId !== '' ){
			paramteres['restrictions-group'] = updateSiteRestrictionGroupId;
		}
		//password protection
		var updatePasswordProtection = $( '#updatePasswordProtection' ).val();
		if( updatePasswordProtection !== '' ){
			paramteres['password-protection'] = updatePasswordProtection;
		}
		//remove password protection
		if( $('#updateRemovePasswordProtection').prop("checked") == true ){
			paramteres['remove-password-protection'] = 'true';
		}
		//change sftp mysql password
		if( $('#updateChangeSftpMysqlPassword').prop("checked") == true ){
			paramteres['change-sftp-mysql-password'] = 'true';
		}
		
		
			


		
		$.ajax({
		method: 'post',
		url:'//ctrl-'+updateSiteNodeId+'.'+ROOT_DOMAIN_NAME+API_VERSION+'site/update/',
		data:paramteres,
		dataType : 'json'
		}).always(function (){
			showLoadingButtonMessage( $, true, '#updateSiteButtonSubmit', 'Update site' );
			
		}).fail(function ( result ){
			
			swalWithBootstrapButtons.fire({
			  text: result.responseJSON.errorMsg, icon: 'error', showCancelButton: true, cancelButtonText: 'Dismiss', showConfirmButton: false,
			});
			
		}).done(function( result ){
		
			if( result.status == false ){
				swalWithBootstrapButtons.fire({
				  text: result.responseJSON.errorMsg, icon: 'error', showCancelButton: true, cancelButtonText: 'Dismiss', showConfirmButton: false,
				});
				return false;
			}
			
			swalWithBootstrapButtons.fire({
			  title: 'Successfully updated site',
			  text: 'Note: If you have assigned a domain/subdomain then please allow 1-2 minutes to propagate DNS changes.',
			  icon: 'success', confirmButtonText: 'Got it!', showConfirmButton: true, showCancelButton: false,
			  allowOutsideClick: false,
			}).then((result) => {
			  if (result.isConfirmed) {	location.reload();  }
			});
			
			
			
		});
		
		
		
	});
	

});
	
</script>



<div id="modalUpdateSite" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	

	<div class="modal-header">
		<h5 class="modal-title" id="injectTextTitleUpdateSite">Update site:</h5>
		<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
		
		
	<div id="" class="text-center my-2 modalLoadingDivWrapper">
		<button type="button" class="btn btn-success btn-sm" disabled><i class="fas fa-spinner fa-spin me-1"></i> Loading</button>
	</div>
	  
	  
	<form id="updateSiteForm" action="#" style="display:none;" autocomplete="off"> 
	 
		<div class="modal-body">

			<p><small>Note: if you don't edit/update anything and press <strong>"update site"</strong> button it will refresh <strong>"nginx"</strong> configuration.</small></p>
			
			<hr />
			
			
			<!-- subdomain field starts -->
			<div class="row">
				<label class="col-3 col-form-label" for="updateSiteDomain">Domain or subdomain</label>
				<div class="col-3">
					<input type="text" class="form-control" id="updateSiteDomain" name="updateSiteDomain">
				</div>
			</div>
			<!-- subdomain field ends -->

			<hr />
			
			<!-- WordPress version and php starts -->
			<div class="row mb-2">
				<label class="col-3 col-form-label" for="updateSiteWpVer"><i class="fab fa-wordpress"></i> WordPress version</label>
				<div class="col-3">
				
					<select class="form-select form-select-sm" id="updateSiteWpVer" name="updateSiteWpVer">
						<?php foreach(WASS1_WP_VERSIONS as $wpVer): ?>
							<option value="<?php echo $wpVer; ?>"><?php echo $wpVer; ?></option>
						<?php endforeach; ?>
					</select>
					
				</div>
				<label class="col-3 col-form-label" for="updateSitePhpVer"><i class="fab fa-php"></i> PHP version</label>
				<div class="col-3">
				
					<select class="form-select form-select-sm" id="updateSitePhpVer" name="updateSitePhpVer">
						<?php foreach(WASS1_PHP_VERSIONS as $phpVer): ?>
							<option value="<?php echo $phpVer; ?>"><?php echo $phpVer; ?></option>
						<?php endforeach; ?>
					</select>
					
				</div>
			</div>
			<!-- WordPress version and php ends  -->
			
			

			<!-- Restrictions starts -->
			<div class="row">
			
				<label class="col-3 col-form-label" for="updateSiteRestrictionGroupId">Restrictions Group-Id</label>
				<div class="col-3">
				
					<select class="form-select form-select-sm" id="updateSiteRestrictionGroupId" name="updateSiteRestrictionGroupId">
						<?php foreach($allRestrictionsGroupIds as $restrictionGroupId): ?>
							<option value="<?php echo $restrictionGroupId; ?>"><?php echo $restrictionGroupId; ?></option>
						<?php endforeach; ?>
					</select>
					
				</div>
				
				<div class="col-6">
					<p><span class="form-text text-muted">Apply different restrictions to this WP site. </span></p>
				</div>
				
			</div>
			<!-- Restrictions ends -->
			
			
			<hr />
			
			
			<!-- Password Protection starts -->
			<div class="row">
			
				<div class="col-12 mb-3"><strong>Add/Remove site password protection or change SFTP/mySQL passwords.</strong></div>
				
				<div class="col-6 row">
					<label class="col-4 col-form-label" for="updatePasswordProtectionUser">User:</label>
					<div id="updatePasswordProtectionUser" class="col-8 py-2 bg-light text-black">
						
					</div>
					<div class="form-text text-end">User will not be changed.</div>
				</div>
				<div class="col-6 row">
					<label class="col-4 col-form-label" for="updatePasswordProtection">Password:</label>
					<div class="col-8">
						<input type="text" class="form-control" id="updatePasswordProtection" name="updatePasswordProtection">
					</div>
					<div class="form-text text-end">Alphanumeric only and less than 25 characters.</div>
				</div>
				
				
				<div class="col-6 mt-3">
					<div class="form-check">
					  <input class="form-check-input" type="checkbox" value="true" name="updateRemovePasswordProtection" id="updateRemovePasswordProtection">
					  <label class="form-check-label" for="updateRemovePasswordProtection">
						<strong>want to remove site password?</strong>
					  </label>
					</div>
				</div>
				
				<div class="col-6 mt-3">
					<div class="form-check">
					  <input class="form-check-input" type="checkbox" value="true" name="updateChangeSftpMysqlPassword" id="updateChangeSftpMysqlPassword">
					  <label class="form-check-label" for="updateChangeSftpMysqlPassword">
						<strong>want to change SFTP/mySQL password?</strong>
					  </label>
					</div>
				</div>

				
				
				
			</div>
			<!-- Password Protectio ends -->
			

			
			
			
			<input type="hidden" id="updateSiteSelectedNodeId" name="updateSiteSelectedNodeId" value="" />
			<input type="hidden" id="updateSiteSelectedSiteId" name="updateSiteSelectedSiteId" value="" />

		</div>


		<div class="modal-footer">
			<button type="button" class="btn btn-danger me-3" data-bs-dismiss="modal">Close</button>
			<button id="updateSiteButtonSubmit" type="submit" class="btn btn-success">Update site</button>
		</div>



	</form>

</div>	  
</div>
</div>