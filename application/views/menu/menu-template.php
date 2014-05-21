<?php
 /**
  * menu-template.php
  *
  * @author Marcelo Gutierrez 
  * @version $Id$
  * @copyright 
  * @package default
  */
 
 /**
  * Crea el menu (mega menu) del segun el array de modulos $rsItemsMenu
  */

$aRegs = (!empty($rsItemsMenu))? $rsItemsMenu: array();
$n = sizeof($aRegs)-1;
$inIters = 0;
$inProfAct = 1;
$i=0;
$sXhtml = '';
$inProf = 0;
while($i<=$n) {
	$sItem = '';
	
	$inProfSig = ($i<$n)? (($aRegs[$i+1]["inProf"] <= 3) ? ($aRegs[$i+1]["inProf"]): 3): 3;
	$inProf = ($aRegs[$i]["inProf"] <= 3) ? ($aRegs[$i]["inProf"]): 3;
	
	$href = (!empty($aRegs[$i]['vcModUrl']))?' href="'.$aRegs[$i]['vcModUrl'].'"': '';
	if($inProf == 1) {
		$sItem = '<li class="itemSup"><a '.$href.' class="nav-button" style="text-transform: uppercase;" >'.$aRegs[$i]['vcModNombre'].'</a>';
	} else {
		if($href=='') {
			$sItem = '</ul><ul><li><h3>'.$aRegs[$i]['vcModNombre'].'</h3></li>'; 
		} else {
			$sItem = '<li><a '.$href.'>'.$aRegs[$i]['vcModNombre'].'</a></li>';
		}
	}

	if($inProf < $inProfSig) {
		if ($inProfSig==2) {
			$sItem.='<div class="sub"><ul>';
		}
	} elseif ($inProf > $inProfSig) {
		if($inProfSig==1){
			$sItem.='</li></ul></div>';
		}
	} elseif($inProf == $inProfSig && $inProf == 1) {
		$sItem.='</li>';
	}
	$sXhtml .=  $sItem;
	$i++;
}

if($sXhtml!='') {
	$sXhtml = '<nav><ul id="topnav">'.$sXhtml.'</ul></nav>
  <div class="clearfloat">&nbsp;</div>';
} else {
	
}
echo str_replace("'", "", $sXhtml);
// EOF menu-template.php