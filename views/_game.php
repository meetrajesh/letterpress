<?
$game = $data['game'];
$myturn = (player::get_current()->id == $game->current_player->id);
$game_active = $myturn && !$game->is_game_over();
$other_player = (player::get_current()->id == $game->player1->id) ? $game->player2 : $game->player1;
$last_word_played = $game->last_word_played();
?>

<form method="post" action="<?=$this->_url($game->form_action())?>">
    <?=csrf::html_tag()?>

    <? if (empty($other_player->id)): ?>
        <p>Start a new game with (type friend&#39;s email):
        <input type="text" name="player2_email" size="30" /></p>
    <? elseif ($game->is_game_over()): ?>
        <p>
            <strong>Game over!</strong>
            <? if ($game->did_i_win()): ?>
                You won!
            <? else: ?>
				You lost :(
            <? endif; ?>
        </p>
    <? elseif ($myturn): ?>
        <p><strong>Your move with <?=hsc($other_player->email)?>!</strong></p>
		<? if (!empty($last_word_played)): ?>
			<p>They played: <?=hsc($last_word_played)?></p>
		<? endif; ?>
    <? else: ?>
        <p>Waiting for move from <?=hsc($other_player->email)?></p>
		<? if (!empty($last_word_played)): ?>
			<p>You played: <?=hsc($last_word_played)?></p>
		<? endif; ?>
	<? endif; ?>
    
	<? if ($game_active): ?>
		<input type="hidden" id="coords_<?=$game->id?>" name="coords" />
		<p class="letters">Your word: <span id="word_<?=$game->id?>"></span></p>
	<? endif; ?>
      
    <div class="<?=$game_active ? 'enabled' : 'disabled'?>" game-id="<?=$game->id?>">
        <table>
            <tr>
                <?php
                foreach ($game->letters as $i => $letter) {
                	if ($i != 0 && $i % 5 == 0) {
                		echo '</tr><tr>';
                	}
					// figure out the state of this tile
					$class = $game->get_tile_state($i);
					$class .= $game->is_tile_locked($i) ? ' locked' : '';
                	echo spf('<td class="%s" data-coord="%d">%s</td>', $class, hsc($i), hsc($letter));
                }
                ?>
            </tr>
        </table>
    </div>

    <p><input type="submit" name="btn_submit" value="Submit Move!" /></p>

    <? if (!empty($game->player2->id)): ?>
        <p><a class="warning" href="<?=$this->_url('/game/delete/' . $game->id)?>">Delete Game</a></p>
	<? endif; ?>
</form>


