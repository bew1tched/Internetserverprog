<?php
$wishes = array(
    'wunsch1' => "",
    'wunsch2' => "",
    'wunsch3' => ""
);
$wisherrors = array(
    'wunsch1' => "",
    'wunsch2' => "",
    'wunsch3' => ""
);
$deliver = array(
    'name' => "",
    'telefon' => "",
    'ort' => ""
);
$delivererrors = array(
    'name' => "",
    'telefon' => "",
    'ort' => ""
);
$errorCOunter = 0;
$secondCounter = 0;

if (isset($_POST['form'])) {
    switch ($_POST['form']) {
        case "wunsch":
            foreach ($wishes as $key => $value) {
                if (empty($_POST[$key])) {
                    $wisherrors[$key] = "Wunsch bitte ausfüllen.";
                    $errorCOunter++;
                } else {
                    $wishes[$key] = ($_POST[$key]);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[\da-zA-Z-' ]*$/", $wishes[$key])) {
                        $wisherrors[$key] = "Sonderzeichen sind nicht erlaubt!";
                        $errorCOunter++;
                    }
                }
            }

            // Redirection to another page
            if ($errorCOunter == 0) {
                session_start();
                $_SESSION['wishes'] = $wishes;
                header("Location: index.php?status=wishes");
                exit;
            }
            break;
        case "address":
            foreach ($deliver as $key => $value) {
                if (empty($_POST[$key])) {
                    $delivererrors[$key] = "Bitte ausfüllen.";
                    $secondCounter++;
                } else {
                    $deliver[$key] = ($_POST[$key]);
                    if ($key == 'name') {
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z-' ]*$/", $deliver[$key])) {
                            $delivererrors[$key] = "Zahlen und Sonderzeichen nicht erlaubt.";
                            $secondCounter++;
                        }
                    }
                    if ($key == 'telefon') {
                        // check if telefon has only digits
                        if (!preg_match("/^\d*$/", $deliver[$key])) {
                            $delivererrors[$key] = "Telefonnummer überprüfen";
                            $secondCounter++;
                        }
                    }
                    if ($key == 'ort') {
                        // check if 5 digits and string
                        if (!preg_match("/(\d{5})(\s){1}([a-zA-Z-' ]*)$/", $deliver[$key])) {
                            $delivererrors[$key] = "PLZ und Ort überprüfen";
                            $secondCounter++;
                        }
                    }
                }
            }

            session_start();
            $_SESSION['deliver'] = $deliver;
            $_SESSION['delivererrors'] = $delivererrors;
            // Redirection to another page
            if ($secondCounter == 0) {
                header("Location: index.php?status=address");
            } else {
                header("Location: index.php?status=wishes");
            }
            exit;
    }
}
?>

<?php if (isset($_GET["status"]) and $_GET["status"] == "wishes") { ?>
    <h1>Lieferangaben</h1>
    <ol>
        <?php
        session_start();
        $i = 1;
        foreach ($_SESSION['wishes'] as $wish) {
            echo "<p>";
            echo $i;
            echo ".Wunsch: ";
            echo $wish;
            echo "</p>";
            $i++;
        }
        ?>
    </ol>
    <h2>Lieferadresse</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <th><label for="name">Vor- und Nachname</label></th>
                <td><input type="text" name="name" id="name" value="<?php echo $_SESSION['deliver']['name']; ?>"></td>
                <td class="error"><?php echo $_SESSION['delivererrors']['name']; ?></td>
            </tr>
            <tr>
                <th><label for="telefon">Telefon</label></th>
                <td><input type="text" name="telefon" id="telefon"
                           value="<?php echo $_SESSION['deliver']['telefon']; ?>"></td>
                <td class="error"><?php echo $_SESSION['delivererrors']['telefon']; ?></td>
            </tr>
            <tr>
                <th><label for="ort">PLZ, Ort</label></th>
                <td><input type="text" name="ort" id="ort" value="<?php echo $_SESSION['deliver']['ort']; ?>"></td>
                <td class="error"><?php echo $_SESSION['delivererrors']['ort']; ?></td>
            </tr>
        </table>
        <input type="hidden" name="form" value="address">
        <button type="submit">Abschicken</button>
    </form>

<?php } elseif (isset($_GET["status"]) and $_GET["status"] == "address") { ?>
    <h1>Wunschübersicht</h1>
    <?php
    session_start();
    $i = 1;
    foreach ($_SESSION['wishes'] as $wish) {
        echo "<p>";
        echo $i;
        echo ".Wunsch: ";
        echo $wish;
        echo "</p>";
        $i++;
    }

    echo "<p> Name: ";
    echo $_SESSION['deliver']['name'];
    echo "</p>";
    echo "<p> Telefon: ";
    echo $_SESSION['deliver']['telefon'];
    echo "</p>";
    echo "<p> Ort: ";
    echo $_SESSION['deliver']['ort'];
    echo "</p>";
    ?>

<?php } else { ?>
    <h1>Mein Wunschzettel</h1>
    <p>Bitte 3 Wünsche eingeben!</p>

    <form method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <th><label for="wunsch1">Wunsch 1</label></th>
                <td><input type="text" name="wunsch1" id="wunsch1" value="<?php echo $wishes['wunsch1']; ?>"></td>
                <td class="error"><?php echo $wisherrors['wunsch1']; ?></td>
            </tr>
            <tr>
                <th><label for="wunsch2">Wunsch 2</label></th>
                <td><input type="text" name="wunsch2" id="wunsch2" value="<?php echo $wishes['wunsch2']; ?>"></td>
                <td class="error"><?php echo $wisherrors['wunsch2']; ?></td>

            </tr>
            <tr>
                <th><label for="wunsch3">Wunsch 3</label></th>
                <td><input type="text" name="wunsch3" id="wunsch3" value="<?php echo $wishes['wunsch3']; ?>"></td>
                <td class="error"><?php echo $wisherrors['wunsch3']; ?></td>

            </tr>
        </table>
        <input type="hidden" name="form" value="wunsch">
        <button type="submit">Abschicken</button>
        <input type="reset" value="Abbrechen">
    </form>
<?php } ?>