<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php array 12/04/2025</title>
</head>
<body>
    <h1>Index Arrays</h1>
    <?php
        $car = array("Volvo", "BMW", "Toyota");
        echo "I like " . $car[0] . ", " . $car[1] . " and " . $car[2] . ".";
    ?>
    <h1>Associative Arrays</h1>
    <?php
        $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43", "Kong"=>"21");
        echo "Peter is " . $age['Peter'] . " years old."."<br>\n";
        echo "Ben is " . $age['Ben'] . " years old."."<br>\n";
        echo "Joe is " . $age['Joe'] . " years old."."<br>\n";
        echo "Kong is " . $age['Kong'] . " years old."."<br>\n";
    ?>
    <h1>How to use For with Index Arrays</h1>
    <?php
        $fluits = array("Banana", "Apple", "Orange", "Mango", "Watermelon", "Pineapple", "Grapes", "Strawberry");
        $arratLengeth = count($fluits);

        for($x = 0; $x < $arratLengeth; $x++) {
            echo $fluits[$x];
            echo "<br>\n";
        }
    ?>
    <h1>How to use Foreach with Index Arrays</h1>
    <?php
        $fluits = array("Banana", "Apple", "Orange", "Mango", "Watermelon", "Pineapple", "Grapes", "Strawberry");

        foreach($fluits as $value) {
            echo $value;
            echo "<br>\n";
        }
    ?>
    <h1>How to use Foreach with Associative Arrays</h1>
    <?php
        $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43", "Kong"=>"21");
        
        foreach($age as $x => $x_value) {
            echo "Key=" . $x . ", Value=" . $x_value;
            echo "<br>\n";
        }
    ?>
</body>
</html>
