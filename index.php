<?php
$wunsch1err = $wunsch2err = $wunsch3err = "";
$wunsch1 = $wunsch2 = $wunsch3 = "";
$name = $telefon = $ort = "";
$nameerr = $telefonerr = $orterr = "";

$errorCOunter = 0;
$secondCounter = 0;
if (isset($_POST['form'])) {
    switch ($_POST['form']) {
        case "wunsch":

            if (empty($_POST["wunsch1"])) {
                $wunsch1err = "wunsch1 is required";
                $errorCOunter++;
            } else {
                $wunsch1 = ($_POST["wunsch1"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[\da-zA-Z-' ]*$/", $wunsch1)) {
                    $wunsch1err = "Sonderzeichen sind nicht erlaubt";
                    $errorCOunter++;

                }
            }

            if (empty($_POST["wunsch2"])) {
                $wunsch2err = "wunsch2 is required";
                $errorCOunter++;

            } else {
                $wunsch2 = ($_POST["wunsch2"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[\da-zA-Z-' ]*$/", $wunsch2)) {
                    $wunsch2err = "Sonderzeichen sind nicht erlaubt";
                    $errorCOunter++;
                }
            }

            if (empty($_POST["wunsch3"])) {
                $wunsch3err = "wunsch3 is required";
                $errorCOunter++;

            } else {
                $wunsch3 = ($_POST["wunsch3"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[\da-zA-Z-' ]*$/", $wunsch3)) {
                    $wunsch3err = "Sonderzeichen sind nicht erlaubt";
                    $errorCOunter++;

                }
            }

            // Redirection to another page
            if ($errorCOunter == 0) {

                session_start();

                $_SESSION['wunsch1'] = $wunsch1;
                $_SESSION['wunsch2'] = $wunsch2;
                $_SESSION['wunsch3'] = $wunsch3;

                header("Location: index.php?status=wishes&var4=$nameerr&var5=$telefonerr&var6=$orterr");
                exit;
            }
            break;
        case "address":

            if (empty($_POST["name"])) {
                $nameerr = "name is required";
                $secondCounter++;
            } else {
                $name = ($_POST["name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                    $nameerr = "Namen überprüfen";
                    $secondCounter++;

                }
            }

            if (empty($_POST["telefon"])) {
                $telefonerr = "telefon is required";
                $secondCounter++;

            } else {
                $telefon = ($_POST["telefon"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^\d*$/", $telefon)) {
                    $telefonerr = "Telefonnummer überprüfen";
                    $secondCounter++;
                }
            }

            if (empty($_POST["ort"])) {
                $orterr = "ort is required";
                $secondCounter++;

            } else {
                $ort = ($_POST["ort"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/(\d{5})(\s){1}([a-zA-Z-' ]*)$/", $ort)) {
                    $orterr = "PLZ und Ort überprüfen";
                    $secondCounter++;

                }
            }
            session_start();

            $_SESSION['name'] = $name;
            $_SESSION['telefon'] = $telefon;
            $_SESSION['ort'] = $ort;
            // Redirection to another page
            if ($secondCounter == 0) {

                header("Location: index.php?status=address&var4=$name&var5=$telefon&var6=$ort");
                exit;
            } else {
                header("Location: index.php?status=wishes&var4=$nameerr&var5=$telefonerr&var6=$orterr");
                exit;
            }
    }
}
?>

<?php if (isset($_GET["status"]) and $_GET["status"] == "wishes") { ?>
    <h1>Lieferangaben</h1>

    <ol>
        <?php
        session_start();

        echo "<p> 1.Wunsch: ";
        echo $_SESSION['wunsch1'];
        echo "</p>";
        echo "<p> 2.Wunsch: ";
        echo $_SESSION['wunsch2'];
        echo "</p>";
        echo "<p> 3.Wunsch: ";
        echo $_SESSION['wunsch3'];
        echo "</p>";

        ?>
    </ol>

    <h2>Lieferadresse</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <th><label for="name">Vor- und Nachname</label></th>
                <td><input type="text" name="name" id="name" value="<?php echo $_SESSION['name']; ?>"></td>
                <td class="error"><?php echo $_GET['var4']; ?></td>

            </tr>
            <tr>
                <th><label for="telefon">Telefon</label></th>
                <td><input type="text" name="telefon" id="telefon" value="<?php echo $_SESSION['telefon']; ?>"></td>
                <td class="error"><?php echo $_GET['var5']; ?></td>

            </tr>
            <tr>
                <th><label for="ort">PLZ, Ort</label></th>
                <td><input type="text" name="ort" id="ort" value="<?php echo $_SESSION['ort']; ?>"></td>
                <td class="error"><?php echo $_GET['var6']; ?></td>

            </tr>



        </table>
        <input type="hidden" name="form" value="address">
        <button type="submit">Abschicken</button>
    </form>


<?php } elseif (isset($_GET["status"]) and $_GET["status"] == "address") { ?>
    <h1>Wunschübersicht</h1>
    <?php
    session_start();

    echo "<p> 1.Wunsch: ";
    echo $_SESSION['wunsch1'];
    echo "</p>";
    echo "<p> 2.Wunsch: ";
    echo $_SESSION['wunsch2'];
    echo "</p>";
    echo "<p> 3.Wunsch: ";
    echo $_SESSION['wunsch3'];
    echo "</p>";


    echo "<p> Name: ";
    echo $_SESSION['name'];
    echo "</p>";
    echo "<p> Telefon: ";
    echo $_SESSION['telefon'];
    echo "</p>";
    echo "<p> Ort: ";
    echo $_SESSION['ort'];
    echo "</p>";

    ?>


<?php } else { ?>
    <h1>Mein Wunschzettel</h1>
    <p>Bitte 3 Wünsche eingeben!</p>

    <form method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <th><label for="wunsch1">Wunsch 1</label></th>
                <td><input type="text" name="wunsch1" id="wunsch1" value="<?php echo $wunsch1; ?>"></td>
                <td class="error"><?php echo $wunsch1err; ?></td>
            </tr>
            <tr>
                <th><label for="wunsch2">Wunsch 2</label></th>
                <td><input type="text" name="wunsch2" id="wunsch2" value="<?php echo $wunsch2; ?>"></td>
                <td class="error"><?php echo $wunsch2err; ?></td>

            </tr>
            <tr>
                <th><label for="wunsch3">Wunsch 3</label></th>
                <td><input type="text" name="wunsch3" id="wunsch3" value="<?php echo $wunsch3; ?>"></td>
                <td class="error"><?php echo $wunsch3err; ?></td>

            </tr>
        </table>
        <input type="hidden" name="form" value="wunsch">
        <button type="submit">Abschicken</button>

        <input type="reset" value="Abbrechen">
    </form>
<?php } ?>