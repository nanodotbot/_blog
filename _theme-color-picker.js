let blueTheme = true;
let greenTheme = false;
let redTheme = false;

const blue = document.getElementById('blue');
const green = document.getElementById('green');
const red = document.getElementById('red');

const setColor = () => {
    const root = document.querySelector(':root');
    if (blue.checked){
        blueTheme = true;
        greenTheme = false;
        redTheme = false;
        if (light) {
            Object.entries(lightBlue).forEach(entry => root.style.setProperty(entry[0], entry[1]));
        }
        if (!light) {
            Object.entries(darkBlue).forEach(entry => root.style.setProperty(entry[0], entry[1]));
        }
        if(save.checked){
            localStorage.setItem('color', 'blue');
            sessionStorage.setItem('color', 'blue');
            // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
        } else {
            localStorage.removeItem('color');
            sessionStorage.setItem('color', 'blue');
            // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
        }
    }
    if (green.checked){
        blueTheme = false;
        greenTheme = true;
        redTheme = false;
        if (light) {
            Object.entries(lightGreen).forEach(entry => root.style.setProperty(entry[0], entry[1]));
        }
        if (!light) {
            Object.entries(darkGreen).forEach(entry => root.style.setProperty(entry[0], entry[1]));
        }
        if(save.checked){
            localStorage.setItem('color', 'green');
            sessionStorage.setItem('color', 'green');
            // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
        } else {
            localStorage.removeItem('color');
            sessionStorage.setItem('color', 'green');
            // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
        }
    }
    if (red.checked){
        blueTheme = false;
        greenTheme = false;
        redTheme = true;
        if (light) {
            Object.entries(lightRed).forEach(entry => root.style.setProperty(entry[0], entry[1]));
        }
        if (!light) {
            Object.entries(darkRed).forEach(entry => root.style.setProperty(entry[0], entry[1]));
        }
        if(save.checked){
            localStorage.setItem('color', 'red');
            sessionStorage.setItem('color', 'red');
            // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
        } else {
            localStorage.removeItem('color');
            sessionStorage.setItem('color', 'red');
            // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
        }
    }
}

blue.onchange = setColor;
green.onchange = setColor;
red.onchange = setColor;

if (localStorage.getItem('theme') === 'dark') {
    // console.log(localStorage.getItem('theme'), sessionStorage.getItem('theme'));
    save.checked = true;
    theme.checked = true;
    light = false;
    setTheme();
} else if (sessionStorage.getItem('theme') === 'dark') {
    // console.log(localStorage.getItem('theme'), sessionStorage.getItem('theme'));
    theme.checked = true;
    light = false;
    setTheme();
}
if (localStorage.getItem('color') === 'blue' || sessionStorage.getItem('color') === 'blue') {
    // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
    blue.checked = true;
    setColor();
} else if (localStorage.getItem('color') === 'green' || sessionStorage.getItem('color') === 'green') {
    // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
    green.checked = true;
    setColor();
} else if (localStorage.getItem('color') === 'red' || sessionStorage.getItem('color') === 'red') {
    // console.log(localStorage.getItem('color'), sessionStorage.getItem('color'));
    red.checked = true;
    setColor();
}
