<?php
	$ci = &get_instance();
	$ci->load->library("hits/pdf");
	$ci->pdf->SetFont('dejavusans', '', 10);
	$ci->pdf->AddPage();
	$ci->pdf->Cell(160, 10, 'Apellido : ', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Nacionalidad', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'C.U.I.L. N°', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Año', 1, 1, 'C', 0, '', 0);
	$ci->pdf->Cell(160, 5, '');
	$ci->pdf->Cell(40, 5, 'Nacionalidad', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Nacionalidad', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Nacionalidad', 1, 1, 'C', 0, '', 0);

	$ci->pdf->Cell(160, 10, 'Nombres : ', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Fecha Nacimiento', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Estado Civil', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'D.N.I. N°', 1, 1, 'C', 0, '', 0);
	$ci->pdf->Cell(160, 5, '');
	$ci->pdf->Cell(40, 5, 'Nacionalidad', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Nacionalidad', 1, 0, 'C', 0, '', 0);
	$ci->pdf->Cell(40, 5, 'Nacionalidad', 1, 1, 'C', 0, '', 0);
	$ci->pdf->Cell(30, 6, 'Agrup.: ', 1, 0);
	$ci->pdf->Cell(30, 6, 'Sub Grupo : ', 1, 0);
	$ci->pdf->Cell(30, 6, 'Nivel : ', 1, 0);
	$ci->pdf->Cell(70, 6, 'Función Jerarq. Si.Ge.P.: ', 1, 0);
	$ci->pdf->Cell(50, 6, 'Antiguedad al 31/12/12 ', 1, 0);
	$ci->pdf->Cell(20, 6, 'Años', 1, 0);
	$ci->pdf->Cell(30, 6, 'Meses', 1, 0);
	$ci->pdf->Cell(20, 6, 'Días', 1, 1, 'L', 0, 'R');
	$ci->pdf->Cell(140, 6, 'SITUACION DE REVISTA Y CARGO QUE DESEMPEÑA', 1, 0, 'C', 0, 'R');
	$ci->pdf->Cell(100, 6, 'GRUPO FAMILIAR', 1, 0, 'C', 0, 'R');
	$ci->pdf->Cell(40, 6, 'D.N.I. N°', 1, 1, 'C', 0, 'R');
	$ci->pdf->Output('example_001.pdf', 'I');
?>