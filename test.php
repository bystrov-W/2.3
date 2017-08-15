<?php

	$pageTitle = 'Сдать тест | Тесты по зельеварению';

	$choosenJSON = isset($_GET['choosenJSON']) ? $_GET['choosenJSON'] : '';
	$filee = @file_get_contents($choosenJSON);
	if (!$filee) {
		header( 'Location: 404.php' ); 
	} else {
	$JSONfile = json_decode (file_get_contents($choosenJSON));
	}

	
	function showTest ($JSONfile, $choosenJSON) {
	//разделяем радио-кнопки на группы переменной n
	$n = 0;
	echo '<form action="certificate.php" method="post">';
	echo '<div class="form-group"><label>Ваше имя:</label>
	<input type="text" class="form-control" name="studentName" placeholder="Ваше имя"><br/>';
	if ($choosenJSON == true) {
		foreach ($JSONfile as $object) {
			foreach ($object as $key => $question) {
				if ($question == 'radio') {
					$typeFlag = 'radio';
					//разделяем радио-кнопки на группы переменной n
					$n++;
				} elseif ($question == 'check') {
					$typeFlag = 'check';
				} elseif ($question == 'text') {
					$typeFlag = 'text';
				} else {
					if ($typeFlag == 'radio') {
						if ($key == 'question') {
							echo '<label>Вопрос: ' . $question . '</label>';
						} elseif ($key == 'answers') {
							$checkboxes = explode (', ', $question);
							foreach ($checkboxes as $checkbox) {
								echo '<div class="radio">
										<label>
											<input type="radio" name="radio' . $n . '" value="' . $checkbox . '">
												' . $checkbox . '
										</label>
									</div>';	
						}
						}
					} elseif ($typeFlag == 'check') {
						if ($key == 'question') {
							echo '<label>Вопрос: ' . $question . '</label>';
						} elseif ($key == 'answers') {
							$checkboxes = explode (', ', $question);
							foreach ($checkboxes as $checkbox) {
								echo '<div class="checkbox">
										<label>
											<input type="checkbox" name="check[]" value="' . $checkbox . '">
												' . $checkbox . '
										</label>
									</div>';
						}
						}
					} elseif ($typeFlag == 'text') {
						if ($key == 'question') {
							echo '<div class="form-group"><label>Вопрос: ' . $question . '</label>
							<input type="text" class="form-control" name="text" placeholder="Введите ответ">';
						}
					}
				}
			}
		
		}
		echo '<input type="hidden" name="JSONtest" value="' . $choosenJSON . '" />';
		echo '<br/><button type="submit" class="btn btn-default">Submit</button>';
	}
	echo '</form>';
	}

require_once ('header.php');

?>
		<div class="container">
			<div class="page-header">
				<h1>Тест <?php echo $choosenJSON; ?></h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if (!empty($_POST)) {
						result ($rightAnswers, $receivedAnswers, $_POST['studentName']); 
					} else {
						showTest ($JSONfile, $choosenJSON);
					}?>
				</div>
			</div>
		</div>
	</body>
</html>