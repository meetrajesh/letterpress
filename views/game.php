<table>
<tr>

<?php

foreach ($data['table'] as $i => $letter) {

    if ($i != 0 && $i % 5 == 0) {
        echo '</tr><tr>';
    }
    echo spf('<td data-coord="%d">%s</td>', hsc($i), hsc($letter));

}

?>

</tr>
</table>