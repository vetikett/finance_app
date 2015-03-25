<html>
<head>
    <title>finance app</title>
    <link rel="stylesheet" href="resources/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="resources/css/main.css" type="text/css"/>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
</head>
<body>

<div class="container-fluid">

    <h1 class="text-center">Finance App</h1>
    <form class="search" method="post">
        <input class="text-search" type="text" name="search_input"/>
        <input class="submit-search btn btn-primary" type="submit" name="search" value="search stock"/>
    </form>

    <?php
    if( isset($_SESSION['flash']) ) {
        echo '<div class="flash"><p class="text-center flash-msg">'.$_SESSION['flash'].'</p></div>';
        unset($_SESSION['flash']);
    }


    if ( $data['stocks'] != [] ) {
        echo '<h2>Search results</h2><table class="table table-bordered table-striped table-section">'.
            '<thead><tr>'.
                '<td class="form-section">Purchase And Watch Stocks</td>'.
                '<td>Name</td>'.
                '<td>Symbol</td>'.
                '<td>Price</td>'.
                '<td>Volume</td>'.
                '<td>Change</td>'.
                '<td>Time</td>'.
            '</tr></thead>'.
            '<tbody>';
        foreach($data['stocks'] as $stock) {
            echo '<tr>'.
                    '<td class="form-section">'.
                        '<form action="stocks/buy" method="post" class="form-inline first-form">'.
                        '<input type="hidden" name="name" value="'.$stock->Name.'">'.
                        '<input type="hidden" name="symbol" value="'.$stock->Symbol.'">'.
                        '<input type="hidden" name="cost" value="'.round($stock->LastPrice).'">'.
                        '<input class="btn btn-success buy" name="buy" type="submit" value="Buy">'.
                        '<input class="btn btn-success quantity" name="quantity" type="number" value="1" min="1" max="'.$stock->Volume.'">'.
                        '<p>Total: $<span class="total-amount">'.round($stock->LastPrice).'</span></p>'.
                        '</form>'.
                        '<form method="post" class="form-inline"><input class="btn btn-danger" type="submit" value="Watch"></form>'.
                    '</td>'.
                    '<td>'.$stock->Name.'</td>'.
                    '<td>'.$stock->Symbol.'</td>'.
                    '<td>$'.round($stock->LastPrice).'</td>'.
                    '<td>'.$stock->Volume.'</td>'.
                    '<td>'.round($stock->ChangePercent, 2).' %</td>'.
                    '<td>'.Date('H:i:s', time($stock->Timestamp)).'</td>'.
                '</tr>';
        }
        echo '</tbody>'.
            '</table>';
    }

    if ($data['monitoredStocks'] != []) {

       echo '<h2>Monitored Stocks</h2><table class="table table-bordered table-striped table-section">'.
           '<thead><tr>'.
                '<td class="form-section">Purchase And Monitor Stocks</td>'.
                '<td>Name</td>'.
                '<td>Symbol</td>'.
                '<td>Price</td>'.
                '<td>Volume</td>'.
                '<td>Change</td>'.
                '<td>Time</td>'.
            '</tr></thead>'.
            '<tbody>';
        foreach($data['monitoredStocks'] as $stock) {
            echo '<tr>'.
                    '<td class="form-section">'.
                        '<form action="stocks/buy" method="post" class="form-inline first-form">'.
                            '<input type="hidden" name="name" value="'.$stock->Name.'">'.
                            '<input type="hidden" name="symbol" value="'.$stock->Symbol.'">'.
                            '<input type="hidden" name="cost" value="'.round($stock->LastPrice).'">'.
                            '<input class="btn btn-success buy" name="buy" type="submit" value="Buy">'.
                            '<input class="btn btn-success quantity" name="quantity" type="number" value="1" min="1" max="'.$stock->Volume.'">'.
                            '<p>Total: $<span class="total-amount">'.round($stock->LastPrice).'</span></p>'.
                        '</form>'.
                        '<form method="post" class="form-inline"><input class="btn btn-danger" type="submit" value="Unwatch"></form>'.
                    '</td>'.
                    '<td>'.$stock->Name.'</td>'.
                    '<td>'.$stock->Symbol.'</td>'.
                    '<td>$'.round($stock->LastPrice).'</td>'.
                    '<td>'.$stock->Volume.'</td>'.
                    '<td>'.round($stock->ChangePercent, 2).' %</td>'.
                    '<td>'.Date('H:i:s', time($stock->Timestamp)).'</td>'.
                '</tr>';
        }
        echo '</tbody>'.
            '</table>';
    }
    ?>

</div>

<script>
    $(document).ready(function() {
        $('.quantity').click(function() {
            $quantity = $(this).val();
            $price = $(this).prev().prev().val();
            $amount = $(this).next().children('span');
            $total = $price * $quantity;
            $amount.text($total);
        });

        $('.flash').delay(2000).fadeOut();
    });
</script>
</body>
</html>