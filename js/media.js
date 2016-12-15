
var xhr = new XMLHttpRequest();

var showImages = function(){
  if(xhr.readyState === 4 && xhr.status === 200){
    var json = JSON.parse(xhr.responseText);
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
                        '<img src="'+json[i].Mediapath+'"></a>' +
                     '<figcaption>' +
                            '<h3>' + "Kuvaus: " + json[i].Description + '</h3>' +
                     '</figcaption>' +
                    '</figure>' +
                '</p>';
    }
    document.querySelector('#Img').innerHTML = output;
  }
}

xhr.open('GET', 'includes/getMedia.php');

xhr.onreadystatechange = showImages;
xhr.send();