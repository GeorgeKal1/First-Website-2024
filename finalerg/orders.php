<?php
// Σύνδεση με τη βάση δεδομένων
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "final"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Έλεγχος αν η σύνδεση ήταν επιτυχής
    if ($conn->connect_error) {
        die("Η σύνδεση απέτυχε: " . $conn->connect_error);
    }

    // Λήψη των δεδομένων από τη φόρμα
    $gender = $_POST['gender'];
    $firstName = $_POST['name'];
    $lastName = $_POST['lname'];
    $birthDate = $_POST['birth'];
    $category = $_POST['category'];
    $preferredColor = $_POST['color'];
    $quantity = $_POST['quan'];
    $email = $_POST['mail'];
    $termsAccepted = isset($_POST['check']) ? 1 : 0; // Set boolean for terms acceptance

    // SQL ερώτημα για την εισαγωγή των δεδομένων στη βάση δεδομένων
    $sql = "INSERT INTO orderform (Gender, FirstName, LastName, BirthDate, Category, PreferredColor, Quantity, Email, TermsAccepted)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Προετοιμασία του SQL ερωτήματος
    $stmt = $conn->prepare($sql);

    // Έλεγχος αν η προετοιμασία απέτυχε
    if ($stmt === false) {
        die("Σφάλμα στην προετοιμασία του SQL ερωτήματος: " . $conn->error);
    }

    // Σύνδεση των παραμέτρων με το SQL ερώτημα
    $stmt->bind_param("ssssssssi", $gender, $firstName, $lastName, $birthDate, $category, $preferredColor, $quantity, $email, $termsAccepted);

    // Εκτέλεση του ερωτήματος
    if ($stmt->execute()) {
        echo "Η παραγγελία αποθηκεύτηκε επιτυχώς!";
        echo "<br>";
        echo "<a href=orders.html><button>Πίσω</button></a>";
    } else {
        echo "Σφάλμα: " . $stmt->error;
    }


    // Κλείσιμο της σύνδεσης με τη βάση δεδομένων
    $stmt->close();
    $conn->close();
}
?>
