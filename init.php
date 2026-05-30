<!-- WARNING: Coded with the help of AI(s). Take precaution! -->

<?php

$dbServername = "localhost";
$dbUsername   = "root";
$dbPassword   = "";
$dbName       = "Kakumei_studios";

// Path to your SQL folder (relative to this file)
$sqlFolder = __DIR__ . "/SQLfile";

// Files where only the first statement should run (everything after first ; is ignored)
$firstStatementOnly = ["interest.sql", "notification.sql", "posts.sql"];

// Helper: strip -- line comments and /* block comments */ from SQL
function prepareSql(string $sql, bool $firstOnly = false): string {
    // Remove /* ... */ block comments
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
    // Remove -- line comments
    $sql = preg_replace('/--[^\n]*/m', '', $sql);
    // Collapse blank lines left behind
    $sql = preg_replace('/^\s*[\r\n]/m', '', $sql);
    $sql = trim($sql);

    // If firstOnly, truncate after the first semicolon
    if ($firstOnly) {
        $pos = strpos($sql, ';');
        if ($pos !== false) {
            $sql = substr($sql, 0, $pos + 1);
        }
    }

    return $sql;
}

// Step 1: Connect without selecting a database
$conn = new mysqli($dbServername, $dbUsername, $dbPassword);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "Database '$dbName' is ready.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Step 3: Select the database
$conn->select_db($dbName);

// Step 4: Find all .sql files in the SQL folder
$sqlFiles = glob($sqlFolder . "/*.sql");

if (empty($sqlFiles)) {
    die("No .sql files found in: $sqlFolder");
}

sort($sqlFiles); // Run in alphabetical order (e.g. 01_users.sql, 02_orders.sql)

// Step 5: Loop through each file and execute the SQL
foreach ($sqlFiles as $file) {
    $filename  = basename($file);
    $firstOnly = in_array($filename, $firstStatementOnly);
    $sql       = prepareSql(file_get_contents($file), $firstOnly);

    if ($sql === false || trim($sql) === "") {
        echo "Skipped '$filename' (empty or unreadable).<br>";
        continue;
    }

    if ($conn->multi_query($sql) === TRUE) {
        // Flush all result sets so the connection is ready for the next file
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());

        if ($conn->error) {
            echo "Error in '$filename': " . $conn->error . "<br>";
        } else {
            $note = $firstOnly ? " (first statement only)" : "";
            echo "Executed '$filename' successfully$note.<br>";
        }
    } else {
        echo "Error in '$filename': " . $conn->error . "<br>";
    }
}

$conn->close();
echo "<br>Initialization complete.";
