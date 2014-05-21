<table>
	<thead>
		<tr>
			<th colspan="4">Comision</th>
		</tr>
		<tr>
			<th>Codigo</th>
			<th>Documento</th>
			<th>Agente</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($alumnos as $alumno) { ?>
			<tr>
				<td><?php echo $alumno['idCCAlumno']?></td>
				<td><?php echo $alumno['dniPersona']?></td>
				<td><?php echo $alumno['completoPersona']?></td>
				<td><a href="#">i</a></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<button class="btn">Agregar</button>