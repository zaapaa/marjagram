
var xhr3 = new XMLHttpRequest();

var getRatings = function(){
  if(xhr3.readyState === 4 && xhr3.status === 200){
	console.log(xhr3.responseText);
    var json = JSON.parse(xhr3.responseText);
    var value;
    var rounded;
    var total;
    
    for(var i in json){
    	value = json[i].avg;
    	total = json[i].count;
    }
    rounded = roundHalf(value);
    var stars = document.querySelectorAll('input[name="rating"]');
    
    for(var star of stars){
    	if(star.value == rounded){
    		star.checked = true;
    	}
    }
    
    document.querySelector("#ratingcount").innerHTML = "Arviointeja:"+total;
    document.querySelector("#ratingavg").innerHTML = "Keskiarvo:"+value;
    
  }
}

xhr3.open('GET', 'includes/getRating.php');

xhr3.onreadystatechange = getRatings;
xhr3.send();

function roundHalf(num) {
    return Math.round(num*2)/2;
}