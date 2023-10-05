// Waits for page load
window.addEventListener('load', function () {

    // VARIABLES

    // Form Elements
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passInput = document.getElementById('password');
    const passSecurity = document.getElementById('passSecurity');
    const errorAlert = document.querySelector('div.dBlock.alert');


    // FUNCTIONS

    // Validates an email address
    function validateEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }


    if (form) {

        // Checks invalid email input
        form.addEventListener('submit', function (event) {
            if (!validateEmail(emailInput.value)) {
                event.preventDefault();
                alert('⚠️ Email non valida! Inserisci un indirizzo email valido per proseguire. Esempio: name@example.it');
            }
        });

        // Toggle password visibility on icon click
        passSecurity.addEventListener('click', function () {
            passInput.type = passInput.type === 'password' ? 'text' : 'password';
            form.addEventListener('submit', () => passInput.type === 'text' && (passInput.type = 'password'), { once: true });
        });

        // Hide error message after 5 seconds
        if(errorAlert) {
            setTimeout(() => {
                errorAlert.style.opacity = '0';
                this.setTimeout(() => {
                    errorAlert.classList.remove('dBlock');
                    errorAlert.classList.add('dNone');
                }, 1000);
            }, 5000);
        }
    }

});