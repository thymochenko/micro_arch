<h1>Admin area : Mesa:</h1>
			
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	    <thead>
		<tr><th>id</th>
<th>descricao</th>
<th>datecreate</th>
<th>status</th>

		<th>Visualizar</th>
        <th>Deletar</th>
        <th>Atualizar</th>
		</tr>
	    </thead>
	    <tbody><tr class="gradeY">{foreach item=mesa from=$Mesa}<td> {$mesa->id} </td>
<td> {$mesa->descricao} </td>
<td> {$mesa->datecreate} </td>
<td> {$mesa->status} </td>
<td><a href="main.php?class=mesa&method=getIdMesa&id={$mesa->id}" id="" >Visualizar</a></td>
<td><a href="main.php?class=mesa&method=destroy&id={$mesa->id}" id="" >Deletar</a></td>
<td><a href="main.php?class=mesa&method=update&id={$mesa->id}" id="">Atualizar</a></td>
</tr>
		{/foreach}</tbody>
        </table>