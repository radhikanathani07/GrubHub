function SearchPhotos(){
    let clientId="TC80JVCb0gdWbvlspE2T25rtqbmiiRpa4HLjeDg63gc";
    let query= document.getElementById("search").value;
    let url="https://api.unsplash.com/search/photos/?client_id="+clientId+"&query="+query;

    fetch(url)
        .then(function(data){
            return data.json();
        })
        .then(function(data){
            console.log(data.results[0].urls.regular);
            let x=data.results[0].urls.regular;
            
            let result=`<img src="${x} >`;
            $("#result").html(result);
           
                //document.getElementById("result").append(result)
        });

}