"use strict";

window.onload = function(){
  let nav = document.querySelector("#navArea");
  let btn = document.querySelector(".toggle-btn");
  let mask = document.querySelector("#mask");

  btn.addEventListener("click", () => {
    nav.classList.toggle("open");

  })
};