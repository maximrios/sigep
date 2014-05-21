<?php
	$vcRedirSrc = (!empty($vcRedirSrc))? $vcRedirSrc: '';
	$vcRedirAction = (!empty($vcRedirAction))? $vcRedirAction: '';
?>
<form id="login-redirect" method="post" enctype="application/x-www-form-urlencoded" action="<?= $vcRedirAction; ?>">
	<input type="hidden" name="vcRedirSrc" id="redir-src" value="<?= $vcRedirSrc; ?>"/>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$('#login-redirect').submit();
	});
</script>