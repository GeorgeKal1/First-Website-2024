<?php
// Σύνδεση με τη βάση δεδομένων
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Έλεγχος αν η σύνδεση ήταν επιτυχής
if ($conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}

if (isset($_POST['findm'])) {
    // Λήψη του email από τη φόρμα
    $email = $_POST['findm'];

    // SQL ερώτημα για την αναζήτηση παραγγελιών με βάση το email
    $sql = "SELECT Gender, FirstName, LastName, BirthDate, Category, PreferredColor, Quantity, Email, TermsAccepted 
            FROM orderform WHERE Email = ?";

    // Προετοιμασία του SQL ερωτήματος
    $stmt = $conn->prepare($sql);

    // Έλεγχος αν η προετοιμασία απέτυχε
    if ($stmt === false) {
        die("Σφάλμα στην προετοιμασία του SQL ερωτήματος: " . $conn->error);
    }

    // Σύνδεση των παραμέτρων με το SQL ερώτημα
    $stmt->bind_param("s", $email);

    // Εκτέλεση του ερωτήματος
    $stmt->execute();

    // Αποθήκευση των αποτελεσμάτων
    $result = $stmt->get_result();

    // Έλεγχος αν υπάρχουν αποτελέσματα
    if ($result->num_rows > 0) {
        // Δημιουργία πίνακα για την εμφάνιση των αποτελεσμάτων
        echo "<table border='1'>
                <tr>
                    <th>Όνομα</th>
                    <th>Επώνυμο</th>
                    <th>Ημερομηνία Γέννησης</th>
                    <th>Κατηγορία</th>
                    <th>Χρώμα Προτίμησης</th>
                    <th>Ποσότητα</th>
                    <th>Email</th>
                </tr>";

        // Εμφάνιση των αποτελεσμάτων σε κάθε γραμμή
        while ($row = $result->fetch_assoc()) {
            // Χρωματισμός της γραμμής ανάλογα με το χρώμα προτίμησης
            $preferredColor = $row['PreferredColor'];
            echo "<tr style='background-color: $preferredColor;'>
                    <td>" . $row['FirstName'] . "</td>
                    <td>" . $row['LastName'] . "</td>
                    <td>" . $row['BirthDate'] . "</td>
                    <td>" . $row['Category'] . "</td>
                    <td>" . $preferredColor . "</td>
                    <td>" . $row['Quantity'] . "</td>
                    <td>" . $row['Email'] . "</td>
                </tr>";
        }
        echo "</table>";
        echo "<br><a href=orders.html><button>Πίσω</button></a>";
    } else {
        echo "Δεν βρέθηκαν αποτελέσματα για το email: $email";
    }

    // Κλείσιμο της σύνδεσης με τη βάση δεδομένων
    $stmt->close();
    $conn->close();
}
?>
