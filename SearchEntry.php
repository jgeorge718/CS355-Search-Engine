<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <body>
    <div class="w3-container">
      <h1>This is our Admin Page</h1>

      <div class="w3-bar w3-light-grey">
        <a href="index.html" class="w3-bar-item w3-button">Home</a>
        <div class="w3-dropdown-hover">
          <button class="w3-button">Course</button>
          <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="https://learn.zybooks.com/zybook/CUNYCSCI355TeitelmanFall2019?selectedPanel=student-activity" target="_blank" class="w3-bar-item w3-button">Zybook</a>
            <a href="https://app.tophat.com/e/648883/lecture/" target="_blank" class="w3-bar-item w3-button">TopHat</a>
            <a href="https://drive.google.com/drive/u/0/folders/1AsHhIFfQ3yNE_m2z4wswRfKh77K0UH9w" target="_blank" class="w3-bar-item w3-button">Google Drive</a>
            <a href="https://www.w3schools.com/" target="_blank" class="w3-bar-item w3-button">w3schools</a>
          </div>
        </div>
        <div class="w3-dropdown-hover">
          <button class="w3-button">Browser</button>
          <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="navigator.html" class="w3-bar-item w3-button">Navigator</a>
            <a href="window.html" class="w3-bar-item w3-button">Window</a>
            <a href="screen.html" class="w3-bar-item w3-button">Screen</a>
            <a href="location.html" class="w3-bar-item w3-button">Location</a>
            <a href="geolocation.html" class="w3-bar-item w3-button">Geolocation</a>
          </div>
        </div>
        <div class="w3-dropdown-hover">
          <button class="w3-button">About</button>
          <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="about.html" class="w3-bar-item w3-button">Meet the Developers</a>
            <a href="mailto:joel.george100@qmail.cuny.edu" class="w3-bar-item w3-button">Contact Us</a>
          </div>
        </div>
        <div class="w3-dropdown-hover">
          <button class="w3-button">Search</button>
          <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="searchFile.html" class="w3-bar-item w3-button">Search File</a>
            <a href="searchGoogle.html" class="w3-bar-item w3-button">Search Google</a>
          </div>
        </div>
        <div class="w3-dropdown-hover">
          <button class="w3-button">Admin</button>
          <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="admin.html" class="w3-bar-item w3-button">Admin Screen</a>
            <a href="SearchEntry.html" class="w3-bar-item w3-button">Search Entry</a>
          </div>
      </div>
	  

	  
    </div>
		  <form action="" method="get">
         Search for: <input type = "text" name="wordEntered" id = "wordEntered">
         <input type="submit" value="Submit" name="submit">
      </form>
	  
	  <?php
header("Access-Control-Allow-Origin: *");
//display all error logs for debugging if necessary
//ini_set('display_startup_errors', true);
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
        die('Connection failed: ' . $conn->connect_error);
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
  </body>
</html>
