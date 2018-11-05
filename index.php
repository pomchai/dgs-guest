Superman
AAAAA AT LOCAL I 'm POM
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DGS : User Management</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/styles.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<div class="container" style="margin-top:40px">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
				<!-- panel-heading -->
					<div class="panel-heading">
						<strong>DGS : User Management</strong>
					</div>
				<!-- panel-body -->
					<div class="panel-body">
						<form role="form" action="login.php" method="POST">
							<fieldset>
								<div class="row">
									<div class="center-block text-center">
										<img class="profile-img" src="img/profile-img.png" height="120" width="120" alt="">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-10 col-md-offset-1 ">
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-envelope"></i>
												</span> 
												<input class="form-control" placeholder="Email" name="email" type="text" autofocus>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
												<input class="form-control" placeholder="Password" name="pass" type="password">
											</div>
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" value="LOGIN">
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
                </div>
			</div>
		</div>
	</div>
</body>
</html>