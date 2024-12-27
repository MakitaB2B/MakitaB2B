const steps = document.querySelectorAll('.step-circle');
        const forms = document.querySelectorAll('.step-form');
        let currentStep = 1;

        function showStep(step) {
            forms.forEach(form => form.classList.remove('active'));
            forms[step - 1].classList.add('active');
            
            steps.forEach((stepCircle, index) => {
                if (index + 1 < step) {
                    stepCircle.classList.add('completed');
                    stepCircle.classList.remove('active');
                } else if (index + 1 === step) {
                    stepCircle.classList.add('active');
                    stepCircle.classList.remove('completed');
                } else {
                    stepCircle.classList.remove('active', 'completed');
                }
            });
        }

        // Handle OTP input
        const otpInputs = document.querySelectorAll('.otp-inputs input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        // Form submission handlers
        document.getElementById('step1Form').addEventListener('submit', (e) => {
            e.preventDefault();
            currentStep = 2;
            showStep(currentStep);
        });

        document.getElementById('step2Form').addEventListener('submit', (e) => {
            e.preventDefault();
            currentStep = 3;
            showStep(currentStep);
        });

        document.getElementById('step3Form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Registration completed successfully!');
        });