<? $game = $data['game'] ?>

<input type="hidden" id="gid" name="gid" value="<?=$game->id?>" />
<input type="hidden" id="coords" name="coords" />
<p id="letters"></p>
  
<table>
<tr>

<?php

foreach ($game->get_table() as $i => $letter) {

	if ($i != 0 && $i % 5 == 0) {
		echo '</tr><tr>';
	}
	echo spf('<td data-coord="%d">%s</td>', hsc($i), hsc($letter));

}

?>

</tr>
</table>