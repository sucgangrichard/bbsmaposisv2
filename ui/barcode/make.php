<html>
    <body>
        <center>
            <h1> Create Barcode </h1>
                <form action="make.php">
                    <?php
                    function generateRandomDigits($length = 8) {
                        return str_pad(mt_rand(0, 99999999), $length, '0', STR_PAD_LEFT);
                    }
                    $random1 = generateRandomDigits();
                    $random2 = generateRandomDigits();
                    $random3 = generateRandomDigits();
                    ?>
                    Enter barcode data 1: <input type="text" name="bar_code1" value="<?php echo $random1; ?>"><br>
                    Enter barcode data 2: <input type="text" name="bar_code2" value="<?php echo $random2; ?>"><br>
                    Enter barcode data 3: <input type="text" name="bar_code3" value="<?php echo $random3; ?>"><br>
                    <input type="submit" value="Create Barcode">
                </form>
            
            <?php
if(isset($_GET['bar_code1']) && isset($_GET['bar_code2']) && isset($_GET['bar_code3'])){
    $bar_code1 = $_GET['bar_code1'];
    $bar_code2 = $_GET['bar_code2'];
    $bar_code3 = $_GET['bar_code3'];
    include_once 'barcode128.php';
    echo "<h2>Barcode 1</h2>";
    echo bar128($bar_code1);
    echo "<h2>Barcode 2</h2>";
    echo bar128($bar_code2);
    echo "<h2>Barcode 3</h2>";
    echo bar128($bar_code3);
}
?>
        </center>
    </body>
</html>