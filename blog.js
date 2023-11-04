// droparea

const dropArea = document.getElementById('drop-area');

const dragIn = e => {
	// e.stopPropagation();
	e.preventDefault();
    dropArea.style.border = '.1rem dashed var(--input-focus-border)';
}
const dragOut = e => {
	// e.stopPropagation();
	e.preventDefault();
    dropArea.style.border = '.1rem dashed var(--input-border)';
}
dropArea.ondragenter = dragIn;
dropArea.ondragover = dragIn;
dropArea.onmouseover = dragIn;
dropArea.ondragleave = dragOut;
dropArea.onmouseout = dragOut;

// handle post data

const fileInput = document.getElementById('file-input');
let file = null;
const preview = document.getElementById('preview');
const previewImage = document.getElementById('preview-image');
const message = document.getElementById('message');
const send = document.getElementById('send');
const messageFeedback = document.getElementById('message-feedback');

const handlePreview = files => {
    file = files[0];
    if(file.size > 15000000) {
        messageFeedback.innerText = 'Derzeit sind nur Dateigrössen bis zu 15 Megabyte erlaubt.'
        return;
    }
	const reader = new FileReader();
	if (file.type.startsWith('image/')) {
		reader.onload = e => {
            previewImage.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        messageFeedback.innerText = 'Derzeit sind nur Bilder erlaubt.';
    }
}

dropArea.ondrop = e => {
    // e.stopPropagation();
    e.preventDefault();
    dropArea.style.border = '.1rem dashed var(--input-focus-border)';
    messageFeedback.innerText = '';

	const files = e.dataTransfer.files;
    handlePreview(files);
}

fileInput.onchange = e => {
    messageFeedback.innerText = '';

    const files = e.target.files;
    handlePreview(files);
}

const handleBlog = async file => {
    const messageValue = message.value;
    let formData = new FormData();
    formData.append('message', messageValue);
    // console.log(file);
    formData.append('file', file);
    console.log(formData.get('file'));
    // TODO: continue here
    messageFeedback.innerText = 'Bitte kurz gedulden.';
    
    let response = await fetch('./blog-post.php', {
        method: 'POST',
        // headers: {'Content-Type': 'application/json'},
        body: formData
    });
    console.log(response);
    if (response.ok) {
        response = await response.json();
        response = JSON.parse(response);
        console.log(response);
        messageFeedback.innerText = response.message;
    } else {
        messageFeedback.innerText = 'Es ist ein unerwarteter Fehler aufgetreten.';
    }
    location.reload();
    message.innerText = '';
};

send.onclick = e => {
    e.preventDefault();
    handleBlog(file);
};


// delete post

const deleteButtons = document.querySelectorAll('.post-delete');
const deleteModal = document.getElementById('delete-modal');

deleteButtons.forEach((button, index) => {
    button.onclick = () => {
        const deletePostButton = document.getElementById('delete-post-confirmation');
        const printInfo = document.getElementById('post-info');
        const id = button.getAttribute('data-id');
        const message = button.getAttribute('data-message');
        printInfo.innerText = '«' + message.substring(0, 25) + '»';
        deleteModal.classList.add('open');

        deletePostButton.onclick = async () => {
            let data = {
                id: id,
                message: message
            };
            data = JSON.stringify(data);
            let response = await fetch('./blog-delete.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: data
            });
            console.log(response);
            if (response.ok) {
                response = await response.json();
                console.log(response);
                location.reload();
            }        
        };
    };
});


// logout

const logout = document.getElementById('logout');

logout.onclick = async () => {
    try {
        let response = await fetch('./logout.php');
        if (response.ok) {
            response = await response.json();
            console.log(response);
            window.location.href = './index.php';
        }
    } catch (error) {
        console.log(error);
    }
}