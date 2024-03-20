"use strict";

function domRemoveParticipant(event) {
    let obvestilo = "Res želite izbrisati uporabnika?";
    if(confirm(obvestilo)){
        const table = document.querySelector("#participant-table");
        let izbrisaniID = event.toElement.parentNode.id;
        event.toElement.parentNode.remove();
        let sodelujoci = JSON.parse(localStorage.getItem("participants"));
        let elementZaBrisanje;
        for(const clovek of sodelujoci){
            const x = clovek['id']
            if( x == izbrisaniID){
                elementZaBrisanje = clovek;
            }
        }
        sodelujoci.splice(sodelujoci.indexOf(elementZaBrisanje), 1);
        localStorage.setItem("participants", JSON.stringify(sodelujoci));
    }
}

function domAddParticipant(participant) {
    console.log(participant);
    const table = document.querySelector("#participant-table");
    const r = document.createElement("tr");
    r.ondblclick = domRemoveParticipant;
    r.setAttribute("id", num);
    table.appendChild(r);

    for (const attr in participant){
        if(attr !== "id"){
            const td = document.createElement("td");
            td.innerText = participant[attr];
            r.appendChild(td);
        }
    }

    let osebe = [];
    if(localStorage.getItem("participants")){
        osebe = JSON.parse(localStorage.getItem("participants"));
    }
    osebe.push(participant);
    localStorage.setItem("participants", JSON.stringify(osebe));
}
let num = 0;
function addParticipant(event) {

    
    num = num + 1;
    const first = document.querySelector("#first").value;
    const last = document.querySelector("#last").value;
    const role = document.querySelector("#role").value;

    document.querySelector("#first").value = "";
    document.querySelector("#last").value = "";
    document.querySelector("#role").value = "";
    
    // Create participant object
    const participant = {
        id: num,
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
    if(localStorage.participants){
        const sodelujociString = localStorage.getItem("participants");
        console.log(sodelujociString);
        const sodelujoci = JSON.parse(sodelujociString);
        console.log(sodelujoci)
        for (const clovek of sodelujoci){
            const table = document.querySelector("#participant-table");
            let row = document.createElement("tr");
            row.setAttribute("id", clovek["id"]);
            row.ondblclick = domRemoveParticipant;
            

            for(const attr in clovek){
                if(attr !== "id"){
                    const td = document.createElement("td");
                    td.innerText = clovek[attr];
                    row.appendChild(td);
                } else {
                    if (parseInt(clovek[attr]) > num){
                        num = parseInt(clovek[attr]);
                    }
                }
                
            }

            table.appendChild(row);

        }
    } else {
        localStorage.setItem("participants", "[]");
    }
});

// The jQuery way of doing it
$(document).ready(() => {
    // Alternatively, you can use jQuery to achieve the same result
});
