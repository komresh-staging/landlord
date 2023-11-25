<div id="modalCreateNewSite" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	
	
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Create a new site</h5>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	  
	  
<form id="newSiteForm" action="#" autocomplete="off">  
<div class="modal-body">

	<p><small>Note: every new site will be created as a subdomain on <strong>"<?php echo ROOT_DOMAIN_NAME; ?>"</strong>. You will be able to map any domain once it's created successfully. </small></p>
	
	<hr />

		<div class="row">
		
			<label class="col-2 col-form-label" for="newSiteNode">Select node*</label>
			<div class="col-3">
				<select class="form-select form-select-sm" id="newSiteNode" name="newSiteNode" required>
					<option value="">select</option>
					<?php foreach($allActiveNetWorkNodes as $nodeDetails): ?>
						<option value="<?php echo $nodeDetails['node-id']; ?>">
							ctrl-<?php echo $nodeDetails['node-id']; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<label class="col-2 col-form-label" for="newSiteEmail">Client email*</label>
			<div class="col-4">
				<input  class="form-control form-select-sm" id="newSiteEmail" name="newSiteEmail" required type="email" placeholder="client@email.com" value="">
			</div>
		
		</div>
		
		
		<div class="row">
			<p><span class="badge bg-warning">Leave all the following values blank, It will lautomatically apply the defaults values.</span></p>
		</div>
	
	
	
	
	
	
	
		<!-- subdomain field starts -->
		<div class="row">
			<label class="col-2 col-form-label" for="newSiteSubdomain">Subdomain</label>
			<div class="col-4">
				<div class="input-group input-group-sm">
					<input type="text" class="form-control" id="newSiteSubdomain" name="newSiteSubdomain">
					<span class="input-group-text">.<?php echo ROOT_DOMAIN_NAME; ?></span>
				</div>
			</div>
			
			<div class="col-6">
				<p><span class="form-text text-muted">Leave blank to assign a subdomain using client email address.</span></p>
			</div>
		</div>
		<!-- subdomain field ends -->
	
	
	
	
		<!-- Clone site starts -->
		<hr />
		<div class="row mb-2">
		
			<label class="col-sm-2 col-form-label" for="newSiteCloneSourceNode">Clone from: </label>
			<div class="col-sm-2 pt-1">
			
				<select class="form-select form-select-sm" id="newSiteCloneSourceNode" name="newSiteCloneSourceNode">
					<option value="">select node</option>
					<?php foreach($allActiveNetWorkNodes as $nodeDetails): ?>
						
						<option value="<?php echo $nodeDetails['node-id']; ?>">
							ctrl-<?php echo $nodeDetails['node-id']; ?>
						</option>
					<?php endforeach; ?>
				</select>
				
			</div>
			<label class="col-sm-3 col-form-label" for="newSiteCloneSourceSiteId">
				Site domain to clone <i id="cloneSourceSiteIdSpinnerIcon" class="fas fa-spinner fa-spin ms-1" style="display:none;"></i>
			</label>
			<div class="col-sm-5 pt-1" id="newSiteCloneSourceSiteId_wrapper">
				<select class="form-control basicAutoComplete form-control-sm disabled" id="newSiteCloneSourceSiteId" name="newSiteCloneSourceSiteId" placeholder="first select source node to clone from" autocomplete="off" disabled="disabled"></select>
			</div>
			
		</div>
		<hr />
		<!-- Clone site ends -->
	
	
	
	
		
		
		
		
		
		<!-- WordPress version and php starts -->
		<div class="row mb-2">
			<label class="col-3 col-form-label" for="newSiteWpVer"><i class="fab fa-wordpress"></i> WordPress version</label>
			<div class="col-3">
			
				<select class="form-select form-select-sm" id="newSiteWpVer" name="newSiteWpVer">
					<?php foreach(WASS1_WP_VERSIONS as $wpVer): ?>
						<option value="<?php echo $wpVer; ?>"><?php echo $wpVer; ?></option>
					<?php endforeach; ?>
				</select>
				
			</div>
			<label class="col-3 col-form-label" for="newSitePhpVer"><i class="fab fa-php"></i> PHP version</label>
			<div class="col-3">
			
				<select class="form-select form-select-sm" id="newSitePhpVer" name="newSitePhpVer">
					<?php foreach(WASS1_PHP_VERSIONS as $phpVer): ?>
						<option value="<?php echo $phpVer; ?>"><?php echo $phpVer; ?></option>
					<?php endforeach; ?>
				</select>
				
			</div>
		</div>
		<!-- WordPress version and php ends  -->
		
		
		
		<!-- Restrictions starts -->
		<div class="row">
		
			<label class="col-3 col-form-label" for="newSiteRestrictionGroupId">Restrictions Group-Id</label>
			<div class="col-3">
			
				<select class="form-select form-select-sm" id="newSiteRestrictionGroupId" name="newSiteRestrictionGroupId">
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
		
		
		
		
		<div class="row">
		
			<label class="col-3 col-form-label" for="newSiteUniqueOrderId">Unique Order-Id</label>
			<div class="col-3">
				<input type="text" class="form-control" id="newSiteUniqueOrderId" name="newSiteUniqueOrderId" placeholder="optional">
			</div>
			
			<div class="col-6">
				<p><span class="form-text text-muted">Unique* order ID from your membership software.</span></p>
			</div>

			
		</div>
		
		
		<div class="row">
		
			<label class="col-3 col-form-label" for="newSiteSaasMemberId">Client Member-id</label>
			<div class="col-3">
				<input type="text" class="form-control" id="newSiteSaasMemberId" name="newSiteSaasMemberId" placeholder="optional">
			</div>
			
			<div class="col-6">
				<p><span class="form-text text-muted">Use to perform search by Member ID</span></p>
			</div>

			
		</div>
		
		

		
		<div id="injectFormBuilderWrapper" style="display:none;">
			<hr />
			<div class="row" id="dumpInjectHtmlHere"></div>
		</div>
		

		
		
 
</div>


<div class="modal-footer">
	<button type="button" class="btn btn-danger me-3" data-bs-dismiss="modal">Close</button>
	<button id="newSiteButtonSubmit" type="submit" class="btn btn-success">Create new site</button>
</div>

</form>
	  
    </div>
  </div>
</div>