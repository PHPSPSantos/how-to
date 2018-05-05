<!DOCTYPE html>
<html>
<head>
	<title>Previsão do tempo v0.0.0.1 alpha</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/js/bootstrap.min.js">
</head>
<body>
	<div class="row">
	<form method="post" action="process.php">
		<div class="col-lg-8 col-lg-offset-4"><h1>Previsão do Tempo</h1></div>

		<div class="col-lg-8 col-lg-offset-2">
		<div class="form-group">
			<label for="pais">País: </label>
			<input type="text"  class="form-control" name="pais" value="Brazil"> 
		</div>			
		
		<div class="form-group">
			<label for="cidade"> Estado: </label>	
			<input type="text"  class="form-control" name="estado" value="SP">
		</div>			
		
		
		<div class="form-group">
			<label for="cidade"> Cidade: </label>	
			<input type="text"  class="form-control" name="cidade" value="">			
		</div>			
		

		<div class="form-group">
			<input type="Submit" name="enviar" value="Consultar">	
		</div>			
		
		<div class="col-lg-4"></div>
		
		
	</div>
	</form>
	</div>
</body>
</html>