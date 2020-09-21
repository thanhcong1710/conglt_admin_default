function processAuthen(error) {
    // console.log(error.response.data);
    // console.log(error.response.status);
    // console.log(error.response.headers);
    try {
        if (error.response.status == 401) {
            window.location.href = '/#/login';
        }
    } catch (err) {}

}
function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;
  
    // While there remain elements to shuffle...
    while (0 !== currentIndex) {
  
      // Pick a remaining element...
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;
  
      // And swap it with the current element.
      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }
  
    return array;
  }

export default {
    processAuthen,
    shuffle,
}
