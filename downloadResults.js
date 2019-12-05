function download_csv() {

  var count = document.getElementsByName("check").length;

  var csvdata = "";
  for (i = 0; i < count; ++i) {
    if (document.getElementsByName("check")[i].checked == true) {
      var titleWords = document.getElementsByTagName("h4")[i].innerHTML;
      var newTitle = titleWords.replace(/,/g, '');
      csvdata += (newTitle) + ',';
      csvdata += (document.getElementsByTagName("a")[i].innerHTML) + ',';
      var words = document.getElementsByTagName("p")[i].innerHTML;
      var newWords = words.replace(/,/g, '');
      newWords = newWords.replace(/[\r\n]+/gm,'');
      csvdata += (newWords) + '\n';
    }
  }
  download(csvdata, ".csv");
}

function download_xml() {

  var count = document.getElementsByName("check").length;

  var xmldata = '<?xml version="1.0"?>\n';
  xmldata += ("<results>\n");
  for (i = 0; i < count; ++i) {
    if (document.getElementsByName("check")[i].checked == true) {
      xmldata += "  <result>\n";
        xmldata += "    <title>";
        xmldata += document.getElementsByTagName("h4")[i].innerHTML;
        xmldata += "</title>\n";
        xmldata += "    <url>";
        xmldata += document.getElementsByTagName("a")[i].innerHTML;
        xmldata += "</url>\n";
        xmldata += "    <description>";
        xmldata += document.getElementsByTagName("p")[i].innerHTML;
        xmldata += "</description>\n";
      xmldata += "  </result>\n";
    }
  }
  xmldata += ("</results>");

  download(xmldata, ".xml");
}

function download_json() {
  var count = document.getElementsByName("check").length;

  var jsondata = {"Result":[]};
  for (var i = 0; i < count; i++) {
  	if (document.getElementsByName("check")[i].checked == true) {
      var title = document.getElementsByTagName("h4")[i].innerHTML;
      var url =   document.getElementsByTagName("a")[i].innerHTML;
      var description = document.getElementsByTagName("p")[i].innerHTML;
      var result = {"title":title, "url":url, "description":description};
      jsondata["Result"].push(result);
    }
  }

  download(JSON.stringify(jsondata), ".json");
}

function download(data, ext) {
  var name = prompt("Please name your file: ");
  name += ext;

  var element = document.createElement('a');
  var downloadFile = new Blob([data], {'text/plain': 'text/plain'});
  element.setAttribute('href',  URL.createObjectURL(downloadFile));
  element.setAttribute('download', name);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
}
