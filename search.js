

function getInfos() {
    const slug = document.getElementById("searchgame").value;

    fetch(`https://rawg.io/api/games?search=${slug}&page_size=8&ordering=-popularity&key=API_KEY`)
    .then(respond=>{return respond.json();})
    .then(data => {
      let html = "";
      let count = 0;
      data.results.forEach(game => {
        
        let genres = "";
        if (game.genres.length === 0) {
            genres = "General";
        }
        for (let i = 0; i < game.genres.length; i++) {
          genres += game.genres[i]['name'];
          if (i !== game.genres.length - 1) {
            genres += "/";
          }
        }

        html += `
        <div class="card">
          <div class="card-image"><img src="${game.background_image}"></div>
          <div class="card-title"><h2>${game.name}</h2></div>
          <div class="genre"><p>Genre: ${genres}</p></div>
          <div class="release-date"><p>Release Date: ${game.released}</p></div>
          <div class="ButtonForm" onclick="addToList(${game.id})"><button>Add to list</button></div>
        </div>
        `;
        count++;
      });

      document.getElementById("container").innerHTML = html;
            
    })
    .catch(error => console.error(error));
}

function addToList(gameId) {
   // Create a new XMLHttpRequest object
   const xhr = new XMLHttpRequest();

   // Set up the request
   xhr.open('POST', 'search.php', true);
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   // Set up the onload callback
   xhr.onload = function() {
       if (xhr.status === 200) {
           // Request successful, handle the response here if needed
           console.log(xhr.responseText);
           let responseText = xhr.responseText;
           alert(responseText);
       } else {
           // Request failed
           console.error('Error:', xhr.status);
       }
   };

   // Set up the data to be sent
   const data = 'gameId=' + gameId + '&addToList=1';

   // Send the request
   xhr.send(data);
}



