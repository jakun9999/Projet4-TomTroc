const coverInput = document.getElementById('cover');
const changeButton = document.getElementById('change-cover');
const filename = document.getElementById('filename');

changeButton.addEventListener('click', () => {
    coverInput.click();
});

// Display preview of selected file
coverInput.addEventListener('change', () => {
    const file = coverInput.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
    }
});
    