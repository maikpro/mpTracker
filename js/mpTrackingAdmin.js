const MAX = 10;

var oldCounter;
var lastParent;

var addButton = document.getElementById("addFilter");
var deleteButton = document.getElementById("deleteFilter");

var urlBox = document.getElementById("urlBox");

var counter = parseInt(document.getElementById("trackerCounter").value); 

var alertText = document.getElementById("alertText");

var currentInput = document.getElementById("trackerUrl_" + counter);



function refreshCounter(){
    console.log(counter);
    document.getElementById("trackerCounter").value = counter;
    currentInput = document.getElementById("trackerUrl_" + counter);
}

function refreshAdd(){
    addButton = document.getElementById("addFilter");
    if( counter == 10){
        addButton.style.display = "none";
    } else{
        addButton.style.display = "inline-block";
    }
}


function refreshDelete(){
    deleteButton = document.getElementById("deleteFilter");
    if( counter == 1){
        deleteButton.style.display = "none";
    } else{
        deleteButton.style.display = "inline-block";
    }
}




addButton.addEventListener("click", function(e){

    e.preventDefault();

    console.log("clicked!");

    console.log( counter  );

    if(parseInt(counter) >= MAX){

        filterAlertInfo("warn", "maximale Grenze " + MAX + " erreicht!");

        console.log("maximum erreicht!");

    } else if(currentInput.value.length == 0){
        filterAlertInfo("warn", "Eingabe ist leer!");
        console.log("leer!");
    } else{

        filterAlertInfo("success");

        console.log("hinzufügen!");

        addInput();

        refreshDelete();
        refreshCounter();
        refreshAdd();
        //clear();

    }
    
});

function addInput(){
    counter++;
    let newInputBox = document.createElement('div');
    newInputBox.id = "urlInput_" + counter;
    let newInput = "<input type='text' id='trackerUrl_" + counter + "' name='trackerUrl_" + counter + "' value='' placeholder='google.com'>";
    newInputBox.innerHTML = newInput;
    urlBox.appendChild(newInputBox);
    moveButtonBoxDown();
    refreshCounter();

    /*
    echo "<div id='urlInput_". $i ."'>"
        . "<input type='text' id='trackerUrl_" . $i ."' name='trackerUrl_". $i ."' value='" . $urlTracker ."' placeholder='google.com'>";
    */
}

function clear(){
    alertText.value = "";
}

function filterAlertInfo(alert, info){

    if( alert === "success" ){

        console.log("JAA!");

        alertText.innerText = "Filter hinzugefügt!";

        //alertText.style.color = "green";

        //currentInput.style.border = "2px solid green";

    } else if(alert === "warn"){

        console.log("NEEEIN!");

        alertText.innerText = info;

        alertText.style.color = "red";

        currentInput.style.border = "2px solid red";

    }

    /*Nach 5 Sekunden leeren*/

    setTimeout(function(){  

        alertText.innerText = "";

        currentInput.style.border = "";

    }, 3500);

}

deleteButton.addEventListener("click", function(e){
    e.preventDefault();

    console.log("counter: " + counter);
    if( counter > 1 ){
        console.log("delete trackerUrl_" + counter);
        
        oldCounter=counter;
        
        moveButtonBoxUp();
        deleteInput();
        refreshDelete();
        refreshAdd();
    } 
});

function deleteInput(){
    console.log(lastParent.children);
    lastParent.remove();
    refreshCounter();
}

function moveButtonBoxUp(){
    let buttonBox = document.getElementById("buttonBox_" + counter);
    let preLastInput = document.getElementById("urlInput_" + (counter-1) );
    lastParent = deleteButton.parentElement.parentElement;
    preLastInput.appendChild(buttonBox);
    counter--;
    buttonBox.id = "buttonBox_" + counter;
}

function moveButtonBoxDown(){
    let buttonBox = document.getElementById("buttonBox_" + (counter-1) );
    console.log(buttonBox)
    let nextInput = document.getElementById("urlInput_" + counter );
    console.log(nextInput)
    //nextInput = addButton.parentElement.parentElement;
    nextInput.appendChild(buttonBox);
    buttonBox.id = "buttonBox_" + counter;
}