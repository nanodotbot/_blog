const modals = document.querySelectorAll('.modal');
const inner = document.querySelectorAll('.modal-inner');
const close = document.querySelectorAll('.modal-close');

modals.forEach((modal, index) => {
    modal.onclick = e => modal.classList.remove('open');
    inner[index].onclick = e => e.stopPropagation();
    close[index].onclick = () => modal.classList.remove('open');
});