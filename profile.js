// description

const description = document.getElementById('description');
const saveDescription = document.getElementById('save-description');
const descriptionFeedback = document.getElementById('descrition-feedback');

saveDescription.onclick = async e => {
    e.preventDefault();
    const message = description.value;
    console.log(message);
    let data = {
        message: message
    }
    data = JSON.stringify(data);
    let response = await fetch('../profile-description.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: data
    });
    console.log(response);
    if (response.ok) {
        response = await response.json();
        console.log(response.message);
        descriptionFeedback.innerText = response.message;
    }
}
description.oninput = () => descriptionFeedback.innerText = '';

// handle passwords

const show = document.getElementById('toggle-password');
const oldpw = document.getElementById('old-password');
const newpw = document.getElementById('new-password');

const savepw = document.getElementById('save-new-password');
const passwordFeedback = document.getElementById('password-feedback');

show.onchange = () => {
    show.checked ? oldpw.setAttribute('type', 'text') : oldpw.setAttribute('type', 'password');
    show.checked ? newpw.setAttribute('type', 'text') : newpw.setAttribute('type', 'password');
}

savepw.onclick = async e => {
    e.preventDefault();
    oldpwValue = oldpw.value;
    newpwValue = newpw.value;

    let data = {
        oldpw: oldpwValue,
        newpw: newpwValue
    }
    data = JSON.stringify(data);
    let response = await fetch('../profile-password.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: data
    });
    console.log(response);
    if (response.ok) {
        response = await response.json();
        console.log(response);
        passwordFeedback.innerText = response.message;
    }
}
oldpw.oninput = () => passwordFeedback.innerText = '';
newpw.oninput = () => passwordFeedback.innerText = '';


// delete account

const deleteAccount = document.getElementById('delete-account');
const deleteAccountConfirmation = document.getElementById('delete-account-confirmation');
const deleteModal = document.getElementById('delete-modal');

deleteAccount.onclick = e => {
    e.preventDefault();
    deleteModal.classList.add('open');
}
deleteAccountConfirmation.onclick = async () => {
    try {
        let response = await fetch('../profile-delete.php');
        if (response.ok) {
            response = await response.json();
            console.log(response);
            window.location.href = '../blog.php';
        }
    } catch (error) {
        console.log(error);
    }
}