<?php
if(!defined('DIRECTACCESS'))   die('Direct access not permitted'); //add this to every file included.


$platFormBranding = getPlatFormBranding();

$getVarsFromDb = getMainWpControllerDetails( array('GIT_REPO_GROUP_BASE_NAME', 'DISCORD_CHANNEL_INVITE_CODE') );

$discordChannelInviteCode = $getVarsFromDb['DISCORD_CHANNEL_INVITE_CODE'];
$gitRepoGroupBaseName = explode( '-', $getVarsFromDb['GIT_REPO_GROUP_BASE_NAME'] );
$gitRepoGroupBaseName = $gitRepoGroupBaseName[1];



?>



<nav class="navbar navbar-expand-lg navbar-light px-3 justify-content-between" style="background-color:<?php echo $platFormBranding['PLATFORM_BRAND_BACKGROUND_COLOR']; ?>">

	
	<a class="navbar-brand" href="/index.php">
		<img src="<?php echo $platFormBranding['PLATFORM_BRAND_LOGO_URL']?>" class="d-inline-block me-1" width="200" />
		<small>(CTRL-1)</small>
	</a>
	
	
	
	<button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	
	
	
	

	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<ul class="navbar-nav mr-auto">
		
			<li class="nav-item">
				<a class="btn btn-sm btn-outline-primary me-1 <?php echo ( $currentPage == 'view-options' ) ? 'active':''; ?>" href="/index.php?task=view-options" target="_blank">Options</a>
			</li>
		
			<li class="nav-item">
				<a class="btn btn-sm btn-outline-primary me-1 <?php echo ( $currentPage == 'view-restrictions' ) ? 'active':''; ?>" href="/index.php?task=view-restrictions" target="_blank">Restrictions</a>
			</li>
			

			
			
		</ul>
		

		<form id="actionSearchNetwork" class="form">
			<div class="input-group">
				<select id="searchType" class="form-select" required="required">
					<option value="domain" selected>Domain</option>
					<option value="client-email">Client email</option>
					<option value="unique-order-id">Order ID</option>
					<option value="site-id">Site ID</option>
					<option value="client-saas-member-id">SaaS member ID</option>
				</select>
				<input id="searchQuery" class="input-group form-control form-control-sm" type="search" placeholder="Query" required="required">
				<button class="btn btn-primary" type="submit" id="searchButton">Search</button>
			</div>
		</form>


	</div>
	
	
	<form class="form-inline">
		
		<a class="btn btn-sm btn-outline-primary" href="<?php echo $discordChannelInviteCode; ?>" target="_blank"><i class="fab fa-discord"></i></small> Discord <small><i class="ms-1 fas fa-external-link-alt"></i></small></a>
		<a class="btn btn-sm btn-outline-primary" href="https://waas1<?php echo $gitRepoGroupBaseName; ?>.loggly.com/" target="_blank">Access logs <small><i class="ms-1 fas fa-external-link-alt"></i></small></a>
		<a class="btn btn-sm btn-outline-primary" href="https://app.netdata.cloud/" target="_blank">Netdata metrics <small><i class="ms-1 fas fa-external-link-alt"></i></small></a>
		<a class="btn btn-sm btn-outline-primary" href="https://documenter.getpostman.com/view/15884917/UVRAJ7MT/" target="_blank">API docs <small><i class="ms-1 fas fa-external-link-alt"></i></small></a>
		

		<?php if( THIS_ENV_IS_LOCAL ): ?>
		<a class="btn btn-sm btn-outline-primary" href="/index.php?task=view-init-setup" target="_blank">Init setup <small><i class="ms-1 fas fa-external-link-alt"></i></small></a>
		<?php endif; ?>

	</form>
	
	
	
	
	

</nav>


