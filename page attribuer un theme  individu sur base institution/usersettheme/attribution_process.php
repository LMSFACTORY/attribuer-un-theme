<?php

	require_once('../config.php');

	if (!empty($USER->newadminuser)) {
		// Ignore double clicks, we must finish all operations before cancelling request.
		ignore_user_abort(true);

		$PAGE->set_course($SITE);
		$PAGE->set_pagelayout('maintenance');
	} else {
		if ($course->id == SITEID) {
			require_login();
			$PAGE->set_context(context_system::instance());
		} else {
			require_login($course);
		}
		$PAGE->set_pagelayout('admin');
	}

    $PAGE->set_title("Attribution d'un thème");

	$institution = $_POST["institution"];
	$theme = $_POST["theme"];

	if($theme != ''){
		$themeName = get_string('pluginname', 'theme_'.$theme);
	}
	else{
		$themeName = "Défaut";
	}

	//echo($institution."<br>");
	//echo(get_string('pluginname', 'theme_'.$theme)."<br>");

	$sql = "UPDATE {user} SET theme = '$theme' WHERE institution = '$institution'";

	$return = $DB->execute($sql);

	if($return){
		if($institution != ''){
			$message = "L'attribution du thème <strong>".$themeName."</strong> aux utilisateurs dont le champ institution est égal à <strong>".$institution."</strong> s'est effectuée sans erreur.";
		}
		else{
			$message = "L'attribution du thème <strong>".$themeName."</strong> aux utilisateurs dont le champ institution <strong>n'est pas renseigné</strong> s'est effectuée sans erreur.";
		}
	}
	else{
		$message = "Une erreur s'est produite.";
	}

	echo $OUTPUT->header();
?>

<h2>Attribution d'un thème</h2>

<div class="alert alert-success alert-block fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <?php echo $message ?>
</div>

<div class="singlebutton">
	<form method="post" action="index.php">
		<div>
			<input value="Retour" type="submit">
		</div>
	</form>
</div>

<?php
	echo $OUTPUT->footer();
?>
