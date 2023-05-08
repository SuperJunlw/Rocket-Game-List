//const API_KEY = "df331e96509e4da4b3a9d7e6f4f94818";

function getInfos(name) {
    //const slug = document.getElementById("searchgame").value;

    fetch(`https://rawg.io/api/games?search=${name}&key=df331e96509e4da4b3a9d7e6f4f94818`)
    .then(respond=>{return respond.json();})
    .then(data => {
      let html = "";
      data.results.forEach(game => {
        console.log(game.name);
        console.log(game.description);
        console.log(game.background_image);
        html += `
          <div class="card">
            <div class="card-image"><img src="${game.background_image}"></div>
            <div class="card-title"><h2>${game.name}</h2></div>
            <div class = "description"><p>Description: ${game.description}</p></div>
            <div class="ButtonForm"><button>Add to list</button></div>
          </div>
        `;
      });

      //document.getElementById("container").innerHTML = html;

      // resultsContainer.innerHTML = "";

      // data.results.forEach(game => {
      //   const card = document.createElement("div");
      //   card.classList.add("card");

      //   const imgDiv = document.createElement("div");
      //   imgDiv.classList.add("card-image");
      //   card.appendChild(imgDiv);

      //   const image = document.createElement("img");
      //   image.src = game.background_image;
      //   imgDiv.appendChild(image);

      //   const titleDiv = document.createElement("div");
      //   titleDiv.classList.add("card-title");
      //   card.appendChild(titleDiv);

      //   const title = document.createElement("h2");
      //   title.textContent = game.name;
      //   titleDiv.appendChild(title);

      //   const descDiv = document.createElement("div");
      //   descDiv.classList.add("description");
      //   card.appendChild(descDiv);

      //   const desc = document.createElement("p");
      //   desc.innerText = 'Description: ${game.description}';
      //   descDiv.appendChild(desc);

      //   const buttonDiv = document.createElement("div");
      //   buttonDiv.classList.add("ButtonForm");
      //   card.appendChild(buttonDiv);

      //   const button = document.createElement("button");
      //   let text = document.createTextNode("Add to List");
      //   button.appendChild(text);
      //   buttonDiv.appendChild(button);

      //   resultsContainer.appendChild(card);
      // });
            
    })
    .catch(error => console.error(error));
}

