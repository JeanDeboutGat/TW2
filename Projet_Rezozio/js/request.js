function treatResponse(response){
  if(response.ok){
    return response.json();
  }else{
    throw new Error(response.statusText);
  }
}

function fetchFromJson(url, args){
  return fetch(url, args)
    .then(treatResponse);
}
