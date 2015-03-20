<html>
<head>
    <title>finance app</title>
    <link rel="stylesheet" href="resources/css/main.css" type="text/css"/>

</head>
<body>
<form method="post">
    <label for="search_ipnut">search</label>
    <input type="text" name="search_input"/>
    <input type="submit" name="search" value="search stock"/>
</form>

<?php

if ( $data['stocks'] != [] ) {
    echo '<h2>Search results</h2><table class="table-section">'.
        '<thead><tr>'.
        '<td>Name</td>'.
        '<td>Symbol</td>'.
        '<td>LastPrice</td>'.
        '<td>Change</td>'.
        '<td>ChangePercent</td>'.
        '<td>Time</td>'.
        '<td>MSDate</td>'.
        '<td>MarketCap</td>'.
        '<td>Volume</td>'.
        '<td>ChangeYTD</td>'.
        '<td>ChangePercentYTD</td>'.
        '<td>High</td>'.
        '<td>Low</td>'.
        '<td>Open</td>'.
        '</tr></thead>'.
        '<tbody>';
    foreach($data['stocks'] as $stock) {
        echo '<tr>'.
            '<td>'.$stock->Name.'</td>'.
            '<td>'.$stock->Symbol.'</td>'.
            '<td>'.$stock->LastPrice.'</td>'.
            '<td>'.round($stock->Change, 4).'</td>'.
            '<td>'.round($stock->ChangePercent, 4).'</td>'.
            '<td>'.Date('H:i:s', time($stock->Timestamp)).'</td>'.
            '<td>'.$stock->MSDate.'</td>'.
            '<td>'.$stock->MarketCap.'</td>'.
            '<td>'.$stock->Volume.'</td>'.
            '<td>'.$stock->ChangeYTD.'</td>'.
            '<td>'.round($stock->ChangePercentYTD, 4).'</td>'.
            '<td>'.$stock->High.'</td>'.
            '<td>'.$stock->Low.'</td>'.
            '<td>'.$stock->Open.'</td>'.
            '</tr>';
    }
    echo '</tbody>'.
        '</table>';
}

if ($data['monitoredStocks'] != []) {

   echo '<h2>Monitored Stocks</h2><table class="table-section">'.
       '<thead><tr>'.
            '<td>Name</td>'.
            '<td>Symbol</td>'.
            '<td>LastPrice</td>'.
            '<td>Change</td>'.
            '<td>ChangePercent</td>'.
            '<td>Time</td>'.
            '<td>MSDate</td>'.
            '<td>MarketCap</td>'.
            '<td>Volume</td>'.
            '<td>ChangeYTD</td>'.
            '<td>ChangePercentYTD</td>'.
            '<td>High</td>'.
            '<td>Low</td>'.
            '<td>Open</td>'.
        '</tr></thead>'.
        '<tbody>';
    foreach($data['monitoredStocks'] as $stock) {
        echo '<tr>'.
                '<td>'.$stock->Name.'</td>'.
                '<td>'.$stock->Symbol.'</td>'.
                '<td>'.$stock->LastPrice.'</td>'.
                '<td>'.round($stock->Change, 4).'</td>'.
                '<td>'.round($stock->ChangePercent, 4).'</td>'.
                '<td>'.Date('H:i:s', time($stock->Timestamp)).'</td>'.
                '<td>'.$stock->MSDate.'</td>'.
                '<td>'.$stock->MarketCap.'</td>'.
                '<td>'.$stock->Volume.'</td>'.
                '<td>'.$stock->ChangeYTD.'</td>'.
                '<td>'.round($stock->ChangePercentYTD, 4).'</td>'.
                '<td>'.$stock->High.'</td>'.
                '<td>'.$stock->Low.'</td>'.
                '<td>'.$stock->Open.'</td>'.
            '</tr>';
    }
    echo '</tbody>'.
        '</table>';
}
?>


</body>
</html>