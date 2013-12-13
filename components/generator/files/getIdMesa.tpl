<html>
        <body>
       {foreach item=mesa from=$Mesa}
        <h2> id: {$mesa->id}  </h2><br>
	        <p> name:    {$mesa->descricao} </p>  <br>
	           <p> email:   {$mesa->datecreate} </p>  <br>
            <p> text:   {$mesa->status} </p>  <br>
		{/foreach}
        </body>
        </html>