<?
$game = $data['game'];
$myturn = (player::get_current()->id == $game->current_player->id);
$other_player = (player::get_current()->id == $game->player1->id) ? $game->player2 : $game->player1;
?>

<form method="post" action="<?=$this->_url($game->form_action())?>">
    <?=csrf::html_tag()?>

    <? if (empty($other_player->id)): ?>
        <p>Start a new game with (type friend&#39;s email):
        <input type="text" name="player2_email" size="30" /></p>
    <? elseif ($myturn): ?>
        <p><strong>Your move with <?=hsc($other_player->email)?>!</strong></p>
    <? else: ?>
        <p>Waiting for move from <?=hsc($other_player->email)?></p>
	<? endif; ?>
    
    <input type="hidden" id="coords_<?=$game->id?>" name="coords" />
    <p class="letters">Your word: <span id="word_<?=$game->id?>"></span></p>
      
    <div class="<?=$myturn ? 'enabled' : 'disabled'?>" game-id="<?=$game->id?>">
        <table>
            <tr>
                <?php
                foreach ($game->letters as $i => $letter) {
                	if ($i != 0 && $i % 5 == 0) {
                		echo '</tr><tr>';
                	}
					// figure out the state of this tile
					$class = '';
					if (player::get_current()->id == $game->player1->id) {
						if (in_array($i, $game->player1_tiles)) {
							$class = 'cplayer';
						} elseif (in_array($i, $game->player2_tiles)) {
							$class = 'oplayer';
						}
					} else { // i am player 2
						if (in_array($i, $game->player2_tiles)) {
							$class = 'cplayer';
						} elseif (in_array($i, $game->player1_tiles)) {
							$class = 'oplayer';
						}
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
    <? elseif ($myturn): ?>
        <p><input type="submit" name="btn_submit" value="Submit Move!" /></p>
	<? endif; ?>
</form>


