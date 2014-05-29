<?php
	set_time_limit(3600);
	$ci = &get_instance();
	$config = array(
		'header_on' => FALSE,
		'footer_on' => FALSE,
	);
	$ci->load->library('hits/pdf', $config);

	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->SetLeftMargin(5);
	$ci->pdf->SetRightMargin(5);
	$ci->pdf->SetTopMargin(5);

	foreach ($agentes as $agente) {
	

	$ci->pdf->AddPage();
	$ci->pdf->SetFillColor(230, 230, 230);
	$ci->pdf->SetFont('helvetica', 'B', 14);
	$ci->pdf->Cell(280, 8, 'Si.Ge.P. - RR.HH.', 0, 1, 'L', FALSE);
	$ci->pdf->SetFont('helvetica', '', 14);
	$ci->pdf->MultiCell(30, 12, '  Apellido : ', 'LTB', 'L', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 12, 'M');
	$ci->pdf->SetFont('helvetica', 'B', 14);
	$ci->pdf->MultiCell(130, 12, $agente['apellidoPersona'], 'TRB', 'L', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 12, 'M');
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(50, 6, 'Nacionalidad', 'LTR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, 'C.U.I.L. N°', 'LTR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, 'Año', 'LTR', 1, 'C', FALSE);
	$ci->pdf->Cell(160, 6, '', 0, 0, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 10);
	$ci->pdf->Cell(50, 6, $agente['nacionalidadPersona'], 'LBR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, $agente['cuilPersona'], 'LBR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, date('Y'), 'LBR', 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 14);
	$ci->pdf->MultiCell(30, 12, '  Nombres : ', 'LTB', 'L', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 12, 'M');
	$ci->pdf->SetFont('helvetica', 'B', 14);
	$ci->pdf->MultiCell(130, 12, $agente['nombrePersona'], 'TRB', 'L', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 12, 'M');
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(50, 6, 'Fecha de Nacimiento', 'LTR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, 'Estado Civil', 'LTR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, 'D.N.I. N°', 'LTR', 1, 'C', FALSE);
	$ci->pdf->Cell(160, 6, '', 0, 0, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 10);
	$ci->pdf->Cell(50, 6, $agente['nacimientoPersona'], 'LBR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, '', 'LBR', 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, $agente['dniPersona'], 'LBR', 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(30, 7, '   Cargo : ', 'LTB', 0, 'L', FALSE);
	$ci->pdf->SetFont('helvetica', '', 10);

	$cuadrocargosagentes = $this->cuadrocargosagentes->obtenerCuadroCargoAgente($agente['idAgente']);
	$ci->pdf->Cell(130, 7, $cuadrocargosagentes[0]['denominacionCargo'].' - '.$cuadrocargosagentes[0]['nombreEstructura'], 'TRB', 0, 'L', FALSE);
	$ci->pdf->Cell(15, 7, 'Agrup.:', 1, 0);
	$ci->pdf->Cell(15, 7, $cuadrocargosagentes[0]['nombreAgrupamientoCC'], 1, 0, 'C');
	$ci->pdf->Cell(20, 7, 'Sub Grupo:', 1, 0);
	$ci->pdf->Cell(15, 7, ($cuadrocargosagentes[0]['idSubgrupo'] == 0)? '':$cuadrocargosagentes[0]['idSubgrupo'], 1, 0, 'C');
	$ci->pdf->Cell(30, 7, 'F.J. Si.Ge.P.:', 1, 0);
	$ci->pdf->Cell(15, 7, $cuadrocargosagentes[0]['nombreFuncion'], 1, 1, 'C');
	
	/*$ci->pdf->Cell(130, 6, 'SITUACION DE REVISTA Y CARGO QUE DESEMPEÑA', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(110, 6, 'GRUPO FAMILIAR', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(30, 6, 'D.N.I. N°', 1, 1, 'C', FALSE);
	$ci->pdf->Cell(30, 4, 'FECHA', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(60, 4, 'SITUACION DE REVISTA', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(40, 4, 'CARGO', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(110, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(30, 4, '', 1, 1, 'C', FALSE);
	$ci->pdf->Cell(30, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(60, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(40, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(110, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(30, 4, '', 1, 1, 'C', FALSE);
	$ci->pdf->Cell(30, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(60, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(40, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(110, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(30, 4, '', 1, 1, 'C', FALSE);
	$ci->pdf->Cell(30, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(60, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(40, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(110, 4, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(30, 4, '', 1, 1, 'C', FALSE);*/

	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(90, 5, 'DOMICILIO', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(40, 5, 'Tel / Cel', 1, 0, 'C', FALSE);
	//$ci->pdf->Cell(40, 5, 'FECHA INGRESO', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(140, 5, 'TITULO OBTENIDO', 1, 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 10);
	$ci->pdf->MultiCell(90, 10, $agente['domicilioPersona'], 1, 'C', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 10, 'M');
	//$ci->pdf->Cell(70, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(40, 5, $agente['telefonoPersona'], 1, 0, 'C', FALSE);
	//$ci->pdf->Cell(40, 5, '', 1, 0, 'C', FALSE);
	//$ci->pdf->Cell(120, 5, '', 1, 1, 'C', FALSE);
	$ci->pdf->MultiCell(140, 10, ' ', 1, 'C', FALSE, 1, '', '', TRUE, 0, FALSE, TRUE, 10, 'M');
	$ci->pdf->Ln(-5);
	$ci->pdf->Cell(90, 5, '', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(40, 5, $agente['celularPersona'], 1, 0, 'C', FALSE);
	//$ci->pdf->Cell(40, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(140, 5, '', 0, 1, 'C', FALSE);

	/*$ci->pdf->StartTransform();
	$ci->pdf->Rotate(-90);
	$ci->pdf->Cell(15, 5, 'M', 1, 0, 'C', FALSE);
	$ci->pdf->StopTransform();*/
	$ci->pdf->SetFont('helvetica', 'B', 9);
	$ci->pdf->Cell(10, 4, 'M', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(112, 4, 'ASISTENCIA', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(30, 4, 'INASISTENCIAS', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(15, 4, 'M', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(68, 4, 'LICENCIAS MEDICAS', 1, 0, 'C', FALSE);
	$ci->pdf->MultiCell(35, 14, 'OBSERVACIONES', 1, 'C', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 10, 'M');
	$ci->pdf->Ln(4);
	//$ci->pdf->Cell(35, 4, 'OBSERVACIONES', 1, 1, 'C', FALSE);
	$ci->pdf->SetFont('helvetica', '', 8);

	$ci->pdf->Cell(10, 5, 'M', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '1', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '2', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '3', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '4', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '5', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '6', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '7', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '8', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '9', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '10', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '11', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '12', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '13', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '14', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '15', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->MultiCell(10, 10, 'CANT', 'LTR', 'C', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 10, 'M');
	$ci->pdf->MultiCell(10, 10, 'INJUS', 'LTR', 'C', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 10, 'M');
	$ci->pdf->MultiCell(10, 10, 'JUST', 'LTR', 'C', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 10, 'M');
	$ci->pdf->Cell(15, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(35, 5, '', 0, 1, 'C', FALSE);
	$ci->pdf->Cell(10, 5, 'M', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '16', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '17', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '18', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '19', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '20', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '21', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '22', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '23', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '24', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '25', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '26', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '27', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '28', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '29', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '30', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(7, 5, '31', 1, 0, 'C', FALSE);

	$ci->pdf->Cell(10, 5, '', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(10, 5, '', 0, 0, 'C', FALSE);
	$ci->pdf->Cell(10, 5, '', 0, 0, 'C', FALSE);

	$ci->pdf->Cell(15, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(17, 5, '', 1, 0, 'C', FALSE);
	$ci->pdf->Cell(35, 5, '', 0, 1, 'C', FALSE);

	$meses = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic');
	$i = 0;
	$band = TRUE;
	foreach ($meses as $mes) {
		$i++;
		$ci->pdf->MultiCell(10, 8, $mes, 'LTR', 'C', FALSE, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'M');
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(10, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(10, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(10, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(15, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(35, 4, '', 1, 1, 'C', FALSE);
		$ci->pdf->Cell(10, 4, '', 'LBR', 0, 'C', FALSE);	
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(7, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(10, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(10, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(10, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(15, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(17, 4, '', 1, 0, 'C', FALSE);
		$ci->pdf->Cell(35, 4, '', 1, 1, 'C', FALSE);
	}


	}

	//$ci->pdf->SetFont('helvetica', 'B', 12);
	//$ci->pdf->Cell(95, 5, 'Fecha de Impresión : '.date('d/m/y H:i:s'), '', 1, 'R', FALSE);


	
	$ci->pdf->Output('example_001.pdf', 'I');
?>