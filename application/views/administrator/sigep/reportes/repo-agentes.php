<?php
	$ci = &get_instance();
	$ci->load->library('hits/pdf');
	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$ci->pdf->SetFont('helvetica', 'B', 12);
	$ci->pdf->AddPage();
	//$ci->pdf->SetLeftMargin(30);
	
	$ci->pdf->SetFillColor(210, 210, 210);
	$ci->pdf->Cell(190, 8, 'LA SINDICO GENERAL DE LA PROVINCIA', 1, 1, 'C', TRUE);
	$ci->pdf->SetFont('helvetica', 'B', 9);
	$ci->pdf->SetFillColor(240, 240, 240);
	$band=TRUE;
	foreach ($agentes as $agente) {
		($band==TRUE)? $band=FALSE:$band=TRUE;
		$ci->pdf->Cell(20, 8, $agente['dniPersona'], 1, 0, 'C', $band);	
		$ci->pdf->Cell(90, 8, $agente['nombreCompletoPersona'], 1, 0, 'C', $band);	
		$ci->pdf->Cell(50, 8, $agente['denominacionCargo'], 1, 1, 'C', $band);	
	}
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