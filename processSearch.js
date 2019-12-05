function getSearchResults() {
  const customSearch = "";
  // Google API key ommitted
  var result = document.getElementById("displayText");
  result.innerHTML= "";
  var newsearchurl = customSearch + document.getElementById("search_words").value;
  var myHTTPRequest = new XMLHttpRequest();
  myHTTPRequest.open('GET', newsearchurl, true);
  myHTTPRequest.onload = function() {

    var links = JSON.parse(this.response);
    if (myHTTPRequest.status == 200) {
      var linksContainer = document.getElementById("displayText");

      for (i = 0; i < links["items"].length; ++i) {
         linksContainer.innerHTML +=
          '<div id="searchResults" class="results">' + '<input type="checkbox" name="check">' +
            "<h4>" +  links["items"][i].title + "</h4>" +
            '<a href="' + links["items"][i].formattedUrl + '">'+ links["items"][i].link + '</a>' +
            "<p>" + links["items"][i].snippet + "</p>" + "<div>";
      }
    }
    else {
     console.log("Did not search...");
    }
  }
  myHTTPRequest.send();
}

function selectAll() {
  var items = document.getElementsByName('check');
  for (i = 0; i < items.length; ++i) {
    if (items[i].type == 'checkbox')
      items[i].checked = true;
  }
}
function deselectAll() {
  var items = document.getElementsByName('check');
  for (i = 0; i < items.length; ++i) {
    if (items[i].type == 'checkbox')
      items[i].checked = false;
  }
}
