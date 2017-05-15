<?php
require_once('login-inc.php');#
if (is_logged_in() && $_SESSION['level'] == 'admin') {
    require('header.php');
    require('connectDB.php');
    if (isset($_POST['edit_item_button'])) {

        $ID = $_POST['ID'];
        $NAME = "'" . $_POST['ItemName'] . "'";
        $VERKAEUFER = "'" . $_POST['Verkaeufer'] . "'";
        $GARANTIE = "'" . $_POST['Garantie'] . "'";
        $PROBLEM = "'" . $_POST['Problem'] . "'";

        $howmuch = runSQL("SELECT * FROM geraete WHERE ID = $_POST[OLD_ID]");
        $data = mysqli_fetch_array($howmuch, MYSQLI_NUM);
        $howmuch2 = runSQL("SELECT * FROM geraete WHERE ID = $_POST[ID]");
        $data2 = mysqli_fetch_array($howmuch2, MYSQLI_NUM);

        if ($data[0] >= 1) {
            if (!($data2[0] >= 1)) {
                if (($ID != NULL) && ($NAME != NULL)) {
                    $db_res = runSQL('UPDATE geraete SET ID = ' . $ID . ', ItemName = ' . $NAME . ', Verkaeufer = ' . $VERKAEUFER . ', Garantie_bis = ' . $GARANTIE . ', Probleme  = ' . $PROBLEM . ' WHERE ID = ' . $_POST[OLD_ID]);
                    echo("<p>Das Gerät wurde <span style='font-weight: bold'>erfolgreich</span> editiert</p>");
                    echo("<p>Weiterleitung...</p>");
                    echo("<meta http-equiv=\"refresh\" content=\"2; URL=controll.php\">");
                } else {
                    echo "<a>Jedes Gerät muss eine ID besitzen!</a>";
                    echo("<p>Weiterleitung...</p>");
                    echo("<meta http-equiv=\"refresh\" content=\"2; URL=controll.php\">");
                }
            } else {
                echo("<a>Es gibt schon ein Gerät mit dieser ID!</a>");
                echo("<p>Weiterleitung...</p>");
                echo("<meta http-equiv=\"refresh\" content=\"2; URL=controll.php\">");
            }
        } else {
            echo("<p>Es gibt kein Gerät mit dieser ID");
            echo("<p>Weiterleitung...</p>");
            echo("<meta http-equiv=\"refresh\" content=\"2; URL=controll.php\">");
        }
    } else {
        ?>
        <div id="content">
        <h1>Gerät editieren</h1>
        <p>Hier kann man ein Gerät editieren.</p>
        <?php if (isset($_GET['id'])) {
            $getid = $_GET['id'];
            echo("ALTE ID:<input type='number' value='$getid' name='OLD_ID'>");
                ?>
            <br>
            <br>
            NEUE ID:<input type="number" name="ID"><br>
            Name:<input type="text" name="ItemName"><br>
            Verkäufer:<input type="text" name="Verkaeufer"><br>
            Garantie:<input type="text" name="Garantie"><br>
            Problem:<input type="text" name="Problem"><br><br>
            <input type="submit" name="edit_item_button">
            <?php
        } else {
            ?>
            <form action="edit_item.php" method="post">
                ALTE ID:<input type="number" name="OLD_ID">
                <br>
                <br>
                NEUE ID:<input type="number" name="ID"><br>
                Name:<input type="text" name="ItemName"><br>
                Verkäufer:<input type="text" name="Verkaeufer"><br>
                Garantie:<input type="text" name="Garantie"><br>
                Problem:<input type="text" name="Problem"><br><br>
                <input type="submit" name="edit_item_button">
            </form>
            </div>

            <?php
        }
        require('footer.php');
    }
} else {
    echo "Diese Seite ist nur für Admins verfügbar";
}
?>