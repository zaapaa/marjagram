
var xhr2 = new XMLHttpRequest();

var getComments = function(){
  if(xhr2.readyState === 4 && xhr2.status === 200){
    var json = JSON.parse(xhr2.responseText);
    var output = '<p>';
    for(var i in json){
      output += ' &lt'+ json[i].Username + '&gt '+ json[i].MComment + '<br>';
                
    }
    output += '</p>';
    document.querySelector('#comment').innerHTML = output;
  }
}

xhr2.open('GET', 'includes/getComments.php');

xhr2.onreadystatechange = getComments;
xhr2.send();