<html>
    <head>
        <title>LAMP</title>
        <meta charset="utf-8"> 
    </head>
    <style>
    body { font-size: xx-large; font-family: monospace; } 
    table, th, td { font-size: xx-large; font-family: monospace; 
        border: 1px solid grey; border-collapse: collapse;
        padding: 7px } 
    </style>
    <body>
        <?php
        $conn = mysqli_connect('db', 'root', '1234', "dbDATA");
        echo "<pre>";
        echo "QUERY_STRING ".$_SERVER['QUERY_STRING']."\n";
        echo "SCRIPT_FILENAME ".$_SERVER['SCRIPT_FILENAME']."\n";
        echo "</pre>";
        $table = $_GET['table'] ?? 'Data';
        $query = 'SELECT * FROM '.$table;                
        echo "<h4>$query</h4>";
        
        echo '<table>';
        echo '<thead><tr><th></th>';
        $result = mysqli_query($conn, "SHOW COLUMNS FROM ".$table);
        if (!$result) {
            trigger_error('Invalid table: ' .$table);

        }else{
            while ($x = $result->fetch_array(MYSQLI_ASSOC)){
                echo '<th>'.$x['Field'].'</th>';
            }
            echo '</thead>';
            $result->close();
    
            $result = mysqli_query($conn, $query);
            while($value = $result->fetch_array(MYSQLI_ASSOC)){
                echo '<tr>';
                echo '<td></td>';
                foreach($value as $element){
                    echo '<td>' . $element . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
            $result->close();
        }
        mysqli_close($conn);
        ?>
    </body>
</html>