$(document).ready(function () {
    $("#searchForm").submit(function( event ) {
        $("#res").empty();
        thesearch = document.getElementById("searchForm");
        theSearchQuery = thesearch.elements["searchBar"].value;
        event.preventDefault();
        if(theSearchQuery){
            $.get("batter.php/"+theSearchQuery, function(data){
                var parsedJson = JSON.parse(data)
                if (parsedJson === false){
                    alert("Batter not found");
                }
                else{
                    $('#res').append("<div>"+theSearchQuery+":</div>");
                    $('#res').append("<table class = 'center'><tr><td>Singles:</td><td>" + parsedJson[0] + "</td><td></tr> <tr><td>Doubles: </td><td>" + parsedJson[1] + " </td><td></tr> <tr><td>Triples: </td><td>" + parsedJson[2] + "</td><td></tr> <tr><td>Home Runs: </td><td>" + parsedJson[3] + "</td><td></tr> <tr><td>Outs: </td><td>" + parsedJson[4] + " </td><td></tr> <tr><td>Average Hit Distance (feet): </td><td>" + parsedJson[5]+ "</td></tr></table>");
                }    
            });
      }
    });
});

