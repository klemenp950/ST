"use strict"

function izbrisiBesedilo() {
    document.getElementById("opis").value = "";
  }

let meniPrikazan = window.getComputedStyle(item).display !== 'none';

function prikaziMeni() {
  var elementi = document.querySelectorAll(".element");
  if (meniPrikazan) {
    elementi.forEach(function(element) {
      element.style.display = 'none';
  });
  } else {
    elementi.forEach(function(element) {
      element.style.display = 'block';
    });
  }
  meniPrikazan = !meniPrikazan;
}