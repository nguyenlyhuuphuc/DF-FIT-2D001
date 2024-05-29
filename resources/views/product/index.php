<h1>Product List</h1>
<?php 
    $scores = [3, 5, 6, 7, 1, 2, 9, 10];
    // $scores = [];
    //show table (stt, scores, note (6 -> dat, 5 <- khong dat),
    // dong chan in background xam)
?>

<table border="1">
    <tr>
        <th>STT</th>
        <th>Score</th>
        <th>Note</th>
    </tr>
    <?php 
        $stt = 1;
        foreach ($scores as $score) : 
    ?>
        <tr style="background-color: <?= $stt % 2 === 0 ? 'gray' : '' ?>;">
            <td><?= $stt++; ?></td>
            <td><?= $score ?></td>
            <td><?= $score > 5 ? 'Dat' : 'Khong dat' ?></td>
        </tr>
    <?php endforeach ?>

    <?php if(!count($scores)) : ?>
        <tr>
            <td colspan="3">No Data</td>
        </tr>
    <?php endif ?>
</table>