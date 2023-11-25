<?php

if(!defined('DIRECTACCESS'))   die('Direct access not permitted'); //add this to every file included.
header('Content-Type:text/html; charset=ISO-8859-15'); //needed for html pages

require_once( 'blocks/header-1.php' );


$currentPage = 'view-options';
$currentTitle = 'Primary Controller - Options.';


$getOptions = getMainWpControllerDetails( array('API_KEY', 'SUPERDUPER_PASS', 'SUPERDUPER_EMAIL', 'PLATFORM_WP_VERSIONS', 'PLATFORM_PHP_VERSIONS') );


$subTask  = checkRequiredVar( 'subTask' );
if( $subTask == 'updateOptions' ){ //substak updateGroupOptions start
	
	$msgType = 'danger';
	$msgText = urlencode( 'Something went wrong!' );
	$redirectLink = '/index.php?task=view-options&msgType='.$msgType;

	$optionName  = checkRequiredVar( 'option_name' );
	
	
	
	if( !is_array($optionName) ){
		$msgText = urlencode( 'Could not update option/value. Option Name is not array!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
	
	
	$optionValue  = checkRequiredVar( 'option_value' );
	if( !is_array($optionValue) ){
		$msgText = urlencode( 'Could not update option/value. Option Value is not array!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
		
	
	$db = requireDb( true );
	foreach( $optionName as $key=>$name ){
		
		$db->update(
			'options',
			array(
				'value'	=>  $optionValue[$key],
			),
			'name = ?',
			array( $name )
		);

	}

	

	//302 Found, i.e. a temporary redirect 
	$msgType = 'success';
	$msgText = urlencode( 'Successfully updated option values' );
	$redirectLink = '/login.php';
	header('Location: '.$redirectLink, true, 302);
	exit();
	
}//substak updateGroupOptions end


?>


<!doctype html>
<html lang="en">

	<head>
		<?php require_once( 'blocks/header-10.php' ); ?>
	</head>
	<body>
	

	<?php require_once( 'blocks/main-menu.php' ); ?>
	

	
	
	<main class="container mt-5">
	
	
	<?php if( isset($_GET['msgType']) ): ?>
		<div class="alert alert-<?php echo $_GET['msgType']; ?> ">
		  <?php echo $_GET['msgText']; ?>
		</div>
	<?php endif; ?>
	
	
	<p class="text-start badge bg-warning">
		Note: Please only update those values that you know exactly what they will update! <br /> Most of the time you just need to update the superduper password using "SUPERDUPER_PASS" option name.
	</p>
	
	<hr />


	<div class="bg-white p-1 pt-2 mb-3 rounded">

		
		<form id="updateOptionsForm" method="POST">
		<table id="nodeList" class="table table-striped table-hover">
		  <thead class="table-primary">
			<tr>
			  <th scope="col"><span class="badge bg-light">#</span></th>
			  <th scope="col" style="width:45%;">Option Name</th>
			  <th scope="col">Option Value</th>
			</tr>
		  </thead>
		  
		  <tbody>
		  
		    
			<?php 
				$counter = 1;
				foreach( $getOptions as $key=>$option ): 
			?>
			<tr>
				<td><?php echo $counter; ?></td>

				<td>
					<?php echo $key; ?>
					<input type="hidden" name="option_name[]" value="<?php echo $key; ?>" />
				</td>
				<td>
				
					<?php if( $key == 'API_KEY' ): ?>
						<input id="updatePassword" required="required" class="form-control input-sm" type="password" name="option_value[]" value="<?php echo $option; ?>" />
					<?php elseif( $key == 'SUPERDUPER_PASS' ): ?>
						<input id="updatePassword" required="required" class="form-control input-sm" type="password" name="option_value[]" value="<?php echo $option; ?>" />
					<?php else: ?>
						<input required="required" class="form-control input-sm" type="text" name="option_value[]" value="<?php echo $option; ?>" />
					<?php endif; ?>
				</td>
				
			</tr>
			<?php endforeach; ?>
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2" class="text-end">
					<button type="submit" class="btn btn-primary col-12 mt-3"><i class="fas fa-trash me-2"></i> Update Options</button>
				</td>
			</tr>
			
			
			
		  </tbody>
		  
			
			
		</table>

			<input type="hidden" name="task" value="view-options" />
			<input type="hidden" name="subTask" value="updateOptions" />
			
		</form>

	</div>
	
	</main>
	
	
	
	

	
	
	
	

	









<footer class="footer">
	<div class="container text-end">
		<span class="text-muted">Powered by <a href="https://waas1.com/" target="_blank">WaaS1.com</a></span>
	</div>
</footer>



	</body>
</html>