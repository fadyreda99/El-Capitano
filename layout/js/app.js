const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const containeer = document.querySelector(".containeer");

sign_up_btn.addEventListener("click", () => {
  containeer.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  containeer.classList.remove("sign-up-mode");
});
