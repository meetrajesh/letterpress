<table>
<tr>

<?php

foreach ($data['table'] as $i => $letter) {

    if ($i != 0 && $i % 5 == 0) {
        echo '</tr><tr>';
    }
    echo '<td> ' . $letter . '</td>';
        
}

?>

</tr>
</table>