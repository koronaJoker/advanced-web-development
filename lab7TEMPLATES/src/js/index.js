import { closeModal, initSelect} from "./ui.js";
import {Transaction, checkTransaction, errorFieldsLength} from "./transactions.js";

initSelect();

const form = document.querySelector("form");

form.addEventListener("submit", (e) => {
    const transaction = checkTransaction();

    if (!transaction) {
        e.preventDefault(); // ❗ останавливаем ТОЛЬКО при ошибке
    }
});

const btn = document.querySelector('#add');
btn.addEventListener('click', () => checkTransaction());


const ModalCloseBtn = document.querySelector("#closeBtn");
ModalCloseBtn.addEventListener("click", closeModal);


document.addEventListener("click", (e) => {
    const btn = e.target.closest(".delete-btn");
    if (!btn) return;

    e.preventDefault();

    const row = btn.closest("tr");
    if (!row) return;

    row.classList.add("fade-out");

    setTimeout(() => {
        window.location.href = btn.href;
    }, 400);
});


