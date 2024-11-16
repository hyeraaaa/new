document.getElementById('file-upload-btn').addEventListener('click', function(event) {
    event.preventDefault(); 
    document.getElementById('image').click(); 
});



function imagePreview() {
    const input = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const uploadText = document.getElementById('upload-text');
    const uploadBtn = document.getElementById('file-upload-btn');
    const deleteIcon = document.getElementById('delete-icon');
    const blurBackground = document.querySelector('.blur-background'); 
    const container = document.querySelector('.upload-image-container'); 

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result; // Set the image source to the uploaded file
            preview.style.display = 'block'; // Show the image
            uploadText.style.display = 'none'; // Hide the upload text
            uploadBtn.style.display = 'none'; // Hide the upload button
            deleteIcon.style.display = 'block'; // Show the delete icon
            blurBackground.style.backgroundImage = `url(${e.target.result})`; // Set the background image
            blurBackground.style.display = 'block'; // Show the blurred background
            
            container.classList.add('image-uploaded'); // Add class to show delete icon
        };

        reader.readAsDataURL(input.files[0]); // Read the file as a data URL
    }
}

function deleteImage() {
    const preview = document.getElementById('image-preview');
    const input = document.getElementById('image');
    const uploadText = document.getElementById('upload-text');
    const uploadBtn = document.getElementById('file-upload-btn');
    const deleteIcon = document.getElementById('delete-icon');
    const blurBackground = document.querySelector('.blur-background'); 
    const container = document.querySelector('.upload-image-container'); // Container for managing classes

    preview.src = '#'; // Reset the image source
    preview.style.display = 'none'; // Hide the image
    input.value = ''; // Clear the input file
    uploadText.style.display = 'block'; // Show the upload text
    uploadBtn.style.display = 'block'; // Show the upload button
    deleteIcon.style.display = 'none'; // Hide the delete icon
    blurBackground.style.display = 'none'; // Hide the blurred background

    container.classList.remove('image-uploaded'); // Remove class to hide delete icon
}

$(document).ready(function() {
    let lastCheckedState = {};

    function updateRecipientCount() {
        let yearLevels = $('input[name="year_level[]"]:checked').map(function() {
            return this.value;
        }).get();
        let departments = $('input[name="department[]"]:checked').map(function() {
            return this.value;
        }).get();
        let courses = $('input[name="course[]"]:checked').map(function() {
            return this.value;
        }).get();

        if (yearLevels.length && departments.length && courses.length) {
            $.ajax({
                url: 'get_recipient_count.php',
                method: 'POST',
                data: {
                    year_levels: yearLevels,
                    departments: departments,
                    courses: courses
                },
                success: function(response) {
                    $('#recipientCount').text(response);
                    $('#smsInfo').show();
                }
            });
        } else {
            $('#smsInfo').hide();
        }
    }

    $('input[name="year_level[]"], input[name="department[]"], input[name="course[]"]').change(updateRecipientCount);

    $('#sendSms').change(function() {
        if (this.checked) {
            updateRecipientCount();
        } else {
            $('#smsInfo').hide();
        }
    });

    $('#submitBtn').click(function(e) {
        if ($('#sendSms').is(':checked')) {
            let recipientCount = parseInt($('#recipientCount').text());
            if (recipientCount >= 1) { 
                e.preventDefault();
                if (confirm(`You are about to send SMS to ${recipientCount} recipients. Are you sure you want to proceed?`)) {
                    $('form').submit();
                }
            }
        }
    });

    $('#sendSms').each(function() {
        lastCheckedState[this.id] = this.checked;
    });

    $('#sendSms').change(function() {
        if (!Object.values(lastCheckedState).some(Boolean) && this.checked) {
            alert("Remember: Students will only receive SMS if they match ALL selected tags.");
        }
        
        lastCheckedState[this.id] = this.checked;
    });
});





