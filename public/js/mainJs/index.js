function inputBtn(){
    console.log("entrer");
    var input=document.createElement('input');
    input.type="file";
    setTimeout(function(){
        $(input).click();
    },200);

    console.log("sorti");
}

