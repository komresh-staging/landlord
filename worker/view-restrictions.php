<?php

if(!defined('DIRECTACCESS'))   die('Direct access not permitted'); //add this to every file included.
header('Content-Type:text/html; charset=ISO-8859-15'); //needed for html pages

require_once( 'blocks/header-1.php' );


$currentPage = 'view-restrictions';
$currentTitle = 'Primary Controller - Restrictions.';


$viewGroupID  = checkRequiredVar( 'view-group-id' );
if( !$viewGroupID ){
	$viewGroupID = '1';
}

$allRestrictionsGroupIds = getRestrictionsGroupIDs();
sort( $allRestrictionsGroupIds, SORT_NUMERIC ); //sorting is important here
$allRestrictions = getRestrictionsGroup( $viewGroupID );



$subTask  = checkRequiredVar( 'subTask' );
if( $subTask == 'addNewRestrictionGroup' ){ //substak addNewRestrictionGroup start
	
	$groupIdToCreate = 1;
	foreach( $allRestrictionsGroupIds as $groupId ){
		if ($groupIdToCreate != $groupId){
			break;
		}
		$groupIdToCreate++;
	}
	
	
	$db = requireDb( true );
	foreach( $allRestrictions as $key=>$restriction ){
		
		$db->insert(
			'restriction_groups',
			array(
				'group_name' 		=> 'group_'.$groupIdToCreate,
				'restriction_name' 	=> $restriction['restriction_name'],
				'restriction_value' => $restriction['restriction_value'],
				'description' 		=> $restriction['description'],
			)
		);
		
	}
	
	
	//302 Found, i.e. a temporary redirect 
	$msgType = 'success';
	$msgText = urlencode( 'Successfully added new Restrictions Group ID: '.$groupIdToCreate );
	$redirectLink = '/index.php?task=view-restrictions&view-group-id='.$groupIdToCreate.'&msgType='.$msgType.'&msgText='.$msgText;
	header('Location: '.$redirectLink, true, 302);
	exit();
}//substak addNewRestrictionGroup end









if( $subTask == 'addNewRestrictionOptionValue' ){ //substak addNewRestrictionOptionValue start
	
	$msgType = 'danger';
	$msgText = urlencode( 'Something went wrong!' );
	$redirectLink = '/index.php?task=view-restrictions&view-group-id='.$viewGroupID.'&msgType='.$msgType;
	
	$restrictionName  = checkRequiredVar( 'restriction_name' );
	if( !$restrictionName ){
		$msgText = urlencode( 'Could not add restriction option/value. Restriction Name is empty!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
	
	$restrictionValue  = checkRequiredVar( 'restriction_value' );
	if( !$restrictionValue ){
		$msgText = urlencode( 'Could not add restriction option/value. Restriction Value is empty!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
	
	$restrictionDescription  = checkRequiredVar( 'description' );
	if( !$restrictionDescription ){
		$msgText = urlencode( 'Could not add restriction option/value. Description is empty!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
	

	
	$db = requireDb( true );
	foreach( $allRestrictionsGroupIds as $key=>$groupId ){
		
		$db->insert(
			'restriction_groups',
			array(
				'group_name' 		=> 'group_'.$groupId,
				'restriction_name' 	=> $restrictionName,
				'restriction_value' => $restrictionValue,
				'description' 		=> $restrictionDescription,
			)
		);
		
	}
	

	//302 Found, i.e. a temporary redirect 
	$msgType = 'success';
	$msgText = urlencode( 'Successfully added new Group Option/Value.' );
	$redirectLink = '/index.php?task=view-restrictions&view-group-id='.$viewGroupID.'&msgType='.$msgType.'&msgText='.$msgText;
	header('Location: '.$redirectLink, true, 302);
	exit();
	
}//substak addNewRestrictionOptionValue end







if( $subTask == 'updateGroupOptions' ){ //substak updateGroupOptions start
	
	$msgType = 'danger';
	$msgText = urlencode( 'Something went wrong!' );
	$redirectLink = '/index.php?task=view-restrictions&view-group-id='.$viewGroupID.'&msgType='.$msgType;

	$restrictionName  = checkRequiredVar( 'restriction_name' );
	
	if( !is_array($restrictionName) ){
		$msgText = urlencode( 'Could not update group option/value. Restriction Name is not array!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
	
	
	$restrictionValue  = checkRequiredVar( 'restriction_value' );
	if( !is_array($restrictionValue) ){
		$msgText = urlencode( 'Could not update group option/value. Restriction Value is not array!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
	
	$restrictionDescription  = checkRequiredVar( 'description' );
	if( !is_array($restrictionDescription) ){
		$msgText = urlencode( 'Could not update group option/value. Description is not array!' );
		$redirectLink .= '&msgText='.$msgText;
		header('Location: '.$redirectLink, true, 302);
		exit();
	}
	

	
	$db = requireDb( true );

	foreach( $restrictionName as $key=>$name ){
		
		$db->update(
			'restriction_groups',
			array(
				'restriction_value'	=>  $restrictionValue[$key],
				'description'		=>  $restrictionDescription[$key],
			),
			'group_name = ? AND restriction_name = ?',
			array( 'group_'.$viewGroupID, $name )
		);

	}

	

	//302 Found, i.e. a temporary redirect 
	$msgType = 'success';
	$msgText = urlencode( 'Successfully updated group Values' );
	$redirectLink = '/index.php?task=view-restrictions&view-group-id='.$viewGroupID.'&msgType='.$msgType.'&msgText='.$msgText;
	header('Location: '.$redirectLink, true, 302);
	exit();
	
}//substak updateGroupOptions end







if( $subTask == 'removeRestrictionOption' ){ //substak removeRestrictionOption start


	$ajaxData['status'] = false;

	
	$restrictionName  = checkRequiredVar( 'restriction_name' );
	if( !$restrictionName ){
		$ajaxData['msg'] = 'Could not remvoe restriction option/value. Restriction Name is empty!';
		header( 'HTTP/1.1 403 Forbidden', true, 403 );
		echo json_encode( $ajaxData );
		exit; //do not process anything
	}
	
	
	$db = requireDb( true );
	$db->delete( 'restriction_groups', 'restriction_name = ?', array($restrictionName) );
	
	
	$ajaxData['status'] = true;
	$ajaxData['errorMsg'] = 'Successfully removed Option/Value: '.$restrictionName;
	echo json_encode($ajaxData);
	exit; //do not process anything
		
	
}//substak removeRestrictionOption end


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
	
	
	
	<div class="row mb-3">
	  <div class="col-6" style="border-right:1px solid #ccc;">
	  
					<p>Select to view restrictions or add new restrictions group. Adding a new group will have default values of currently viewed group.</p>
					<div class="row">
						
						<form class="col-7 row" action="/index.php">
								<div class="col">

									<select required="required" id="viewGroupId" class="form-select" name="view-group-id">
										<?php foreach($allRestrictionsGroupIds as $id): ?>
										<option 
										<?php if( $id == $viewGroupID ){ echo 'selected="selected"'; }?> 
										value="<?php echo $id; ?>">Group ID: <?php echo $id; ?>
										</option>
										<?php endforeach; ?>
									</select>

								</div>
								<div class="col">
									<button type="submit" class="btn btn-warning">View restrictions</button>
								</div>
							<input type="hidden" name="task" value="view-restrictions" />
						</form>
						
						<form action="/index.php" class="col-5">
							<button type="submit" class="btn btn-primary">Add new Restriction Group</button>
							<input type="hidden" name="task" value="view-restrictions" />
							<input type="hidden" name="view-group-id" value="<?php echo $viewGroupID; ?>" />
							<input type="hidden" name="subTask" value="addNewRestrictionGroup" />
						</form>
						
					</div>
										
	  </div>
	  <div class="col-6 ps-5">
			<p>Add new restriction name/value and description.</p>
			<form class="row" action="/index.php">
					<div class="col-4">
						<input required="required" class="form-control input-sm" type="text" name="restriction_name" value="" placeholder="Restriction Name" />
					</div>
					<div class="col-4">
						<input required="required" class="form-control input-sm" type="text" name="restriction_value" value="" placeholder="Restriction Value" />
					</div>
					<div class="col-4 mb-3">
						<input required="required" class="form-control input-sm" type="text" name="description" value="" placeholder="Description" />
					</div>
					
					<div class="col-12 text-end">
						<button type="submit" class="btn btn-warning">Add</button>
					</div>
			    <input type="hidden" name="view-group-id" value="<?php echo $viewGroupID; ?>" />
				<input type="hidden" name="task" value="view-restrictions" />
				<input type="hidden" name="subTask" value="addNewRestrictionOptionValue" />
			</form>
	  </div> 
	</div>
	
	<hr />

	<div class="bg-white p-1 pt-2 mb-3 rounded">

		
		<form method="POST">
		<table id="nodeList" class="table table-striped table-hover">
		  <thead class="table-primary">
			<tr>
			  <th scope="col"><span class="badge bg-light">#</span></th>
			  <th scope="col"><span class="badge bg-light">Group ID</span></th>
			  <th scope="col" style="width:45%;">Restriction Name</th>
			  <th scope="col">Restriction Value</th>
			  <th scope="col">Description</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead>
		  
		  <tbody>
		  
		    
			<?php foreach( $allRestrictions as $key=>$restriction ): ?>
			<tr>
				<td><?php echo $key = $key+1; ?></td>
				<td> Group <span class="badge bg-warning"><?php echo $viewGroupID; ?> </span></td>
				<td>
					<?php echo $restriction['restriction_name']; ?>
					<input type="hidden" name="restriction_name[]" value="<?php echo $restriction['restriction_name']; ?>" />
				</td>
				<td><input required="required" class="form-control input-sm" type="text" name="restriction_value[]" value="<?php echo $restriction['restriction_value']; ?>" /></td>
				<td><input required="required" class="form-control input-sm" type="text" name="description[]" value="<?php echo $restriction['description']; ?>" /></td>
				
				<td>
					<a class="btn btn-link px-0 removeRestrictionOption" data-restrictionname="<?php echo $restriction['restriction_name']; ?>">
						<i class="fas fa-trash"></i> Remove
					</a>
					
					
					<?php /*
					<form>
						<button type="submit" class="btn btn-link px-0"><i class="fas fa-trash"></i> Remove</button>
						<input type="hidden" name="subTask" value="removeRestrictionOption" />
						<input type="hidden" name="task" value="view-restrictions" />
						<input type="hidden" name="view-group-id" value="<?php echo $viewGroupID; ?>" />
						<input type="hidden" name="restriction_name" value="<?php echo $restriction['restriction_name']; ?>" />
					</form>
					*/ ?>
					
				</td>
				
			</tr>
			<?php endforeach; ?>
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2" class="text-end">
					<button type="submit" class="btn btn-primary col-12 mt-3"><i class="fas fa-trash me-2"></i> Update Restriction Group</button>
				</td>
			</tr>
			
			
			
		  </tbody>
		  
			
			
		</table>

			<input type="hidden" name="task" value="view-restrictions" />
			<input type="hidden" name="subTask" value="updateGroupOptions" />
			<input type="hidden" name="view-group-id" value="<?php echo $viewGroupID; ?>" />
			
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