<h1>Admin area : Venda:</h1>
			
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	    <thead>
		<tr><th>id</th>
<th>carrinho_id</th>
<th>total</th>
<th>datecreate</th>

		<th>Visualizar</th>
        <th>Deletar</th>
        <th>Atualizar</th>
		</tr>
	    </thead>
	    <tbody><tr class="gradeY">{foreach item=venda from=$Venda}<td> {$venda->id} </td>
<td> {$venda->carrinho_id} </td>
<td> {$venda->total} </td>
<td> {$venda->datecreate} </td>
<td><a href="main.php?class=venda&method=getIdVenda&id={$venda->id}" id="" >Visualizar</a></td>
<td><a href="main.php?class=venda&method=destroy&id={$venda->id}" id="" >Deletar</a></td>
<td><a href="main.php?class=venda&method=update&id={$venda->id}" id="">Atualizar</a></td>
</tr>
		{/foreach}</tbody>
        </table>