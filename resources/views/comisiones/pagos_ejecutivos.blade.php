<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=base_ejecutivos.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border=1>
<tr style="background-color:#777777;color:#FFFFFF">
<td><b>Nombre</td>
<td><b>Tienda</td>
<td><b>Ventas Total</td>
<td><b>Ventas 1-5</td>
<td><b>Comision</td>
<td><b>Ventas 6-10</td>
<td><b>Comision</td>
<td><b>Ventas 11+</td>
<td><b>Comision</td>
<td><b>Comision Total</td>
<td><b>Fijo</td>
<td><b>Pago Total</td>
</tr>
<?php

foreach ($query as $transaccion) {
	?>
	<tr>
	<td>{{$transaccion->user_desc->name}}</td>
	<td>{{$transaccion->locacion_desc->nombre}}</td>
	<td>{{$transaccion->ventas}}</td>
	<td>{{$transaccion->rango1}}</td>
	<td>{{$transaccion->comision_r1}}</td>
	<td>{{$transaccion->rango2}}</td>
	<td>{{$transaccion->comision_r2}}</td>
	<td>{{$transaccion->rango3}}</td>
	<td>{{$transaccion->comision_r3}}</td>
	<td>{{$transaccion->total_comisiones}}</td>
	<td>{{$transaccion->fijo}}</td>
	<td>{{$transaccion->total_pago}}</td>
	</tr>
<?php
}
?>
</table>