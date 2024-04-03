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

  const td = document.getElementsByClassName("td");
  if (td != null) {
    for (let i = 0; i < td.length; i++) {
      td[i].style.color = sekundarnaBarva;
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
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

  const teki = JSON.parse(localStorage.getItem("teki"));
  let urejani;

  for (const tek of teki) {
    const x = tek['id'];
    if(x == localStorage.getItem("temp")){
      urejani = tek;
    }
  }

  console.log(urejani);

  const tabela = document.getElementsByTagName("fieldset")[0];
  document.getElementById("naslov").value = urejani['naslov'];
  document.getElementById("dolzina").value = urejani['dolzina'];
  document.getElementById("datum").value = urejani['datum'];
  document.getElementById("opis").value = urejani['opis'];
  document.getElementById("kategorija").value = urejani['kategorija'].slice(-1);
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

function posodobi(){
  const id = localStorage.getItem("temp");
  let teki = JSON.parse(localStorage.getItem("teki"));

  let elementZaBrisanje;
  for(const tek of teki){
      const x = tek['id']
      if(x == id){
        elementZaBrisanje = tek;
      }
  }

  teki.splice(teki.indexOf(elementZaBrisanje), 1);
  localStorage.setItem("teki", JSON.stringify(teki));

  const naslov = document.getElementById("naslov").value;
  const dolzina = document.getElementById("dolzina").value;
  const datum = document.getElementById("datum").value;
  const opis = document.getElementById("opis").value;
  const kategorija = document.getElementById("kategorija").value;
  
  const tek = {
      id: id,
      naslov: naslov,
      dolzina: dolzina,
      datum: datum,
      opis: opis, 
      kategorija: "Zone " + kategorija 
  };

  teki.push(tek);
  localStorage.setItem("teki", JSON.stringify(teki));

  window.location.href = "index.html";
}

