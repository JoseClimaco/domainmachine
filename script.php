<?php
ini_set('max_execution_time', 300);
include('DomainFinder.class.php');
include('Validate.class.php');

$initLangs = glob("langs/*.txt");
$initTlds  = array( 'ac', 'ad', 'ae', 'ag', 'ai', 'al', 'am', 'ao', 'aq', 'ar', 'as', 'at', 'au', 'az', 'ba', 'bb', 'be',
        'bf', 'bg', 'bh', 'bi', 'bm', 'bn', 'br', 'bt', 'by', 'bz', 'ca', 'cc', 'cd', 'cf', 'cg', 'ch', 'ci', 'ck', 'cl',
        'cm', 'cn', 'co', 'cr', 'cu', 'cx', 'cy', 'cz', 'de', 'dj', 'dk', 'do', 'ec', 'ee', 'eg', 'es', 'et', 'fi', 'fj',
        'fk', 'fm', 'fo', 'fr', 'gb', 'ge', 'gf', 'gg', 'gh', 'gi', 'gl', 'gm', 'gn', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu',
        'hk', 'hm', 'hn', 'hr', 'hu', 'id', 'ie', 'il', 'im', 'in', 'io', 'ir', 'is', 'it', 'je', 'jo', 'jp', 'ke', 'kg',
        'kh', 'kr', 'kw', 'ky', 'kz', 'lb', 'lc', 'li', 'lk', 'lt', 'lu', 'lv', 'ly', 'mc', 'md', 'mg', 'mh', 'mk', 'mm',
        'mn', 'mo', 'mq', 'mr', 'ms', 'mt', 'mu', 'mw', 'mx', 'my', 'mz', 'na', 'nc', 'nf', 'ni', 'nl', 'no', 'nu', 'nz',
        'om', 'pa', 'pe', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'pt', 'py', 'qa', 're', 'ro', 'ru', 'rw', 'sa', 'sb',
        'sc', 'sd', 'se', 'sg', 'sh', 'si', 'sk', 'sm', 'sn', 'so', 'st', 'su', 'sv', 'sz', 'tc', 'td', 'tf', 'th', 'tj',
        'tm', 'tn', 'to', 'tp', 'tr', 'tt', 'tv', 'tw', 'tz', 'ua', 'ug', 'uk', 'um', 'us', 'uy', 'uz', 've', 'vg', 'vi',
        'vn', 'vu', 'wf', 'yt', 'yu', 'za', 'zm', 'zr', 'zw');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DomainFinder</title>
    <link href="css/app.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
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
