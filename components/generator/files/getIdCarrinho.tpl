<html>
        <body>
       {foreach item=carrinho from=$Carrinho}
        <h2> id: {$carrinho->id}  </h2><br>
	        <p> name:    {$carrinho->produto_id} </p>  <br>
	           <p> email:   {$carrinho->pedido_id} </p>  <br>
            <p> text:   {$carrinho->session_id} </p>  <br>
		{/foreach}
        </body>
        </html>