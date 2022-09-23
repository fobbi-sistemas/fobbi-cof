<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Admin | Fácil Catálogos</title>
	<meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css"/>
</head>
<body>
	<div class="login">
		<form method="post" action="realiza-login.php">
			<div class="mb-3">
				<label class="form-label">Usuário</label>
				<input type="text" name="login" value="<?php echo isset($_GET['user']) ? $_GET['user'] : null; ?>" class="form-control" required/>
			</div>

			<div class="mb-3">
				<label class="form-label">Senha</label>
				<input type="password" name="senha" class="form-control" required/>
			</div>
			
			<?php if (isset($_GET['valid']) && $_GET['valid'] == "false") { ?>
				<div class="alert alert-warning" role="alert">Login ou senha incorretos.</div>
			<?php } ?>

			<div class="d-grid gap-2">
				<input type="submit" name="entrar" class="btn btn-menu" value="Entrar"/>
			</div>
		</form>
	</div>
	
	<div class="text-center" style="margin-top: 100px;">
		<a href="https://www.hsys.dev.br" target="_blank" class="text-dark text-decoration-none" style="font-size: 12px;"> 
			DESENVOLVIDO POR <img src="https://www.hsys.dev.br/images/logo-hsys-3.png" alt="..." class="ms-3" height="40"/>
		</a>
	</div>
</body>
</html>
