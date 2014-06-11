<?php
	$ci = &get_instance();
	$config = array(
		//'header_on' => FALSE,
		//'footer_on' => FALSE,
	);
	$ci->load->library('hits/pdf', $config);
	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$ci->pdf->SetFillColor(230, 230, 230);
	$ci->pdf->SetFont('helvetica', 'B', 12);
	$ci->pdf->AddPage();
	$ci->pdf->Cell(190, 10, 'Informe de Actuación', 0, 1, 'L', FALSE);
	$ci->pdf->Line(10, 40, 200, 40);
	$ci->pdf->Ln(2);
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(190, 7, 'Detalle', 0, 1, 'L', TRUE);
	$ci->pdf->Ln(2);
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Cell(30, 7, 'Tipo de Actuación : ', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(30, 7, $actuacion['nombreActuacionTipo'], 1, 1, 'L', FALSE);
	$ci->pdf->Cell(30, 7, 'Número Interno : ', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(35, 7, $actuacion['codigoActuacion'], 1, 0, 'L', FALSE);
	$ci->pdf->Cell(45, 7, 'Número de Referencia SICE : ', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(40, 7, $actuacion['referenciaActuacion'], 1, 1, 'L', FALSE);
	$ci->pdf->Cell(50, 7, 'Fecha de Creación | Recepción : ', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(40, 7, GetDateTimeFromISO($actuacion['fechaCreacionActuacion']), 1, 0, 'L', FALSE);
	$ci->pdf->Cell(20, 7, 'Período : ', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(20, 7, $actuacion['fechaCreacionActuacion'], 1, 1, 'L', FALSE);
	$ci->pdf->Cell(50, 7, 'Tema', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(140, 7, '', 1, 1, 'L', FALSE);
	$ci->pdf->Cell(50, 7, 'Iniciador', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(140, 7, '', 1, 1, 'L', FALSE);
	$ci->pdf->Cell(50, 7, 'Folios', 1, 0, 'L', FALSE);
	$ci->pdf->Cell(140, 7, '', 1, 1, 'L', FALSE);
	$ci->pdf->Cell(50, 28, 'Carátula', 1, 0, 'L', FALSE);
	$ci->pdf->Multicell(140, 28, $actuacion['caratulaActuacion'], 1, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Ln(2);
	$ci->pdf->Cell(190, 7, 'Detalle de pases', 0, 1, 'L', TRUE);
	$ci->pdf->Ln(2);
	foreach ($pases as $pase) {
		$ci->pdf->Cell(35, 7, 'Estado : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['nombrePaseEstado'], 1, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 7, 'Fecha de envío : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['fechaEnvioActuacionPase'], 1, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 7, 'Area Rtte. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['idOrigen'].' - '.$pase['nombreOrigen'], 1, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 7, 'Agente Rtte. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['apellidoPersonaOrigen'].', '.$pase['nombrePersonaOrigen'], 1, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 7, 'Fecha de recepcion : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['fechaRecepcionActuacionPase'], 1, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 7, 'Area u Org. Dest. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['idDestino'].' - '.$pase['nombreDestino'], 1, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 7, 'Agente Recep. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['apellidoPersonaDestino'].', '.$pase['nombrePersonaDestino'], 1, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 7, 'Observaciones : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 7, $pase['observacionActuacionPase'], 1, 1, 'L', FALSE);
		$ci->pdf->Ln(6);
	}

	$ci->pdf->Output('example_001.pdf', 'I');
?> 