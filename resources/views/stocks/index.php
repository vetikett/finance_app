<html>
<head>
    <title>finance app</title>
    <link rel="stylesheet" href="resources/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="resources/css/main.css" type="text/css"/>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
</head>
    <body>
        <p>User: <?php echo($stocks->first_name . " " . $stocks->last_name) ?> </p>
        <div>
            <p>Stock Name : <?php echo($stocks->name) ?> </p>
            <p>Cost: <?php echo($stocks->cost) ?> </p>
            <p>Info: <?php echo($stocks->info) ?> </p>
            <p>Holding: <?php echo($stocks->holding) ?> </p>
        </div>
    </body>
</html>