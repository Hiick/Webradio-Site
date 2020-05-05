console.log("je suis ici")

$( document ).ready(function() {

    $.ajax({
        method: "GET",
        url:"/radios",
        async: false
    }).success((response) => {
        console.log(response);
    }).error((err) => {
        console.log(err)
    })
}); 
