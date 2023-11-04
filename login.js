// show password

const show = document.getElementById('toggle-password');
const pw = document.getElementById('password');

show.onchange = () => {
    show.checked ? pw.setAttribute('type', 'text') : pw.setAttribute('type', 'password');
}

// check password

let loginActive = true;
let feedback = document.getElementById('feedback');

// switch tabs

const login = document.getElementById('login');
const register = document.getElementById('register');
const btn = document.getElementById('login-btn');
const dataProtection = document.getElementById('data-protection');

login.onclick = () => {
    login.classList.add('active');
    register.classList.remove('active');
    dataProtection.classList.remove('open');
    btn.innerText = 'Anmelden';
    loginActive = true;
    feedback.innerText = '';
}

register.onclick = () => {
    login.classList.remove('active');
    register.classList.add('active');
    dataProtection.classList.add('open');
    btn.innerText = 'Registrieren';
    loginActive = false;
    feedback.innerText = '';
}

const dataProtectionBtn = document.getElementById('data-protection-button');
const modalDataProtection = document.getElementById('modal-data-protection');

dataProtectionBtn.onclick = e => {
    e.preventDefault();
    modalDataProtection.classList.add('open');
}

// handle login / register

const username = document.getElementById('username');
const password = document.getElementById('password');
const dataProtectionAgreement = document.getElementById('toggle-data-protection-agreement');

btn.onclick = async e => {
    e.preventDefault();
    e.stopPropagation();
    const usernameValue = username.value;
    const passwordValue = password.value;
    if (!loginActive && !dataProtectionAgreement.checked){
        feedback.innerText = 'Bestätige bitte, dass du den Datenschutzhinweis zur Kenntnis genommen hast.';
        return;
    }
    if (usernameValue && passwordValue) {
        let data = {
            username: usernameValue,
            password: passwordValue
        }
        data = JSON.stringify(data);
        if (loginActive) {
            let response = await fetch('./login.php',{
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: data        
            });
            if(response.ok) {
                response = await response.json();
                const message = await response.message;
                // console.log(message);
                if(message === 'Erfolgreich eingeloggt.'){
                    window.location.href = './blog.php';
                } else if(message === 'Benutzername oder Passwort unbekannt.') {
                    feedback.innerText = message;
                } else {
                    feedback.innerText = 'Ein unbekannter Fehler ist aufgetreten. Hab bitte Nachsicht mit dem Entwickler.';
                }
            } else {
                feedback.innerText = 'Ein unbekannter Fehler ist aufgetreten. Hab bitte Nachsicht mit dem Entwickler.';
            }
        } else {
            let response = await fetch('./register.php',{
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: data        
            });
            if(response.ok) {
                response = await response.json();
                const message = await response.message;
                // console.log(message);
                if(message === 'Erfolgreich registriert. Bitte melde dich an.'){
                    feedback.innerText = message;
                } else {
                    feedback.innerText = message;
                }
            } else {
                feedback.innerText = 'Ein unbekannter Fehler ist aufgetreten. Hab bitte Nachsicht mit dem Entwickler.';
            }

        }
    } else {
        feedback.innerText = 'Bitte Nutzername und Passwort eingeben.';
    }
}

username.oninput = () => feedback.innerText = '';
password.oninput = () => feedback.innerText = '';