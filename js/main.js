function getUser(steamID){

    return $.ajax({
      method: "GET",
      url: "Get/User.php",
      data: {id:steamID} 
    });
    // return response;
}

function getFriendsList(steamID, callback){
    return $.ajax({
      method: "GET",
      url: "Get/Friends.php",
      data: {id:steamID} 
    })
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

function getSteamId(){
    // var url = window.location.href;
    var url = decodeURIComponent(getUrlVars()["openid.claimed_id"]);
    var match = url.match(/[0-9]+/);
    return match[0];
}

function adduser(user, position){
    var html = "<div class='"+position+"'><img src='"+user.avatarfull+"' alt='"+user.personaname+' avatar'+"'><h3>"+user.personaname+"<h3></div>";
    $("#"+position).append(html);
}   



function loadData(){
    getUser(getSteamId()).done(function(data){
        data = JSON.parse(data);
        data = data.response.players;
        console.log(data);
        adduser(data[0], 'mainUser');
        
        getFriendsList(data[0].steamid).done(function(data){
            data = JSON.parse(data);
            data = data.response.players;
            $.each( data, function( key, value ) {
              adduser(value, 'friendsList')
            });
        });

    });
}
function setfriends(){
    $(".friendsList").click(function(){
        this.css({"background-color":"rgba(255, 83, 13, 0.8)"});
        console.log(this);
    })
}

$(document).ready(function(){
    console.log("GO!");

    if($("#wrapper").length == 0){

    }else{
       loadData(); 
    }
})