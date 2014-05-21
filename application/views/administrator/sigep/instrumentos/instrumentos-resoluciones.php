<?php
	$ci = &get_instance();
	$ci->load->library('hits/pdf');
	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	// set font

	$ci->pdf->SetFont('helvetica', 'B', 12);
	// add a page
	$ci->pdf->AddPage();
	$ci->pdf->SetLeftMargin(30);
	// print a line using Cell()
	$band=0;
	/*foreach ($productos as $producto) {
		$ci->pdf->SetFillColor(230, 230, 230);
		if ($band==0) {
			$fill=TRUE;
			$band=1;
		}
		else {
			$fill=FALSE;
			$band=0;
		}
		$ci->pdf->Cell(10, 6, $producto['idProducto'], 0, 0, 'C', $fill);
		$ci->pdf->Cell(50, 6, $producto['nombreProducto'], 0, 0, 'L', $fill);
		$ci->pdf->Cell(15, 6, $producto['precioProductoProveedor'], 0, 0, 'C', $fill);
		$ci->pdf->Cell(15, 6, $producto['precioProductoCanillita'], 0, 1, 'C', $fill);
	}*/
	$ci->pdf->Cell(160, 6, 'SALTA, '.$fecha, 0, 1, 'R', FALSE);
	$ci->pdf->Cell(160, 6, 'RESOLUCION N° '.$fecha, 0, 1, 'L', FALSE);
	$ci->pdf->Cell(160, 6, 'SINDICATURA GENERAL DE LA PROVINCIA '.$fecha, 0, 1, 'L', FALSE);
	$comentario="Con <b>autopadding</b> false no se aplica el espacio previsto ni en la parte superior ni en la inferior de la celda. Si se hace por la izquierda y la derecha\n\n";
	//$ci->pdf->Multicell(160,0,$comentario,1,'J',0,0,'','',1,0,0,0,40,'T',1);
	$ci->pdf->Multicell(60,100,$comentario,0,'C',0,0,'','',1,0,1,1); 
	if($considerando) {
		$ci->pdf->Cell(160, 6, 'CONSIDERANDO: ', 0, 1, 'L', FALSE);
	}
	$ci->pdf->SetFillColor(230, 230, 230);
	$ci->pdf->Cell(160, 6, 'LA SINDICO GENERAL DE LA PROVINCIA', 0, 1, 'C', TRUE);
	$ci->pdf->Cell(160, 6, 'RESUELVE:', 0, 1, 'C', FALSE);
	
	$ci->pdf->Output('example_001.pdf', 'I');
?>