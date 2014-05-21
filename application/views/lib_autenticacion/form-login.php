<?php
$vcFormName = antibotHacerLlave();
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<!--  <form id="form-login-access" method="post" enctype="application/x-www-form-urlencoded" action="aut/autenticar" target="srv-resp">-->

<?php
  
?>
<div id="srv-resp">
    <?= $vcMsjSrv; ?>
    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</div>
