document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('image-preview');
    const uploadText = document.getElementById('upload-text');
    const uploadBtn = document.getElementById('file-upload-btn');
    const deleteIcon = document.getElementById('delete-icon');
    const blurBackground = document.querySelector('.blur-background'); 
    

    // Check if the image is already loaded
    if (preview.src !== "#" && preview.src.trim() !== "") {
        preview.style.display = 'block'; // Show the image
        uploadText.style.display = 'none'; // Hide the upload text
        uploadBtn.style.display = 'none'; // Hide the upload button
        deleteIcon.style.display = 'block'; // Show the delete icon
        blurBackground.style.backgroundImage = `url(${preview.src})`; 
        blurBackground.style.display = 'block'; 
    }
});