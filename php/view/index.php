<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Novo phpPgAdmin</title>
	</head>
	<body>
	
		<!-- toda a página -->
		<div id="content">
		
			<!-- cabeçalho da página -->
			<div id="head">
			
				<!-- ver se é melhor o header -->
			
			</div>
			<!-- fim cabeçalho da página --> 
			
			<!-- conteúdo da página -->
			<div id="body">
			
				<!-- coluna a esquerda -->
				<div id="left">
				
					<!-- logo -->
					<div id="top-left">
						<img src="logo.jpg" alt="Top 5" width="330" height="174">
					</div>
					<!-- fim logo -->
					
					<!-- listagem de databases e esquemas -->
					<div id="column-left">
						<?php
							$pdo = new PDO('pgsql:dbname=daivid;host=localhost', 'postgres', 'postgres');
							$dados = $pdo->query("select schema_name from information_schema.schemata where schema_name not like 'pg_%' and schema_name not in ('information_schema')");
							foreach($dados as $row){
								echo $row['schema_name'] . "<br>";
							}
						?>
					</div>
					<!-- fim listagem de databases e esquemas-->
					
				</div>
				
				<!-- conteúdo principal -->
				<div id="main">
					<!-- conteúdo do topo -->
					<div id="top">
					</div>
					<!-- fim conteúdo do topo -->
					
					<!-- conteúdo principal -->
					<div id="main-content">
						<h1>Consulta</h1>
						<form method="post" action="../model/.php">
							<textarea id="sql-content" name="sql-content"></textarea>
					
							<input type="submit" value="Executar" id="button" />
						</form>
					</div>
					<!-- fim conteúdo principal -->
					
				</div>
				<!-- fim conteúdo principal -->
				
			</div>
			<!-- fim conteúdo da página -->
			
			<!-- rodapé da página -->
			<div id="footer">
			
				<!-- ver se é melhor o footer -->
			
			</div>
			<!-- fim rodapé da página -->
			
		</div>
		<!-- fim toda a página -->
		
	</body>
</html>