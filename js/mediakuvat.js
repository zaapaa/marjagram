
var xhr4 = new XMLHttpRequest();

var showImages = function(){
  if(xhr4.readyState === 4 && xhr4.status === 200){
    var json = JSON.parse(xhr4.responseText);
    var output = '';
    for(var i in json){
      output += '<p>' +
                    '<figure>' +
                     '<figcaption>' +
                            '<h2>' + json[i].MName + '</h2>' +
                         '</figcaption>' +
                        '<figcaption>' +
                            '<h3>'+ "Lähettäjä: " + json[i].Username + '</h3>' +
                         '</figcaption>' +
                        '<a href = "media.php?id=' + json[i].MediaID + '"><img src="'+json[i].Mediapath+'"></a>' +
                            '<h3>' + "Kuvaus: " + json[i].Description + '</h3>' +
                         '</figcaption>' +
                    '</figure>' +
                '</p>';
    }
    document.querySelector('#SearchImg').innerHTML = output;
  }
}

xhr4.open('GET', 'includes/jsonKuvat2.php');
xhr4.onreadystatechange = showImages;
xhr4.send();