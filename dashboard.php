<?php
/**
 * @file dashboard.php
 *
 * @brief Op deze pagina kunnen admins statistieken en informatie over de website zien.
 *
 * Admins kunnen hier klachten en andere informatie vinden.
 */

include 'utils/core_functions.php';
include 'utils/database_connection.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['rol'])) {
    // checkt of de gebruiker een admin is.\
    if ($_SESSION['rol'] != 'admin') {
        // functie uit core_functions.php als vervanger voor header()
        RedirectToPage('index.php');
    } else {
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <div><?php include 'menu.php'; ?></div>
    <button onclick="toggle_visibility('user_div')">Gebruikers</button>
    <button onclick="toggle_visibility('merk_div')">Merk</button>
    <div id="user_div" style="display: none;">
        <table id="user_tabel">
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Id</th>
                <th>Geverifieerd</th>
                <th>Rol</th>
            </tr>
            <?php
            $sql_userinfo = "select id, naam, email, rol, status_code from gebruiker";
            $resultaat_userinfo = $mysqli->query($sql_userinfo);
            while ($row = $resultaat_userinfo->fetch_assoc()) {
                echo "
                <tr>
                  <td>" . htmlentities($row['naam']) . "</td>
                  <td>" . htmlentities($row['email']) . "</td>
                  <td>" . htmlentities($row['id']) . "</td>
                  <td>" . htmlentities($row['status_code']) . "</td>
                  <td>" . htmlentities($row['rol']) . "</td>
                </tr>
                ";
            }
            ?>
        </table>
    </div>
    <?php
    $sql = "SELECT merk_naam, id FROM merk_fiets order by merk_naam asc";
    $result = $mysqli->query($sql);
    ?>
    <div id="merk_div" style="display: none;">
    <table id="merk_tabel">
            <tr>
                <th>Merk</th>
                <th>Id</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()){
                echo "
                <tr>
                    <td>" . htmlentities($row['merk_naam']) . "</td>
                    <td>" . htmlentities($row['id']) . "</td>
                </tr>
                ";
            }
            ?>
        </table>
    </div>
    <script src="js/dashboard.js"></script>
</body>
</html>
<?php
    }
} else {
    RedirectToPage('index.php');
}
?>