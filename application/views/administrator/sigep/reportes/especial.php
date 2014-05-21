<?php
	$ci = &get_instance();
	$ci->load->library('hits/pdf');
	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$ci->pdf->SetFont('helvetica', 'UB', 12);
	$ci->pdf->AddPage();
	//$ci->pdf->SetLeftMargin(30);
	
	$ci->pdf->SetFillColor(210, 210, 210);
	$ci->pdf->Cell(190, 10, 'SOLICITUD DE LICENCIA ESPECIAL', 0, 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(190, 8, 'SALTA, '.date('d').' / '.date('m').' / '.date('Y').' ', 0, 1, 'R', FALSE);
	$ci->pdf->Ln(8);
	$ci->pdf->SetFont('helvetica', '', 12);
	$ci->pdf->Multicell(190, 12, 'El / La que suscribe, '.$agente['nombreCompletoPersona'].'............, solicita la concesión de  ................... (.................) días hábiles de Licencia por ......................................................................');
	$ci->pdf->Multicell(190, 12, 'A partir del día ....... / ....... / 20 ......., de acuerdo a lo establecido en el Artículo ................................... Inciso ......... ) del Decreto N° 4.118/97', 0, 'L');
	$ci->pdf->Ln(24);
	$ci->pdf->Cell(70, 1, '....................................................', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(50, 1, '', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(70, 1, '....................................................', 0, 1, 'C', FALSE);
	$ci->pdf->Cell(70, 6, 'V° B° del Jefe', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(50, 6, '', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(70, 6, 'Firma del solicitante', 0, 1, 'C', FALSE);
	$ci->pdf->Ln(8);
	$ci->pdf->Line(10, 120, 200, 120);
	$ci->pdf->SetFillColor(240, 240, 240);
	$band=TRUE;
	$ci->pdf->SetFont('helvetica', 'UB', 12);
	$ci->pdf->Cell(190, 10, 'INFORME DE RECURSOS HUMANOS', 0, 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 12);
	$ci->pdf->Multicell(190, 12, 'La licencia solicitada por '.$agente['nombreCompletoPersona'].'. Tiene un encuadre legal en el Decreto N° 4.118/97, en su Artículo .....° Inc ----), corresponde otorgarle ...........( ........ ) días hábiles de licencia ........................................', 0, 'J');
	$ci->pdf->Cell(190, 16, 'DIAS OTORGADOS EN EL AÑO ......... DE .........', 0, 1, 'L', FALSE);
	$ci->pdf->Multicell(190, 12, 'OBSERVACIONES .............................................................................................................................');
	$ci->pdf->Ln(10);
	$ci->pdf->Cell(190, 16, 'SALTA, ....... / ....... / .......', 0, 1, 'L', FALSE);
	$ci->pdf->Line(10, 210, 200, 210);
	$ci->pdf->Ln(12);
	$ci->pdf->Cell(190, 8, 'SALTA, ....... / ....... / ....... ', 0, 1, 'R', FALSE);
	$ci->pdf->SetFont('helvetica', 'UB', 12);
	$ci->pdf->Cell(190, 12, 'DISPOSICION N° .................', 0, 1, 'L', FALSE);
	$ci->pdf->SetFont('helvetica', 'B', 12);
	$ci->pdf->Cell(17, 8, 'VISTO, ', 0, 0, 'L', FALSE);
	$ci->pdf->SetFont('helvetica', '', 12);
	$ci->pdf->Cell(20, 8, 'la presente solicitud, y ', 0, 1, 'L', FALSE);
	$ci->pdf->Multicell(190, 12, '<b>CONSIDERANDO</b> el Régimen de Licencias, Justificaciones y Franquicias aprobado por el Decreto N° 4.118/97,', 0, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Multicell(190, 12, 'Que la presente se encuadra en lo dispuesto por el Artículo 23° de la Ley N° 7.103; in. b) y Decreto N° 1086/01 - Anexo IV - Funciones apartado d).');
	$ci->pdf->Multicell(190, 12, 'Por ello;');
	$ci->pdf->Cell(190, 8, 'EL SINDICO GENERAL DE LA PROVINCIA', 0, 1, 'C', FALSE);
	$ci->pdf->Cell(190, 8, 'DISPONE:', 0, 1, 'C', FALSE);
	if($agente['idSexo'] == 1) {
		$tipo = 'al Sr.';
	}
	elseif($agente['idSexo'] == 2 && $agente['idEcivil'] == 1) {
		$tipo = 'a la Srta.';	
	}
	else {
		$tipo = 'a la Sra.';
	}
	$ci->pdf->Multicell(190, 12, '<b>Articulo 1°.-</b> Conceder '.$tipo.' '.$agente['nombreCompletoPersona'].'(.......) días hábiles de Licencia ........................................................................, con encuadre legal en el Artículo .......° Inciso .......) del Decreto N° 4.118/97, a partir del día ...... / ....... / ....... , debiendo reintegrarse a sus funciones el día ....... / ....... / ....... -', 0, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Multicell(190, 12, '<b>Articulo 2°.-</b> Registrar, notificar y archivar.', 0, 'L', false, 1, '', '', true, 0, true);
	/*foreach ($agentes as $agente) {
		($band==TRUE)? $band=FALSE:$band=TRUE;
		$ci->pdf->Cell(20, 8, $agente['dniPersona'], 1, 0, 'C', $band);	
		$ci->pdf->Cell(90, 8, $agente['nombreCompletoPersona'], 1, 0, 'C', $band);	
		$ci->pdf->Cell(50, 8, $agente['denominacionCargo'], 1, 1, 'C', $band);	
	}*/
	/*$ci->pdf->Cell(160, 6, 'SALTA, '.$fecha, 0, 1, 'R', FALSE);
	$ci->pdf->Cell(160, 6, 'RESOLUCION N° '.$fecha, 0, 1, 'L', FALSE);
	$ci->pdf->Cell(160, 6, 'SINDICATURA GENERAL DE LA PROVINCIA '.$fecha, 0, 1, 'L', FALSE);*/
	$comentario="Con <b>autopadding</b> false no se aplica el espacio previsto ni en la parte superior ni en la inferior de la celda. Si se hace por la izquierda y la derecha\n\n";
	//$ci->pdf->Multicell(160,0,$comentario,1,'J',0,0,'','',1,0,0,0,40,'T',1);
	/*$ci->pdf->Multicell(60,100,$comentario,0,'C',0,0,'','',1,0,1,1); 
	if($considerando) {
		$ci->pdf->Cell(160, 6, 'CONSIDERANDO: ', 0, 1, 'L', FALSE);
	}
	$ci->pdf->SetFillColor(230, 230, 230);
	$ci->pdf->Cell(160, 6, 'LA SINDICO GENERAL DE LA PROVINCIA', 0, 1, 'C', TRUE);
	$ci->pdf->Cell(160, 6, 'RESUELVE:', 0, 1, 'C', FALSE);*/
	
	$ci->pdf->Output('example_001.pdf', 'I');
?>