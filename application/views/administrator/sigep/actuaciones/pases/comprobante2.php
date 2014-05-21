<?php
	$ci = &get_instance();
	$config = array(
		'header_on' => FALSE,
		'footer_on' => FALSE,
	);
	$ci->load->library('hits/pdf', $config);

	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->AddPage();

	//$ci->pdf->SetLeftMargin(30);
	
	$ci->pdf->SetFillColor(230, 230, 230);
	$ci->pdf->Image('assets/images/reportes/logo.jpg', '', '', 80);

	$ci->pdf->SetFont('helvetica', 'B', 12);
	$ci->pdf->Cell(95, 16, '', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(95, 8, 'BOLETA DE PASE INTERNO N° '.$pase['idActuacionPase'], '', 1, 'C', FALSE, '', 0, false, 'T', 'B');
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Cell(95,8);
	$ci->pdf->Cell(95, 8, 'ORIGINAL - Fecha de creación: '.GetDateTimeFromISO($pase['fechaEnvioActuacionPase']), '', 1, 'C', FALSE, '', 0, false, 'T', 'T');
	$ci->pdf->SetFont('helvetica', '', 9);
	//$ci->pdf->Ln(1);

	$ci->pdf->Cell(84, 7, 'Expediente Interno N°', 1, 0, 'L', TRUE);
	$ci->pdf->Cell(84, 7, 'Expediente SICE N°', 1, 0, 'L', TRUE);
	$ci->pdf->Cell(22, 7, 'Folios', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(84, 7, $actuacion['codigoActuacion'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(84, 7, $actuacion['referenciaActuacion'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(22, 7, $pase['fojasActuacionPase'], 1, 1, 'L', FALSE);

	$ci->pdf->Cell(95, 7, 'Tipo de documento o actuación', 1, 0, 'L', TRUE);
	$ci->pdf->Cell(95, 7, 'Referencia', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(95, 7, $actuacion['nombreActuacionTipo'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(95, 7, $actuacion['nombreActuacionTema'], 1, 1, 'L', FALSE);
	
	$ci->pdf->Cell(190, 7, 'Area Remitente', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(190, 7, $pase['nombreOrigen'], 1, 1, 'L', FALSE);
	$ci->pdf->Cell(190, 7, 'Area Destinataria', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(190, 7, $pase['nombreDestino'], 1, 1, 'L', FALSE);
	
	$ci->pdf->Cell(190, 7, 'Observaciones', 1, 1, 'L', TRUE);
	$ci->pdf->Multicell(190, 12, $pase['observacionActuacionPase'], 1, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Cell(40, 8, 'RECEPCION', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(75, 8, 'FIRMA', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(75, 8, 'SELLO', 1, 1, 'C', TRUE);
	$ci->pdf->Cell(40, 8, 'Fecha: ____/____/____', 'LTR', 0, 'C', FALSE, '', 0, false, 'T', 'B');
	$ci->pdf->Cell(75, 8, '', 'LTR', 0, 'C', FALSE);
	$ci->pdf->Cell(75, 8, '', 'LTR', 1, 'C', FALSE);
	$ci->pdf->Cell(40, 8, 'Hora: _____:_____', 'LBR', 0, 'C', FALSE, '', 0, false, 'T', 'B');
	$ci->pdf->Cell(75, 8, '', 'LBR', 0, 'C', FALSE);
	$ci->pdf->Cell(75, 8, '', 'LBR', 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 7);
	$ci->pdf->Cell(95, 5, 'Impreso por : '.$this->lib_autenticacion->apellidoPersona().', '.$this->lib_autenticacion->nombrePersona(), '', 0
		, 'L', FALSE);
	$ci->pdf->Cell(95, 5, 'Fecha de Impresión : '.date('d/m/y H:i:s'), '', 1, 'R', FALSE);
	$ci->pdf->Ln(8);
	$ci->pdf->Line(0,144,220,144);

	$ci->pdf->Image('assets/images/reportes/logo.jpg', '', '', 80);
	$ci->pdf->SetFont('helvetica', 'B', 12);
	$ci->pdf->Cell(95, 16, '', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(95, 8, 'BOLETA DE PASE INTERNO N° '.$pase['idActuacionPase'], '', 1, 'C', FALSE, '', 0, false, 'T', 'B');
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Cell(95,8);
	$ci->pdf->Cell(95, 8, 'ORIGINAL - Fecha de creación: '.GetDateTimeFromISO($pase['fechaEnvioActuacionPase']), '', 1, 'C', FALSE, '', 0, false, 'T', 'T');
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Ln(1);

	$ci->pdf->Cell(84, 7, 'Expediente Interno N°', 1, 0, 'L', TRUE);
	$ci->pdf->Cell(84, 7, 'Expediente SICE N°', 1, 0, 'L', TRUE);
	$ci->pdf->Cell(22, 7, 'Folios', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(84, 7, $actuacion['codigoActuacion'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(84, 7, $actuacion['referenciaActuacion'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(22, 7, $pase['fojasActuacionPase'], 1, 1, 'L', FALSE);

	$ci->pdf->Cell(95, 7, 'Tipo de documento o actuación', 1, 0, 'L', TRUE);
	$ci->pdf->Cell(95, 7, 'Referencia', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(95, 7, $actuacion['nombreActuacionTipo'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(95, 7, $actuacion['nombreActuacionTema'], 1, 1, 'L', FALSE);
	
	$ci->pdf->Cell(190, 7, 'Area Remitente', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(190, 7, $pase['nombreOrigen'], 1, 1, 'L', FALSE);
	$ci->pdf->Cell(190, 7, 'Area Destinataria', 1, 1, 'L', TRUE);
	$ci->pdf->Cell(190, 7, $pase['nombreDestino'], 1, 1, 'L', FALSE);
	
	$ci->pdf->Cell(190, 7, 'Observaciones', 1, 1, 'L', TRUE);
	$ci->pdf->Multicell(190, 12, $pase['observacionActuacionPase'], 1, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Cell(40, 8, 'RECEPCION', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(75, 8, 'FIRMA', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(75, 8, 'SELLO', 1, 1, 'C', TRUE);
	$ci->pdf->Cell(40, 8, 'Fecha: ____/____/____', 'LTR', 0, 'C', FALSE, '', 0, false, 'T', 'B');
	$ci->pdf->Cell(75, 8, '', 'LTR', 0, 'C', FALSE);
	$ci->pdf->Cell(75, 8, '', 'LTR', 1, 'C', FALSE);
	$ci->pdf->Cell(40, 8, 'Hora: _____:_____', 'LBR', 0, 'C', FALSE, '', 0, false, 'T', 'B');
	$ci->pdf->Cell(75, 8, '', 'LBR', 0, 'C', FALSE);
	$ci->pdf->Cell(75, 8, '', 'LBR', 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 7);
	$ci->pdf->Cell(95, 5, 'Impreso por : '.$this->lib_autenticacion->apellidoPersona().', '.$this->lib_autenticacion->nombrePersona(), '', 0
		, 'L', FALSE);
	$ci->pdf->Cell(95, 5, 'Fecha de Impresión : '.date('d/m/y H:i:s'), '', 1, 'R', FALSE);


	
	$ci->pdf->Output('example_001.pdf', 'I');
?>