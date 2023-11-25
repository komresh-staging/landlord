<?php

if(!defined('DIRECTACCESS'))   die('Direct access not permitted'); //add this to every file included.
header('Content-Type:text/html; charset=ISO-8859-15'); //needed for html pages

require_once( 'blocks/header-1.php' );



$db = requireDb( true );
$db->select( '*', 'sites', '', '', 'id DESC' );
$allSitesOnNetwork = $db->fetch_assoc_all();

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Low Level Control Panel - <?php echo THIS_CONTROLLER_TAG; ?></title>

  </head>



  <body style="padding:1%;">


    <h1>Low Level Control Panel - <?php echo THIS_CONTROLLER_TAG; ?> - <small><?php echo ROOT_DOMAIN_NAME; ?></small></h1>
	
	
	
	
	<hr />
	<h3> 1) Add a new site to network: </h3>
	<hr />
	
	<form action="index.php" target="_blank" method="POST">
		<input type="text" value="" name="subdomain" placeholder="sub domain" />
		
		<label>WordPress Version</label>
		<select name="wp_version">
			<?php foreach( WASS1_WP_VERSIONS as $version): ?>
				<option value="<?php echo $version; ?>"><?php echo $version; ?></option>
			<?php endforeach; ?>
		</select>
		
		<label>PHP Version</label>
		<select name="php_version">
			<?php foreach( WASS1_PHP_VERSIONS as $version): ?>
				<option value="<?php echo $version; ?>"><?php echo $version; ?></option>
			<?php endforeach; ?>
		</select>
		
		<br />
		<br />
		
		<input type="text" value="" name="site-title" placeholder="Title: (New Awesome Site)" size="70" />
		
		<br />
		<br />
		
		<label>
		Admin User
		<input type="text" value="" name="admin-user" placeholder="Admin user" />
		</label>
		<br />
		
		<label>
		Admin pass
		<input type="password" value="" name="admin-pass" placeholder="Admin Password" />
		</label>
		<br />
		
		<label>
		Admin Email
		<input type="text" value="" name="admin-email" placeholder="Admin Email" />
		</label>
		
		<br />
		<br />
		
		<label>
		Oerwrite site setup? (use only to overrite old site file structure. Use carefully - This will not change sub domain or reinstall DB)
		<input type="number" value="" name="site-id" placeholder="site id" autocomplete="off" />
		</label>
		
		
		<br />
		<br />
		
    	<input class="btn btn-success" type="submit" name="task" value="Add_A_Blank_Site" />
    </form>
	
	
	
	
	<div class="clear-both"></div>
	<hr />
	<hr />
	<hr />
	<hr />
	
	
	
	
	
	
	
	<div class="clear-both"></div>
	
	<h3> 2) Individual Site Level Tasks: </h3>
	
	
	
	<form id="networkSites" action="index.php" target="_blank">
	
		
		<label for="selectASite"><strong>Select a site</strong></label>
		<select id="selectASite" name="site-id">
			<option value="n/a">Select Site</option>
			<?php foreach( $allSitesOnNetwork as $site): ?>
			
				<option value="<?php echo $site['site_id']; ?>">
				
				Site ID: <?php echo $site['site_id']; ?> --> <?php echo $site['site_domain']; ?>
				
				</option>
			<?php endforeach; ?>
			
		</select>
		
		<div class="clear-both" style="margin-bottom:10px;"></div>
		
		<label>Map Domain/Subdomain</label>
		<input type="text" value="" name="mapdomain" placeholder="map domain/subdomain" />
		
		<label>WordPress Version</label>
		<select name="wp_version">
			<?php foreach( WASS1_WP_VERSIONS as $version): ?>
				<option value="<?php echo $version; ?>"><?php echo $version; ?></option>
			<?php endforeach; ?>
		</select>
		
		<label>PHP Version</label>
		<select name="php_version">
			<?php foreach( WASS1_PHP_VERSIONS as $version): ?>
				<option value="<?php echo $version; ?>"><?php echo $version; ?></option>
			<?php endforeach; ?>
		</select>
		
		<div class="clear-both" style="margin-bottom:10px;"></div>
		
		<input class="btn btn-warning" type="submit" name="task" value="Apply_Site_Changes" />
		
		<input class="btn btn-info" type="submit" name="task" value="Add_All_Plugins_AND_Themes" />
		
		<input class="btn btn-info" type="submit" name="task" value="Activate_Plugins" />
		
		<input class="btn btn-info" type="submit" name="task" value="Add_Users_To_Site" />
		
		
		
		<br />
		<br />
		<input class="btn btn-info" type="submit" name="task" value="view_php_error_log" />
		<br />
		<br />
		<br />
		<br />
		<input id="deleteSite" class="btn btn-danger" type="submit" name="task" value="Delete_Site_Confirm" />
		

		
		
	</form>
	
	<div class="clear-both"></div>
	


    <hr />
	<hr />
	
	
	
	
	
	
	<div class="clear-both"></div>
	
	<h3> 3) Network Level Tasks: </h3>
	
	
	<form action="index.php" target="_blank">
    	<input class="btn btn-danger" type="submit" name="task" value="Add_All_Plugins_AND_Themes" />
		
		<input class="btn btn-danger" type="submit" name="task" value="Process_Cron" />
		
		<input class="btn btn-danger" type="submit" name="task" value="Auto_Mainwp" />
    </form>
	
	
	

	
	<div class="clear-both"></div>
	
	
	
	<hr />
	<hr />
	
	
	
		
	<div class="clear-both"></div>
	
	<h3> 4) Controller level task: </h3>
	
	
	<form action="index.php" target="_blank">
    	<input class="btn btn-warning" type="submit" name="task" value="Pull_All_Git_Repos" />
		
		<input class="btn btn-warning" type="submit" name="task" value="Reload_All_Services" />
    </form>
	
	
	
	

	
	<div class="clear-both"></div>


	
	
	








	
	
	
	
	










    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
    $(document).ready(function(){
		
	
      $("input.cloneText1").on("input change", function(e) {
        $("input.cloneText1").val(this.value);
      });

    });
    </script>
  </body>
</html>
