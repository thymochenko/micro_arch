<html>
<body>
{foreach item=entrevist from=$entrevists}
<h2> Titulo: {$entrevists->titulo}  </h2><br>
						<p> data:    {$entrevists->entr_data} </p>  <br>
					    <p> Texto:  {$entrevists->entr_text} </p>  <br>
						<p> autor:   {$entrevists->nome}  </p> <br>
						<p> email:   {$entrevists->email}  </p><br>
						{/foreach}
						
</body>
</html>
