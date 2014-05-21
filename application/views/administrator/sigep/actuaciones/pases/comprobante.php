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
	
	$ci->pdf->SetFillColor(210, 210, 210);
	$ci->pdf->Cell(190, 8, 'BOLETA DE PASE INTERNO', 1, 1, 'C', TRUE);
	$ci->pdf->Cell(80, 8, 'Tipo de documento : '.$actuacion['nombreActuacionTipo'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(110, 8, 'Tema : '.$actuacion['nombreActuacionTema'], 1, 1, 'L', FALSE);
	$ci->pdf->Cell(95, 8, 'Boleta de Pase N° '.$pase['idActuacionPase'], 'LTB', 0, 'L', FALSE);
	$ci->pdf->Cell(95, 8, 'ORIGINAL / Fecha de creación de pase : '.GetDateTimeFromISO($pase['fechaEnvioActuacionPase']), 'RTB', 1, 'R', FALSE);
	$ci->pdf->Cell(84, 8, 'Expediente Interno N° : '.$actuacion['codigoActuacion'], 'LTB', 0, 'L', FALSE);
	$ci->pdf->Cell(84, 8, 'Expediente SICE N° : '.$actuacion['referenciaActuacion'], 'LTB', 0, 'L', FALSE);
	$ci->pdf->Cell(22, 8, 'Folios : '.$pase['fojasActuacionPase'], 'LRTB', 1, 'L', FALSE);
	$ci->pdf->Cell(95, 8, 'Area Remitente', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(95, 8, 'Area Destinataria', 1, 1, 'C', TRUE);
	$ci->pdf->Multicell(95, 12, $pase['nombreOrigen'], 'LRB', 'L', false, 0, '', '', true, 0, true);
	$ci->pdf->Multicell(95, 12, $pase['nombreDestino'], 'LRB', 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Cell(190, 8, 'Observaciones', 1, 1, 'L', TRUE);
	$ci->pdf->Multicell(190, 12, $pase['observacionActuacionPase'], 1, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Cell(95, 8, 'FIRMA', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(95, 8, 'SELLO', 1, 1, 'C', TRUE);
	$ci->pdf->Multicell(95, 25, '', 'LRB', 'L', false, 0, '', '', true, 0, true);
	$ci->pdf->Multicell(95, 25, '', 'LRB', 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->SetFont('helvetica', '', 8);
	$ci->pdf->Cell(95, 6, 'Impreso por : '.$this->lib_autenticacion->apellidoPersona().', '.$this->lib_autenticacion->nombrePersona(), 'LB', 0
		, 'L', TRUE);
	$ci->pdf->Cell(95, 6, 'Fecha de Impresión : '.date('d/m/y H:i:s'), 'BR', 1, 'R', TRUE);
	$ci->pdf->Ln(15);
	$ci->pdf->Line(0,148,220,148);

	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Cell(190, 8, 'BOLETA DE PASE INTERNO', 1, 1, 'C', TRUE);
	$ci->pdf->Cell(80, 8, 'Tipo de documento : '.$actuacion['nombreActuacionTipo'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(110, 8, 'Tema : '.$actuacion['nombreActuacionTema'], 1, 1, 'L', FALSE);
	$ci->pdf->Cell(95, 8, 'Boleta de Pase N° '.$pase['idActuacionPase'], 'LTB', 0, 'L', FALSE);
	$ci->pdf->Cell(95, 8, 'COPIA / Fecha de creación de pase : '.GetDateTimeFromISO($pase['fechaEnvioActuacionPase']), 'RTB', 1, 'R', FALSE);
	$ci->pdf->Cell(84, 8, 'Expediente Interno N° : '.$actuacion['codigoActuacion'], 'LTB', 0, 'L', FALSE);
	$ci->pdf->Cell(84, 8, 'Expediente SICE N° : '.$actuacion['referenciaActuacion'], 'LTB', 0, 'L', FALSE);
	$ci->pdf->Cell(22, 8, 'Folios : '.$pase['fojasActuacionPase'], 'LRTB', 1, 'L', FALSE);
	$ci->pdf->Cell(95, 8, 'Area Remitente', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(95, 8, 'Area Destinataria', 1, 1, 'C', TRUE);
	$ci->pdf->Multicell(95, 12, $pase['nombreOrigen'], 'LRB', 'L', false, 0, '', '', true, 0, true);
	$ci->pdf->Multicell(95, 12, $pase['nombreDestino'], 'LRB', 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Cell(190, 8, 'Observaciones', 1, 1, 'L', TRUE);
	$ci->pdf->Multicell(190, 12, $pase['observacionActuacionPase'], 1, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Cell(95, 8, 'FIRMA', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(95, 8, 'SELLO', 1, 1, 'C', TRUE);
	$ci->pdf->Multicell(95, 25, '', 'LRB', 'L', false, 0, '', '', true, 0, true);
	$ci->pdf->Multicell(95, 25, '', 'LRB', 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->SetFont('helvetica', '', 8);
	$ci->pdf->Cell(95, 6, 'Impreso por : '.$this->lib_autenticacion->apellidoPersona().', '.$this->lib_autenticacion->nombrePersona(), 1, 0
		, 'L', TRUE);
	$ci->pdf->Cell(95, 6, 'Fecha de Impresión : '.date('d/m/y H:i:s'), 1, 0, 'R', TRUE);

	$ci->pdf->Output('example_001.pdf', 'I');
?>