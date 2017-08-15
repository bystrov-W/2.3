<?php 
	$pageTitle = 'Панель администратора ';
	
	/*if (!empty($_FILES['InputFile']) and strpos($_FILES['InputFile']['name'],'json')) {
		header( 'Location: list.php' ); 
	}*/

	if (isset($_FILES['InputFile']['name'])) {
		$uploaddir = 'uploads/';
		$uploadfile = $uploaddir . basename($_FILES['InputFile']['name']);
	
		move_uploaded_file($_FILES['InputFile']['tmp_name'], $uploadfile);
			
		//Проверка на JSON: если декодируется успешно, оставляем на сервере, если нет — удаляем.
		$JSONfile = json_decode (file_get_contents("$uploadfile"));
		if ($JSONfile !== null ) {
			header( 'Location: list.php' ); 
		} else {
			unlink($uploadfile);
			$error = 1;
		}
	}
	
	function showError ($error) {
		if ($error == 1) {
			echo "<p class='text-danger'>Возможна загрузка только JSON файлов.</p>";
		}
	}		
		
	require_once ('header.php');
?>
		<div class="container">
			<div class="page-header">
				<h1>Загрузка тестов в систему</h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p class="lead">Для того, чтобы приступить к тестам, загрузите вопросы и ответы в формате JSON в систему.</p>
					<p>Если у вас нет материалов, подходящих для загрузки — скачайте <a href="test2.json">стандартный тест</a> и загрузите его в систему.</p>
					<form enctype="multipart/form-data" method="POST" action="admin.php">
					  <div class="form-group">
						<label for="InputFile">Загрузить JSON-файл с тестом</label>
						<input type="file" name="InputFile">
					  </div>
					  <button type="submit" class="btn btn-default">Загрузить</button>
					</form>
				</br>
				<?php if (isset($error)) { showError ($error); } ?>
				</div>
			</div>
		</div>
	</body>
</html>