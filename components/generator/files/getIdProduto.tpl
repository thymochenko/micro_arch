<html>
        <body>
       {foreach item=venda from=$Venda}
        <h2> id: {$venda->id}  </h2><br>
	        <p> name:    {$venda->carrinho_id} </p>  <br>
	           <p> email:   {$venda->total} </p>  <br>
            <p> text:   {$venda->datecreate} </p>  <br>
		{/foreach}
        </body>
        </html>