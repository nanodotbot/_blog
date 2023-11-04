const textareas = document.querySelectorAll('.textarea');
const textareasFeedback = document.querySelectorAll('.textarea-feedback');

textareas.forEach((textarea, index) => {
    textarea.oninput = () => {
        textarea.style.height = '';
        textarea.style.height = textarea.scrollHeight + 1 + "px";
        textareasFeedback[index].innerText = '';
    }
});