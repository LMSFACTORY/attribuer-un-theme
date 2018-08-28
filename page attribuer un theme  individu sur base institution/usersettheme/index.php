<?php

	require_once('../config.php');
	require_once($CFG->dirroot.'/user/editlib.php');

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

	// on construit le select des thèmes
	$themes = get_list_of_themes();

	$select_themes = "<select class=\"form-control\" name=\"theme\" id=\"theme\">\n";
	$select_themes .= " <option value=\"\">Défaut</option>\n";

	foreach ($themes as $key => $theme) {
		if (empty($theme->hidefromselector)) {
			//echo($theme->name.'   >   '.get_string('pluginname', 'theme_'.$theme->name).'<br>');

			$select_themes .= "<option value=\"".$theme->name."\">".get_string('pluginname', 'theme_'.$theme->name)."</option>\n";
		}
	}

	$select_themes .= "</select>\n";


	// on construit le select des thèmes
	$results = $DB->get_records_sql('SELECT institution FROM {user}');

	$select_institutions = "<select class=\"form-control\" name=\"institution\" id=\"institution\">\n";

	foreach ($results as $key => $result) {
		if($result->institution != ''){
			$institution = $result->institution;
		}
		else{
			$institution = 'Non renseigné';
		}
		$select_institutions .= "<option value=\"".$result->institution."\">".$institution."</option>\n";
	}
	$select_institutions .= "</select>\n";

	echo $OUTPUT->header();
?>

<h2>Attribution d'un thème</h2>
<h5>Attribuer un thème à tous les utilisteurs d'une même institution</h5>
<br>

<form action="attribution_process.php" method="post" accept-charset="utf-" id="form" class="mform">

	<fieldset>
	<div class="fitem fitem_fselect">
		<div class="fitemtitle">
			<label for="institution">Institution</label>
		</div>
		<div class="felement fselect" data-fieldtype="select">
			<?php echo $select_institutions;?>
		</div>
	</div>
	<div class="fitem fitem_fselect">
		<div class="fitemtitle">
			<label for="theme">Thème</label>
		</div>
		<div class="felement fselect" data-fieldtype="select">
			<?php echo $select_themes;?>
		</div>
	</div>
	</fieldset>

	<fieldset>
		<div>
			<div class="fitem fitem_actionbuttons fitem_fsubmit ">
				<div class="felement fsubmit" data-fieldtype="submit">
					<input name="submitbutton" value="Attribuer" type="submit">
				</div>
			</div>
		</div>
	</fieldset>

</form>

<?php
	echo $OUTPUT->footer();
?>

