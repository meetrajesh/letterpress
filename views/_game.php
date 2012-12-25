<? $game = $data['game'] ?>

<form method="post" action="<?=$data['form_action']?>">
    <?=csrf::html_tag()?>

    <? if (empty($game->player2)): ?>
        <p>Start a new game with (type friend&#39;s email):
        <input type="text" name="player2_email" size="30" /></p>
    <? else: ?>
        <p>Your move with <?=hsc($game->player2->email)?>!</p>
	<? endif; ?>
    
    <input type="hidden" id="coords" name="coords" />
    <p id="letters">Your word: <span id="word"></span></p>
      
    <div class="table">
        <table>
            <tr>
                <?php
                foreach ($game->letters as $i => $letter) {
                	if ($i != 0 && $i % 5 == 0) {
                		echo '</tr><tr>';
                	}
					// figure out the state of this tile
					$class = '';
					if (player::get_current()->id == $game->player1_id && in_array($i, $game->player1_tiles) ||
						(player::get_current()->id == $game->player2_id && in_array($i, $game->player2_tiles))) {
						$class = 'cplayer';
					} elseif (player::get_current()->id == $game->player1_id && in_array($i, $game->player2_tiles) ||
						(player::get_current()->id == $game->player1_id && in_array($i, $game->player1_tiles))) {
						$class = 'oplayer';
					}
					if ($game->is_tile_locked($i)) {
						$class .= ' locked';
					}
                	echo spf('<td class="%s" data-coord="%d">%s</td>', $class, hsc($i), hsc($letter));
                }
                ?>
            </tr>
        </table>
    </div>

    <? if (empty($game->player2)): ?>
        <p><input type="submit" name="btn_submit" value="Start new game!" /></p>
    <? else: ?>
        <p><input type="submit" name="btn_submit" value="Submit Move!" /></p>
	<? endif; ?>
</form>


