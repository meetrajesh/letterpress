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
    <p id="letters"></p>
      
    <div class="table">
        <table>
            <tr>
                <?php
                foreach ($game->letters as $i => $letter) {
                	if ($i != 0 && $i % 5 == 0) {
                		echo '</tr><tr>';
                	}
                	echo spf('<td data-coord="%d">%s</td>', hsc($i), hsc($letter));
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


