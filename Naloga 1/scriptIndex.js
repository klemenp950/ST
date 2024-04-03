"use strict"

function toggleDarkMode(){
  var checkBox = document.getElementById("darkMode");
  if (checkBox.checked) {
    localStorage.setItem("DarkMode", true);
    console.log("Dark mode set on true.");
    setDarkMode("#353535", "#ffffff");
  } else {
    localStorage.setItem("DarkMode", false);
    console.log("Dark mode set on false.");
    setDarkMode("#ffffff", "#353535");
  }
}

function setDarkMode(primarnaBarva, sekundarnaBarva){
  document.getElementsByTagName("body")[0].style.backgroundColor = primarnaBarva;
      
  const inputi = document.getElementsByClassName("vnos");
  for (let i = 0; i < inputi.length; i++) {
    inputi[i].style.backgroundColor = primarnaBarva;
    inputi[i].style.color = sekundarnaBarva;
  }

  const textArea = document.getElementsByTagName("textarea")[0];
  if (textArea != null) {
    textArea.style.color = sekundarnaBarva;
    textArea.style.backgroundColor = primarnaBarva;
  }
  

  const select = document.getElementsByTagName("select")[0];
  if (select != null) {
    select.style.color = sekundarnaBarva;
    select.style.backgroundColor = primarnaBarva;
  }
  

  const labels = document.getElementsByTagName("label");
  if (labels != null) {
    for (let i = 0; i < labels.length; i++) {
      labels[i].style.color = sekundarnaBarva;
    }
  }
  

  const besedilo = document.getElementsByClassName("besedilo");
  if (besedilo != null) {
    for (let i = 0; i < besedilo.length; i++) {
      besedilo[i].style.color = sekundarnaBarva;
    }
  }
  

  const linki = document.getElementsByClassName("link");
  if (linki != null) {
    for (let i = 0; i < linki.length; i++) {
      linki[i].style.color = sekundarnaBarva;
    }
  }

  const seznamLinkov = document.getElementsByClassName("seznamLinkov")[0];
  if (seznamLinkov != null) {
    seznamLinkov.style.color = sekundarnaBarva;
  }

  const levaReklama = document.getElementsByClassName("levaReklama")[0];
  if (levaReklama != null) {
    levaReklama.style.backgroundColor = primarnaBarva;
  }

  const desnaReklama = document.getElementsByClassName("desnaReklama")[0];
  if (desnaReklama != null) {
    desnaReklama.style.backgroundColor = primarnaBarva;
  }

  const td = document.getElementsByTagName("td");
  console.log(td);
  if (td != null) {
    for (let i = 0; i < td.length; i++) {
      td[i].style.color = sekundarnaBarva;
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // This function is run after the page contents have been loaded
  // Put your initialization code here

  const darkModeCheckbox = document.getElementById("darkMode"); // Predvidevamo, da je to prvi element z razredom "gumb"

  if (localStorage.getItem("DarkMode") === null) {
    localStorage.setItem("DarkMode", false);
  }

  if (localStorage.getItem("DarkMode") === "true") {
    setDarkMode("#353535", "#ffffff");
    darkModeCheckbox.checked = true;
  } else {
    setDarkMode("#ffffff", "#353535");
    darkModeCheckbox.checked = false;
  }

  if (localStorage.teki){
    const teki = JSON.parse(localStorage.getItem("teki"));

    for (const tek of teki) {
      const tabela = document.getElementById("tabela");
      let novaVrstica = document.createElement("tr");
      novaVrstica.setAttribute("id", tek["id"]);
      
      for (const attr in tek) {
        if(attr !== "id"){
          if (attr == "dolzina") {
            const td = document.createElement("td");
            td.innerText = tek[attr] + " Km";
            novaVrstica.appendChild(td);
          } else {
            const td = document.createElement("td");
            td.innerText = tek[attr];
            novaVrstica.appendChild(td);
          }
        }
      }

      const tdZGumbi = document.createElement("td");
      const gumbUredi = document.createElement("button")
      gumbUredi.onclick = uredi;
      gumbUredi.innerText = "Uredi";
      gumbUredi.classList.add("akcija");
      const gumbIzbrisi = document.createElement("button")
      gumbIzbrisi.onclick = izbrisi;
      gumbIzbrisi.innerText = "Izbriši"
      gumbIzbrisi.classList.add("akcija");

      tdZGumbi.appendChild(gumbUredi);
      tdZGumbi.appendChild(gumbIzbrisi);
      
      novaVrstica.appendChild(tdZGumbi);

      tabela.appendChild(novaVrstica);
    }
  } else {
    localStorage.setItem("teki", "[]");
  }


});

function idk(){
  const DarkMode =  localStorage.getItem("DarkMode");
  if (DarkMode) {
    document.getElementById("darkMode").checked = true;
    console.log("debug")
  }else{
    document.getElementById("darkMode").checked = false;
  }

}

function uredi(){
  const x = document.activeElement.parentNode.parentNode.id;
  localStorage.setItem("temp", x);
  window.location.href = "urejanje.html"; 
}

function izbrisi() {
  let obvestilo = "Res želite izbrisati tek?";
  if(confirm(obvestilo)){
      const table = document.getElementById("tabela");
      let izbrisaniID = document.activeElement.parentElement.parentElement.id;
      document.activeElement.parentNode.parentNode.remove();
      let teki = JSON.parse(localStorage.getItem("teki"));
      let elementZaBrisanje;
      for(const tek of teki){
          const x = tek['id']
          if(x == izbrisaniID){
              elementZaBrisanje = tek;
          }
      }
      teki.splice(teki.indexOf(elementZaBrisanje), 1);
      localStorage.setItem("teki", JSON.stringify(teki));
  }
}

