<html>
        <body>
       {foreach item=categoria from=$Categoria}
        <h2> id: {$categoria->id}  </h2><br>
	        <p> name:    {$categoria->descricao} </p>  <br>
	           <p> email:   {$categoria->datecreate} </p>  <br>
            <p> text:   {$categoria->status} </p>  <br>
		{/foreach}
        </body>
        </html>