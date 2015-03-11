<html>
<head>
    <title>finance app</title>
    <link rel="stylesheet" href="resources/css/main.css" type="text/css"/>
</head>
    <body>
        <p><?php echo($stocks->first_name . " " . $stocks->last_name) ?> </p>
        <div>
            <p><?php echo($stocks->name) ?> </p>
            <p><?php echo($stocks->cost) ?> </p>
            <p><?php echo($stocks->info) ?> </p>
            <p><?php echo($stocks->holding) ?> </p>

        </div>
    </body>
</html>