<?php
session_start();

// Ελέγχει αν η συνεδρία είναι νέα και καθαρίζει το αρχείο
if (!isset($_SESSION['initialized'])) {
    $_SESSION['initialized'] = true; // Σηματοδοτεί τη συνεδρία ως αρχικοποιημένη

    // Καθαρίζει το αρχείο αποτελεσμάτων
    $results_file = fopen('results.txt', "w"); // Άνοιγμα σε λειτουργία εγγραφής για διαγραφή του περιεχομένου
    if ($results_file) {
        fclose($results_file); // Κλείσιμο του αρχείου μετά τη διαγραφή
    } else {
        echo "<p>Cannot access the results file to initialize</p>";
        exit;
    }
}

// Αρχικοποιεί τις μεταβλητές της συνεδρίας αν δεν έχουν οριστεί
if (!isset($_SESSION['total_candidates'])) {
    $_SESSION['total_candidates'] = 0;
    $_SESSION['top_student_name'] = "";
    $_SESSION['successful_candidates'] = 0;
    $_SESSION['top_avg_count'] = 0;
    $_SESSION['highest_avg_score'] = -1; // Ελάχιστη αρχική βαθμολογία
    $_SESSION['total_scores'] = 0; // Σύνολο όλων των μέσων όρων
}

// Άνοιγμα του αρχείου αποτελεσμάτων σε λειτουργία προσθήκης για καταγραφή δεδομένων υποψηφίων
$results_file = fopen('results.txt', "a");
if (!$results_file) {
    echo "<p>Δεν έχουμε πρόσβαση στο αρχείο</p>";
    exit;
}

// Επεξεργασία αιτήματος POST
if ($_SERVER['REQUEST_METHOD'] == "POST" && 
    (isset($_POST['grade1'], $_POST['grade2'], $_POST['grade3'], $_POST['grade4'], $_POST['grade5'], $_POST['grade6']) || $_POST['candidate_name'] == 'ΤΕΛΟΣ')) {

    $candidate_name = htmlspecialchars($_POST['candidate_name']); // Αποτροπή XSS
    $grades = array_map('floatval', [
        $_POST['grade1'],
        $_POST['grade2'],
        $_POST['grade3'],
        $_POST['grade4'],
        $_POST['grade5'],
        $_POST['grade6']
    ]);

    // Διαχείριση της περίπτωσης "ΤΕΛΟΣ"
    if ($candidate_name === 'ΤΕΛΟΣ') {
        if ($_SESSION['total_candidates'] > 0) {
            $overall_average = $_SESSION['total_scores'] / $_SESSION['total_candidates'];
            fwrite($results_file, "\n Μέσο σκόρ όλων των συμμετεχόντων: $overall_average\n");

            echo "<h2>Αποτελέσματα</h2>";
            echo "Ποσοστό επιτυχιας " . ($_SESSION['successful_candidates'] / $_SESSION['total_candidates'] * 100) . "%<br>";
            if ($_SESSION['top_avg_count'] === 1) {
                echo "Ο κορυφαίος είναι ο/η: {$_SESSION['top_student_name']}<br>";
            } else {
                echo "Ο αριθμός των συμμετεχόντων με το μέγιστο σκορ: {$_SESSION['top_avg_count']}<br>";
            }
        } else {
            echo "Δεν έχουν καταγραφεί συμμετέχοντες .<br>";
        }

        session_destroy();
        fclose($results_file);
        exit;
    }

    // Υπολογισμός μέσου όρου βαθμολογίας
    $average_score = array_sum($grades) / count($grades);
    $_SESSION['total_candidates']++;
    $_SESSION['total_scores'] += $average_score;

    fwrite($results_file, "Name: $candidate_name, Grades: " . implode(", ", $grades) . ", Average Score: $average_score\n");

    // Καθορισμός επιτυχίας/αποτυχίας
    if ($average_score > 60) {
        $_SESSION['successful_candidates']++;
        echo "Ο/η συμμετέχων/ουσα {$candidate_name} είναι επιτυχής.<br>";
        echo "Ο μέσος βαθμός είναι: {$average_score}%<br>";
    } else {
        echo "Ο/η συμμετέχων/ουσα {$candidate_name} είναι ανεπιτυχής.<br>";
        echo "Ο μέσος βαθμός είναι: {$average_score}%<br>";
    }

    // Ενημέρωση στατιστικών για την υψηλότερη βαθμολογία
    if ($average_score > $_SESSION['highest_avg_score']) {
        $_SESSION['highest_avg_score'] = $average_score;
        $_SESSION['top_student_name'] = $candidate_name;
        $_SESSION['top_avg_count'] = 1;
    } elseif ($average_score == $_SESSION['highest_avg_score']) {
        $_SESSION['top_avg_count']++;
    }
}
?>
