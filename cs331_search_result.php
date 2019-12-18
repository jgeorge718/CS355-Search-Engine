<?php
header("Access-Control-Allow-Origin: *");
//display all error logs for debugging if necessary
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

//obtain data from SQL database
if (isset($_GET['submit'])) {
    $search_term = $_GET['wordEntered'];
    
    returnSearchData($search_term);
}

function returnSearchData($search_term)
{
    //MariaDB server information
    $servername = "mars.cs.qc.cuny.edu";
    $username   = "cama0204";
    $password   = "23830204";
    $dbname     = "cama0204";
    //create connection
    $conn       = new mysqli($servername, $username, $password, $dbname);
    //if unsuccesful connection, kill connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //SQL Query to return data
    $sql = "

SELECT *
FROM page, word, page_word
WHERE page.pageId = page_word.pageId
AND word.wordId = page_word.wordId
AND word.wordName = ‘" . wordEntered . "‘
ORDER BY freq desc;";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
            <div id=\"searchResults\" class=\"results\"> + <input type=\"checkbox\" name=\"check\">" . "<h4>" . $row[title] . "</h4>" . "<a href=" . $row["url"] . ">" . $row["url"] . "</a>" . "<p>" . $row["description"] . "</p>" . "<div>;

        ";
            
        }
        
        
    } else {
        echo "No results, maybe try indexing some pages...";
    }
    
    
    
    $conn->close();
    
    
    
}
?>