console.log("js script embedded!");

const MAX = 10;

var button = document.getElementById("addFilter");
var filterText = document.getElementById("filterText");
var filterAlert = document.getElementById("filterAlert");
var filterTextbox = document.getElementById("filterTextbox");
var filterTable = document.querySelector("#filterTable > tbody");
var filters = document.getElementById("filters");
var clearTextBoxButton = document.getElementById("clearTextbox");

var inputCounter = document.getElementById("counter"); 
console.log( inputCounter  );

if(inputCounter.innerText < 1 || ""){
    inputCounter.innerText = 0;
}

button.addEventListener("click", function(e){
    e.preventDefault();
    console.log("clicked!");
    console.log("Length: " + filterText.value.length)
    console.log(parseInt(inputCounter.innerText));
    
    if(parseInt(inputCounter.innerText) >= MAX){
        filterAlertInfo("warn", "maximale Grenze " + MAX + " erreicht!");
        console.log("maximum erreicht!");
    } else if(filterText.value.length == 0){
        filterAlertInfo("warn", "Eingabe ist leer!");
        console.log("leer!");
    } else{
        filterAlertInfo("success");
        console.log("hinzufügen!");
        addTextToBox();
        /*addTextToTable();*/
        addFilter();
        clear();
    }
});

function addTextToBox(){
    filterTextbox.value += filterText.value + "\n";
}

function addTextToTable(){
    let newRow = filterTable.insertRow(-1);
    let newCell = newRow.insertCell(0);
    let text = document.createTextNode(filterText.value);
    newCell.appendChild(text);
}

function addFilter(){
    let div = addInput();
    //addDelete(div);
}

function addInput(){
    let newInputBox = document.createElement('div');
    let newInput = "<input type='text' name='newInputBox_"+ inputCounter.innerText + "' id='newInputBox_" + inputCounter.innerText +"' value='" + filterText.value  + "' readonly>";
    newInputBox.innerHTML = newInput;
    filters.appendChild(newInputBox);
    inputCounter.innerText = parseInt(inputCounter.innerText) + 1;
    return newInputBox;
}

function addDelete(div){
    let deleteButton = document.createElement('button');
    deleteButton.id = "deleteButton";
    deleteButton.innerText = "Löschen";
    div.appendChild(deleteButton);
}

function clear(){
    filterText.value = "";
}

function filterAlertInfo(alert, info){
    if( alert === "success" ){
        console.log("JAA!");
        filterAlert.innerText = "Filter hinzugefügt!";
        filterAlert.style.color = "green";
        filterText.style.border = "2px solid green";
    } else if(alert === "warn"){
        console.log("NEEEIN!");
        filterAlert.innerText = info;
        filterAlert.style.color = "red";
        filterText.style.border = "2px solid red";
    }

    /*Nach 5 Sekunden leeren*/
    setTimeout(function(){  
        filterAlert.innerText = "";
        filterText.style.border = "";

    }, 2000);
}