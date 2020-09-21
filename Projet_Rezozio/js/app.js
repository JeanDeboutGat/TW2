//window interface for management and detection of document events
window.addEventListener("DOMContentLoaded", function(e){
  let form = document.getElementById("login");
  let messageForm = document.getElementById("postmessage");
  let logoutbtn = document.getElementById("logout");
  let createUserForm = document.getElementById("createUser");
  let filterForm = document.getElementById("filters");
  let avatarForm = document.getElementById("formulaireavatar");

  if(form){
    form.addEventListener("submit", login);
  }

  if(messageForm){
    messageForm.addEventListener("submit", postMessage);
  }

  if(logoutbtn){
    logoutbtn.addEventListener("click", logout);
  }

  if(createUserForm){
     createUserForm.addEventListener("submit", createUser);
  }

  if(filterForm){
    filterForm.addEventListener("submit", filterMessage);
  }

  if(avatarForm){
    avatarForm.addEventListener("submit", uploadAvatar);
  }

  // show all messages
  if(connected){
    showFollowedMessages();
  }else{
    showMessages();
  }
});
//function for handling login form events
function login(e){
  e.preventDefault();
  let args = {
    body: new FormData(e.target),
    method: 'POST'
  }
 
  console.log(e.target)
  let request = fetchFromJson("services/login.php", args);
  request.then(function(response){
    if(response.status == "ok"){
      window.location.reload()
    }else{
      alert(response.message)
    }
  })
}
//function for handling filter button events
function filterMessage(event){
  event.preventDefault();
  let action = event.submitter.value;

  let formData = new FormData(event.target);

  if(action && action == "annuler"){
    formData = new FormData();
  }

  let request = fetchFromJson("services/findMessages.php", {
    body: formData,
    method: "POST"
  });
  
  request.then(function(response){
    console.log(response);
    if(response.status != "ok" || response.result.length == 0){
      alert("Aucun message n'a été trouvé");
    }else{
      displayMessages(response, true);
    }
  });
}
//function for handling createUser form events
function createUser(e){
  e.preventDefault();
  let args = {
    body: new FormData(e.target),
    method: 'POST'
  }
  let request = fetchFromJson("services/createUser.php", args);
  request.then(function(response){
    if(response.status == "ok"){
      alert("Bravo,compte Créer!!!!!!!")
    }else{
      alert(response.message)
    }
  })
}
//function for handling PostMessage form  events
function postMessage(e){
  e.preventDefault();
  let args = {
    body: new FormData(e.target),
    method: 'POST'
  }
  let request = fetchFromJson("services/postMessage.php", args);
  request.then(function(response){
    console.log(response)
    if(response.status  && response.status == "ok"){
      showMessages();
      alert("Message posted !")
    }else{
      alert(response.message)
    }
  })
}
//function for showMessages events handling
function showMessages(){
  let request = fetchFromJson("services/findMessages.php");
  window.typefilter = "allmessages";
  request.then(function(response){
    displayMessages(response, true);
  });
}

//function for showFollowedMessages events handling
function showFollowedMessages(){
  let request = fetchFromJson("services/findFollowedMessages.php");
  window.typefilter = "followermessages";
  request.then(function(response){
    displayMessages(response, true);
  });
}

//function for displaying messages
function displayMessages(data, refresh){
  let list = document.getElementById("list_messages");
  if(refresh){
    list.innerHTML = "";
  }
  if(list){
    if(data.status == "ok" && data.result.length > 0){
      // we have messages to display
      let messages = data.result;
      let button= document.createElement("button");

      for(let i=0; i<messages.length; i++){
        let html = "";
        let message = messages[i];
        let m = document.createElement("div");
        m.className = "message";
          // avatar html code
          html += "<div class='avatar'><img src='http://www.gravatar.com/avatar/?s=48'/></div>";

          // message content
          html+= "<div class='message_and_pseudo'>";
            html+= "<div class='contents'>";
              html+= "<p>"+ message.content+"</p>";
            html+= "</div>";

            // pseudo and login html code
            html += "<div class='pseudologin'>";
              html+="<span> Posté par: "+ message.author +"</span>"
              html+="<span> Pseudo: "+ message.pseudo +"</span>"
            html +="</div>";
            // message date time
            html += "<div class='date'><p>Publié le "+message.datetime+"</p></div>";
        html+= "</div>";
        html+= "<div class='clearfix_left'></div>";
        m.innerHTML = html;
        list.appendChild(m);

        if(i == messages.length-1){
          window.lastMessageId = message.id;
        }
      }


    }else{
      // no messages to display
    }
  }
}
//function for handling displaymore dropdown event
function displayMoreMessages(){
  let service = '';
  let before = window.lastMessageId ? "?before="+window.lastMessageId : "";
  if(window.typefilter && window.typefilter == "followermessages"){
    service = '/services/findFollowedMessages.php';
  }else{
    service = '/services/findMessages.php'
  }

  let request = fetchFromJson(service+before);
  request.then(function(response){
    if(response.result && response.result.length >0){
      displayMessages(response, false);
    }else{
      alert("Désole, il n'y a plus de message à afficher !");
    }

  });
}
//function for handling logout event
function logout(e){
  e.preventDefault();
  let request = fetchFromJson("services/logout.php");
  request.then(function(response){
    // console.log(response);
    if(response.status && response.status == "ok"){
      window.location.reload();
    }
  })
}
//
function showPage(pageId){
  let page = document.getElementById(pageId);
  hideAllPage();
  if(page){
    page.classList.remove("hide");
    if(pageId == "messages"){ showMessagesPage(page); }
    else if(pageId == "abonnes"){ showAbonnesPage(page); }
    else if(pageId == "abonnements"){ showAbonnementsPage(page); }
    else if(pageId == "profile"){ showProfileUpdatePage(page); }
  }
}

function hideAllPage(){
  let pages = document.getElementsByClassName("page");
  for(let i=0; i< pages.length; i++){
    pages[i].classList.add("hide");
  }
}

function showMessagesPage(page){
    // do nothing
}
//function for handling followers display event
function showAbonnesPage(page, refresh=false){
  // do nothing
  if(page.innerHTML.trim() == "" || refresh){
    page.innerHTML = "<h3>Liste des membres que me suit</h3>";
    let table = document.createElement("table")
    table.className = "list_abonnees";

    let headers  = ["Login", "Pseudo", "Mutual", "S'abonner / se désabonner"];
    let headtable = document.createElement("thead");
    let bodyTable = document.createElement("tbody");
    let headerRow = document.createElement("tr");

    for(let i=0; i<headers.length; i++){
      let el = document.createElement("th");
      el.innerText = headers[i];
      headerRow.appendChild(el);
    }
    headtable.appendChild(headerRow);
    table.appendChild(headtable);

    let request = fetchFromJson("services/getFollowers.php");
    request.then(function(response){
      if(response.status == "ok" && response.result.length > 0){
          let users = response.result;
          for(let i=0; i<users.length; i++){
            let user = users[i];
            let item = document.createElement("tr");
            item.innerHTML = "<td>"+user.login+"</td>";
            item.innerHTML+= "<td>"+user.pseudo+"</td>";

            if(user.mutual){
              item.innerHTML+= "<td>Oui</td>";
            }else{
              item.innerHTML+= "<td>Non</td>";
            }

            let followButton = document.createElement("button");
            followButton.classList.add("button");
            followButton.onclick = function(e){
              //console.log(user);
              if(user.mutual){
                // unfollow user
                let followRequest = fetchFromJson("services/unfollow.php?target="+user.login);
                followRequest.then(function(response){
                  if(response.status == "ok" && response.result){
                    alert("Success ! you unfollowed "+user.login);
                    showAbonnesPage(page, true);
                  }
                });
              }else{
                // follow user
                let unfollowRequest = fetchFromJson("services/follow.php?target="+user.login);
                unfollowRequest.then(function(response){
                  if(response.status == "ok" && response.result){
                    alert("Success ! you followed "+user.login);
                    showAbonnesPage(page, true);
                  }
                });
              }
            }
            if(user.mutual){
              followButton.innerText = "Se désabonner";
              followButton.classList.add("error");
            }else{
              followButton.innerText = "S'abonner";
              followButton.classList.add("success");
            }

            item.appendChild(followButton);
            bodyTable.appendChild(item);
          }
          table.appendChild(bodyTable)
      }
      //console.log(response);
    });
    page.appendChild(table);
  }
}
//function for handling subscription display event
function showAbonnementsPage(page, refresh=false){
  if(page.innerHTML.trim() == "" || refresh){
      // do nothing
  page.innerHTML = "<h3>Les comptes auxquels je suis abonné</h3>";
  let table = document.createElement("table");
  table.className = "list_abonnements";

  let headers  = ["Login", "Pseudo", "Mutual","S'abonner / se désabonner"];
  let headtable = document.createElement("thead");
  let bodyTable = document.createElement("tbody");
  let headerRow = document.createElement("tr");

  for(let i=0; i<headers.length; i++){
    let el = document.createElement("th");
    el.innerText = headers[i];
    headerRow.appendChild(el);
  }
  headtable.appendChild(headerRow);
  table.appendChild(headtable);

  let request = fetchFromJson("services/getSubscriptions.php");
  request.then(function(response){
    if(response.status == "ok" && response.result.length > 0){
 
        let users = response.result;
        for(let i=0; i<users.length; i++){
          let user = users[i];
          let item = document.createElement("tr");
          item.innerHTML = "<td>"+user.login+"</td>";
          item.innerHTML+= "<td>"+user.pseudo+"</td>";

          if(user.mutual){
            item.innerHTML+= "<td>Oui</td>";
          }else{
            item.innerHTML+= "<td>Non</td>";
          }

          let followButton = document.createElement("button");
          followButton.classList.add("button");
          followButton.innerText = "Se désabonner";
          followButton.classList.add("error");

          followButton.onclick = function(e){
            // unfollow user
            let unfollowRequest = fetchFromJson("services/unfollow.php?target="+user.login);
            unfollowRequest.then(function(response){
              if(response.status == "ok"){
                alert("Success ! you unfollowed "+user.login);
                showAbonnementsPage(page, true);
              }else{
                alert(response.message);
              }
            });
          }

          item.appendChild(followButton);
          bodyTable.appendChild(item);
        }
        table.appendChild(bodyTable)
    }
    //console.log(response);
  });
  page.appendChild(table);
  }
}

//function for handling profile display event
function showProfileUpdatePage(page){
  // do nothing
  page.innerHTML = "<h3>Mettre à jour mon profil</h3>";
  let profil = document.createElement("form");
  let submitButton = document.createElement("button");
  submitButton.type = "submit";
  submitButton.innerText = "Sauvegarder";
  submitButton.onclick = function(e){
    e.preventDefault();
    let form = new FormData(profil);
    let verified = form.get("pseudo").trim().length > 0
                    && form.get("password").trim().length > 0
                    && form.get("description").trim().length > 0;

    if(verified){
      let args = {
        body: form,
        method: 'POST'
      }
      let request = fetchFromJson("services/setProfile.php", args);
      request.then(function(response){
        if(response.status == "ok"){
          alert("Success, Profile is now update !")
        }else{
          alert(response.message)
        }
      });
    }else{
      // input required !
      alert("Inputs are not valid !")
    }
  }

  profil.id = "profileform";

  // inputs
  let pseudoInput = createInput("text", "pseudo", "Pseudo");
  let passwordInput = createInput("password", "password", "Password");
  let descInput = createInput("textarea", "description", "Description");

  profil.appendChild(pseudoInput);
  profil.appendChild(passwordInput);
  profil.appendChild(descInput);
  profil.appendChild(submitButton);

  page.appendChild(profil);
}
//function for creating  inputs button block
function createInput(type, name, placeholder){
  let div = document.createElement("div");
  div.className = "input"

  let label = document.createElement("label");
  label.innerText = name;

  let input = document.createElement("input");
  if(type == "textarea"){
    input = document.createElement("textarea");
  }
  input.type = type;
  input.name = name;
  input.placeholder = placeholder;
  input.required = "true";
  div.appendChild(label);
  div.appendChild(input);
  return div;
}
//function for handling uploading avatar event
function uploadAvatar(event){
  event.preventDefault();
  let formData = new FormData();
  if(event.target.avatar){
    formData.append("avatar", event.target.avatar.files[0]);
  }

  let args = {
    method: "POST",
    body: formData
  }

  let request = fetchFromJson("services/uploadAvatar.php", args);
  request.then((response) => {
    if(response.status == "ok" && response.result){
      alert("l'avatar a été téléchargé avec succès");
      let avatarElem = document.getElementById("avatarimg");
      if(avatarElem){
        let url = avatarElem.src;
        avatarElem.src = url+"&t="+ new Date().getTime();
      }
    }else{
      alert("Une erreur s'est produite lors du téléchargement de l'avatar !");
    }
  }).catch(function(error){
    console.log(error);
  });
}

function authorSearch(){
  console.log(this);
}
