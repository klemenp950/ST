"use strict"


function izbrisiBesedilo() {
    document.getElementById("opis").value = "";
  }


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
}

document.addEventListener("DOMContentLoaded", () => {
  // This function is run after the page contents have been loaded
  // Put your initialization code here

  const darkModeCheckbox = document.getElementsByClassName("gumb")[0]; // Predvidevamo, da je to prvi element z razredom "gumb"

  if (localStorage.getItem("DarkMode") === null) {
    localStorage.setItem("DarkMode", false);
  }

  if (localStorage.getItem("DarkMode") === "true") {
    setDarkMode("#353535", "#ffffff");
    darkModeCheckbox.checked = true;
    darkModeCheckbox.setAttribute("checked");
  } else {
    setDarkMode("#ffffff", "#353535");
    darkModeCheckbox.checked = false;
    darkModeCheckbox.removeAttribute("checked");
  }

});