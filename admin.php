<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title></title>
   </head>
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <body>
      <div class="w3-container">
      <h1>This is our Admin page</h1>
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
      <form action="" method="post">
         Enter URL: <input type = "text" name="url" id = "value">
         <input type="submit" value="Submit" name = "submit">
      </form>
<?php
header("Access-Control-Allow-Origin: *");

if(isset($_POST['submit'])){
	
	crawl_page($_POST['url']);
	
}
function crawl_page($url)
{
	
    $dbhost = "mars.cs.qc.cuny.edu";
    $dbuser = "cama0204";
    $dbpass = "23830204";
    $db = "cama0204";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db, 3306);
	
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	
	
    $starttime = microtime(true);
    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);
    $anchors = $dom->getElementsByTagName('a');
    $nodes = $dom->getElementsByTagName('title');
    //get and display what you need:
    $title = strval($nodes->item(0)->nodeValue);
    $metas = $dom->getElementsByTagName('meta');
    $metaAr = [];
    for ($i = 0; $i < $metas->length; $i++)
    {
        $meta = $metas->item($i);
        // echo $meta;
        $metaAr = $meta;
        if($meta->getAttribute('name') == 'description')
            $description = strval($meta->getAttribute('content'));

        if($meta->getAttribute('name') == 'keywords')
            $keywords = $meta->getAttribute('content');
    }
    $ps = $dom->getElementsByTagName('p');
    $parray = [];

    //Index page
    $result = $conn->query("SELECT pageId FROM page WHERE url = '$url'");

    if($result->num_rows == 0) {
        //page never indexed
        $insertPage = "INSERT INTO Page (url, title, description, timeToIndex)
            VALUES ('$url', '$title', '$description', 0)";
        if ($conn->query($insertPage) === TRUE) {
		echo "New record created successfully";
		} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		}
        //Index word and pageword together
        //Get page id
        $pageQuery = $conn->query("SELECT pageId FROM Page WHERE url = '$url'");
        $pageRow = $pageQuery->fetch_assoc();
        $pageId = $pageRow["pageId"];
        foreach($ps as $element){
            $text = $element->textContent;
			echo "\n" . $text;
            if(trim($text) != ""){
                $words = explode(" ", $text);
                foreach($words as $word){
                    if(trim($word) != ""){
                        $word = '"' . $word . '"';
                        $wordResult = $conn->query("SELECT wordId FROM word WHERE wordName = $word");
							if ($wordResult = $conn->query($query)) {
								echo "RESULT: " .  print_r($wordResult->fetch_assoc());
								$wordResult->free_result();
							}
							
						echo $word;
                        if($wordResult->num_rows == 0) {
                            $insertWord = "INSERT INTO word (wordName)
                                VALUES ($word)";
								
								        if ($conn->query($insertWord) === TRUE) {
										echo "New record created successfully";
										} else {
										echo "Error: " . $sql . "<br>" . $conn->error;
										}
                            
                        }
                        // pageword part
                        // Get the word id for comparison
                        $wordQuery = $conn->query("SELECT wordId FROM word WHERE wordName = $word");
                        if($wordQuery->num_rows == 0) {
                            //Word isn't in table, something is wrong with escaped char
                        }
                        else {
                            $wordRow = $wordQuery->fetch_assoc();
                            $wordId = $wordRow["wordId"];
                            // Query for page word
                            $pageWordResult = $conn->query(
                                    "SELECT pageId, wordId  FROM page_word
                                    WHERE pageId = '$pageId' AND wordId = '$wordId'");
                            // If not in table yet, add
                            if($pageWordResult->num_rows == 0){
                                $insertPageWord = "INSERT INTO page_word (pageId, wordId, freq)
                                    VALUES ('$pageId','$wordId', 1)";
                            }
                            //else is in table, incr
                            else {
                                $insertPageWord = "UPDATE page_word
                                    SET freq = freq + 1
                                    WHERE pageId = '$pageId' AND wordId = '$wordId'";
                            }
                            mysqli_query($conn, $insertPageWord);
                        }
                    }
                }
            }
        }
        // Update time taken to index
        $endtime = microtime(true);
        $loadtime = $endtime - $starttime;
        $updatePage = "UPDATE page
            SET timeToIndex = $loadtime
            WHERE url = '$url'";
        mysqli_query($conn, $updatePage);
    }
    else {
        echo "row already exists";
    }
    $conn -> close();
}
crawl_page($_POST['url']);
echo "Indexed ",$_POST['url'];
?>

   </body>
</html>
