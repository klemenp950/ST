"use strict";

function domRemoveParticipant(event) {
    let obvestilo = "Res želite izbrisati uporabnika?";
    if(confirm(obvestilo)){
        const table = document.querySelector("#participant-table");
        event.toElement.parentNode.remove();
    } else {

    }
}

function domAddParticipant(participant) {
    // console.log(participant);
    const table = document.querySelector("#participant-table");
    const r = document.createElement("tr");
    r.ondblclick = domRemoveParticipant;
    table.appendChild(r)

    for (const attr in participant){
        const td = document.createElement("td");
        td.innerText = participant[attr];
        r.appendChild(td);
    }
}

function addParticipant(event) {

    const first = document.querySelector("#first").value;
    const last = document.querySelector("#last").value;
    const role = document.querySelector("#role").value;

    document.querySelector("#first").value = "";
    document.querySelector("#last").value = "";
    document.querySelector("#role").value = "";
    
    // Create participant object
    const participant = {
        first: first,
        last: last,
        role: role
    };

    domAddParticipant(participant);

    // Move cursor to the first name input field
    document.getElementById("first").focus();
}

document.addEventListener("DOMContentLoaded", () => {
    // This function is run after the page contents have been loaded
    // Put your initialization code here
    document.getElementById("addButton").onclick = addParticipant;
});

// The jQuery way of doing it
$(document).ready(() => {
    // Alternatively, you can use jQuery to achieve the same result
});
