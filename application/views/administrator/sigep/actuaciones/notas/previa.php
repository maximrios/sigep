<?php
	$ci = &get_instance();
	$config = array(
		'header_on' => TRUE,
		'footer_on' => FALSE,
	);
	$ci->load->library('hits/pdf', $config);

	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->AddPage();
	$ci->pdf->SetFillColor(230, 230, 230);
	//$ci->pdf->Image('assets/images/reportes/logo.jpg', '', '', 80);
	$ci->pdf->SetFont('helvetica', '', 9);
	//$ci->pdf->Multicell(190, 12, html_entity_decode($nota['cuerpoNota']), 0, 'L', false, 1, '', '', true, 0, true);
	$html = '<table border="1" cellpadding="1" cellspacing="1" style="width:500px">
	<tbody>
		<tr>
			<td>asd</td>
			<td>asdasd</td>
		</tr>
		<tr>
			<td>asdasd</td>
			<td>asdasd</td>
		</tr>
		<tr>
			<td>sdasdasd</td>
			<td>asdasda</td>
		</tr>
	</tbody>
</table>';
$html = $nota['cuerpoNota'];
$ci->pdf->Multicell(190, 12, $nota['cuerpoNota'], 0, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->writeHTML($html, true, false, true, false, '');
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Cell(95,8);
	$ci->pdf->Output('example_001.pdf', 'I');
?>