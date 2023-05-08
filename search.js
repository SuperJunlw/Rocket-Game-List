//const API_KEY = "df331e96509e4da4b3a9d7e6f4f94818";

function getInfos() {
    const slug = document.getElementById("searchgame").value;

    fetch(`https://rawg.io/api/games?search=${slug}&key=df331e96509e4da4b3a9d7e6f4f94818`)
    .then(respond=>{return respond.json();})
    .then(data => {
      let html = "";
      let count = 0;
      data.results.forEach(game => {

        //limit the result to 8 games
        if(count >= 8){
          return;
        }

        console.log(game.name);
        let genres = "";
        for (let i = 0; i < game.genres.length; i++) {
          genres += game.genres[i]['name'];
          genres += "/";
        }
        console.log(genres);
        console.log(game.released);

        html += `
          <div class="card">
            <div class="card-image"><img src="${game.background_image}"></div>
            <div class="card-title"><h2>${game.name}</h2></div>
            <div class = "description"><p>${genres}</p></div>
            <div class = "description"><p>Release Date: ${game.released}</p></div>
            <div class="ButtonForm" onclick="addToList(${game.id})"><button>Add to list</button></div>
          </div>
        `;
        count++;
      });

      document.getElementById("container").innerHTML = html;
            
    })
    .catch(error => console.error(error));
}

function addToList(gameID){
  fetch(`https://rawg.io/api/games?search=${gameID}&key=df331e96509e4da4b3a9d7e6f4f94818`)
  .then(respond=>{return respond.json();})
    .then(game => {
        let genres = "";
        for (let i = 0; i < game.genres.length; i++) {
          genres += game.genres[i]['name'];
          genres += "/";
        }

        let gameInfo = {
          name: game.name,
          genre: genres,
          image: game.background_image,
          release: game.released,
        };
            
    })
    .catch(error => console.error(error));
}

