<?php
if(!defined('DIRECTACCESS'))   die('Direct access not permitted'); //add this to every file included.


if( !THIS_ENV_IS_LOCAL ){
	$bustCache = $currentDate = date( 'ymd', time() );
}else{
	$bustCache = time();
}

$bustCache = $bustCache . '-v1.26';

?>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $currentTitle; ?></title>



<?php //css ?>
<?php //<link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> ?>
<link href="/public/css/bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<link href="/public/css/common.css?v=<?php echo $bustCache; ?>" rel="stylesheet">

<?php
//load css specific for current page view
if( file_exists( HOME_DIR_PATH.'public/css/'.$currentPage.'.css') ){
	echo '<link href="/public/css/'.$currentPage.'.css?v='.$bustCache.'" rel="stylesheet">';
}
?>


<?php //js ?>
<?php if ( isset($_SESSION['loggedin']) ) : ?>
<script>

	const API_KEY 	= '<?php echo $_SESSION['API_KEY']; ?>';
	const API_VERSION = '/api-v1/'
	const ROOT_DOMAIN_NAME 	= '<?php echo ROOT_DOMAIN_NAME; ?>';
	const PRIMARY_CONTROLLER_DOMAIN_NAME  = '<?php echo PRIMARY_CONTROLLER_DOMAIN_NAME; ?>';
	
	<?php if( isset($otpVars) ): ?>
	const OTP_KEY = '<?php echo $otpVars['otp-key']; ?>';
	const OTP_TOKEN = '<?php echo $otpVars['otp-token']; ?>';
	<?php endif; ?>
	
</script>
<?php endif; ?>





<script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/javascript/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11.1.7/dist/sweetalert2.all.min.js"></script>
<script src="//cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

<script>
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success m-1',
    cancelButton: 'btn btn-danger m-1'
  },
  buttonsStyling: false
});
</script>


<script src="/public/javascript/common.js?v=<?php echo $bustCache; ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js" integrity="sha512-8pbzenDolL1l5OPSsoURCx9TEdMFTaeFipASVrMYKhuYtly+k3tcsQYliOEKTmuB1t7yuzAiVo+yd7SJz+ijFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<?php
//load js specific for current page view
if( file_exists( HOME_DIR_PATH.'public/javascript/'.$currentPage.'.js') ){
	echo '<script src="/public/javascript/'.$currentPage.'.js?v='.$bustCache.'"></script>';
}