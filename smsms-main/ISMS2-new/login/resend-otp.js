document.addEventListener('DOMContentLoaded', function() {
    // Get all OTP input fields
    const otpInputs = document.querySelectorAll('.otp-input');
    const otpHiddenInput = document.getElementById('otp');
    const resendButton = document.getElementById('resendOTP');
    let timer = 10;

    // Function to start countdown timer
    function startCountdown() {
        resendButton.disabled = true;
        resendButton.classList.remove('text-danger'); 
        resendButton.classList.add('text-secondary');  
        
        const interval = setInterval(() => {
            resendButton.textContent = `Resend OTP (${timer}s)`;
            timer--;

            if (timer < 0) {
                clearInterval(interval);
                resendButton.disabled = false;
                resendButton.textContent = 'Resend OTP';
                resendButton.classList.remove('text-secondary');  // Remove secondary style
                resendButton.classList.add('text-danger');  // Add danger style when enabled
                timer = 10;
            }
        }, 1000);
    }

    // Start initial countdown
    startCountdown();

    // Handle resend button click
    resendButton.addEventListener('click', function() {
        const email = document.getElementById('email').value;
        
        // Make AJAX call to send_otp.php
        $.ajax({
            url: 'send_otp.php',
            method: 'POST',
            data: { email: email },
            success: function(response) {
                // You can handle the response here if needed
                console.log('OTP sent successfully');
                startCountdown();
            },
            error: function(xhr, status, error) {
                console.error('Error sending OTP:', error);
                // Handle error if needed
            }
        });
    });

    // Handle OTP input
    otpInputs.forEach((input, index) => {
        // Handle input
        input.addEventListener('input', function(e) {
            // Allow only numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            // Move to next input if value is entered
            if (this.value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            // Update hidden input with complete OTP
            updateHiddenInput();
        });

        // Handle keydown
        input.addEventListener('keydown', function(e) {
            // Move to previous input on backspace if current input is empty
            if (e.key === 'Backspace' && !this.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            
            if (pastedData) {
                // Distribute pasted numbers across inputs
                pastedData.split('').forEach((digit, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = digit;
                    }
                });
                
                // Focus last filled input or next empty input
                const lastFilledIndex = Math.min(pastedData.length - 1, otpInputs.length - 1);
                otpInputs[lastFilledIndex].focus();
                
                updateHiddenInput();
            }
        });
    });

    // Function to update hidden input with complete OTP
    function updateHiddenInput() {
        const otp = Array.from(otpInputs).map(input => input.value).join('');
        otpHiddenInput.value = otp;
    }

    // Form validation
    document.getElementById('otp_form').addEventListener('submit', function(e) {
        const otp = otpHiddenInput.value;
        if (otp.length !== 6) {
            e.preventDefault();
            document.querySelector('.otp-input').parentElement.nextElementSibling.style.display = 'block';
            document.querySelector('.otp-input').parentElement.nextElementSibling.textContent = 'Please enter a valid 6-digit OTP code';
        }
    });
});