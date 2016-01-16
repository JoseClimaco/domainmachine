<?php
ini_set('max_execution_time', 300);
include('DomainFinder.class.php');
include('Validate.class.php');
include('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DomainFinder</title>
    <link href="css/app.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
</head>
<body>
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
        <fieldset>
            <legend>Options</legend>
            <label for="min-length">Min Length</label>
            <input id="min-length" name="min-length" type="number" value="3">
            <label for="max-length">Max Length</label>
            <input id="max-length" name="max-length" type="number" value="8">
        </fieldset>
		<fieldset>
	    <legend>Tld</legend>
	    	<input type="checkbox" onClick="toggle(this)" /> Toggle All<br/>
		    	<div class="optionHolder">
				<?php		

                    foreach ( $initTlds as $tld )
                    {
                        echo '<div class="option"><input type="checkbox" name="options[]" value="'.$tld.'"/> '.$tld . '</div>';
                    }

				?>
			</div>
		</fieldset>
		<fieldset>
	    <legend>Language</legend>
		    <div class="optionHolder">
				<?php

				foreach ( $initLangs as $lang ) 
				{ 

					$path = $lang;
					$file = basename($path);         // $file is set to "index.php"
					$file = basename($path, ".txt"); // $file is set to "index"

					echo '<div class="option"><input type="checkbox" name="language[]" value="'.$lang.'"/> '.$file. '</div>';

				}

				?>
				<input class="submit" type="submit" value="Search!" />
			</div>
		</fieldset>
	</form>

	<?php
		if (!empty($_POST)) {

            $val = new Validate($_POST);

            $tlds       = $val->basic('options');
			$chooseLang = $val->basic('language');
			$maxSize    = $val->basic('max-length');
			$minSize    = $val->basic('min-length');



			foreach ($chooseLang as $lang) {

				$words = file($lang);

				$domain = new DomainFinder( $tlds, $words, $maxSize, $minSize );
				echo '<div id="results">';
				echo "<h1>Finding <b>[". implode(", ",$tlds) ."]</b> in " . $lang . "</h1>";
				$domain->giveResults();
				echo '</div>';
			}

		} else {
			echo "<h2>Choose options and click Go</h2>";
		}
	?>
</body>
</html>
