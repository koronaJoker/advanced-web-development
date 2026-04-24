export function initSelect() {
  const select = document.querySelector('.select');
  const selected = document.querySelector('.selected');
  const options = document.querySelector('.options');

  if (!select || !selected || !options) return;

  selected.addEventListener('click', (e) => {
    e.stopPropagation();
    options.classList.toggle('active');
    selected.classList.toggle('open');
  });

  options.addEventListener('click', (e) => {
    const option = e.target.closest('.option');
    const categoryInput = document.getElementById("categoryInput");
    if (!option) return;

    selected.textContent = option.textContent;
    selected.dataset.value = option.dataset.value || option.textContent;
    categoryInput.value = option.dataset.value || option.textContent;
    
    options.classList.remove('active');
    selected.classList.remove('open');
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.select')) {
      options.classList.remove('active');
      selected.classList.remove('open');
    }
  });
}
export const modalWindow = document.querySelector(".modal-window");
const errorList = document.getElementById("error-list");
const overlay = document.querySelector("#modal-overlay");

export function showModal(errorFields) {

  errorList.innerHTML = "";
  
  modalWindow.classList.add("visible");
  overlay.classList.add("visible");

  document.body.style.overflow = "hidden";

  for (let i = 0; i < errorFields.length; i++) {
    const li = document.createElement("li");
    li.textContent = errorFields[i];
    li.classList.add("error");

    errorList.appendChild(li);
  }
}

export function closeModal() {
  modalWindow.classList.remove("visible");
  overlay.classList.remove("visible");

  document.body.style.overflow = ""; 
}