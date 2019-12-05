function startSearch() {

  const chosen = document.querySelector("input[type='file']");
  const file = chosen.files[0];
  const ext = file.name.split(".")[1];

  const reader = new FileReader();
  reader.onload = function(event) {
    if (ext === "csv") {
      const lines = reader.result.split("\n");

      var fields = {};
      var results = [];
      for (i = 0; i < lines.length-1; ++i) {
        fields = {title:lines[i].split(",")[0],
                  link:lines[i].split(",")[1],
                  description:lines[i].split(",")[2]};
        results[i] = fields;
      }

      for (i = 0; i < results.length; ++i) {
        document.getElementById("displayText").innerHTML +=
          "<div id=csvFile>" +
            '<input type="checkbox" name="check">' + "<h4>" + results[i].title + "</h4>" +
            '<a href="' + results[i].link + '">'+ results[i].link + '</a>' +
            "<p>" + results[i].description + "</p>" +
          "</div>";
      }
    }

    else if (ext === "xml") {
      const parser = new DOMParser();
      xmlDoc = parser.parseFromString(reader.result, "text/xml");

      const title = xmlDoc.getElementsByTagName("title");
      const link = xmlDoc.getElementsByTagName("url");
      const description = xmlDoc.getElementsByTagName("description");

      for (i = 0; i < title.length; ++i) {
        document.getElementById("displayText").innerHTML +=
        "<div id=xmlFile>" +
          '<input type="checkbox" name="check">' + "<h4>" + title[i].childNodes[0].nodeValue + "</h4>" +
          '<a href="' + link[i].childNodes[0].nodeValue + '">'+ link[i].childNodes[0].nodeValue + '</a>' + "<br>" +
          "<p>" + description[i].childNodes[0].nodeValue + "</p>" +
        "</div>";
      }
    }

    else if (ext === "json") {
      const results = JSON.parse(reader.result);
      const values = results.Result;

      for (i = 0; i < values.length; ++i) {
        document.getElementById("displayText").innerHTML +=
        "<div id=jsonFile>" +
          "<br>" +
          '<input type="checkbox" name="check">' + "<h4>" + values[i].title + "</h4>" +
          '<a href="' + values[i].url + '">'+ values[i].url + '</a>' +
          "<p>" + values[i].description + "</p>" +
        "<div>";
      }
    }
  }
  reader.readAsText(file);
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
