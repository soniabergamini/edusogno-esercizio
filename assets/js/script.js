// Waits for page load
window.addEventListener('load', function () {

    // VARIABLES
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passInput = document.getElementById('password');
    const passSecurity = document.getElementById('passSecurity');
    const errorAlert = document.querySelector('div.dBlock.alert');
    const successAlert = document.querySelector('div.dBlock.success');
    const resetPass = document.getElementById('resetPass');
    const deleteBtns = document.querySelectorAll('.deleteBtn');
    const deleteForm = document.getElementById('deleteForm');
    const editBtns = document.querySelectorAll('.editBtn');
    const editForm = document.getElementById('editForm');
    const createBtn = document.getElementById('addEventBtn');
    const createForm = document.getElementById('createForm');
    let emailResetPass = null;


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
        if(passSecurity) {
            passSecurity.addEventListener('click', function () {
                passInput.type = passInput.type === 'password' ? 'text' : 'password';
                form.addEventListener('submit', () => passInput.type === 'text' && (passInput.type = 'password'), { once: true });
            });
        }

        // Hide error message after 15 seconds
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.opacity = '0';
                this.setTimeout(() => {
                    errorAlert.classList.remove('dBlock');
                    errorAlert.classList.add('dNone');
                }, 1000);
            }, 15000);
        }

        // Hide success message after 10 seconds
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                this.setTimeout(() => {
                    successAlert.classList.remove('dBlock');
                    successAlert.classList.add('dNone');
                }, 1000);
            }, 10000);
        }

        // Ask user email to reset password and send it to PHP via API call
        if (resetPass) {
            resetPass.addEventListener('click', function () {
                emailResetPass = prompt('Inserisci la tua email qui sotto per reimpostare la password:');
                if (!validateEmail(emailResetPass)) {
                    // Invalid email
                    alert('⚠️ Email non valida. Inserisci un indirizzo email valido per proseguire. Esempio: name@example.it');
                } else {
                    // Send email to /reset-password route
                    let params = new URLSearchParams();
                    params.append('email', emailResetPass);

                    axios.post('/reset-password', params).then((response) => {
                        alert('📩 Se il tuo indirizzo email è associato a un account, tra qualche minuto riceverai una mail con il link per reimpostare la password');
                        console.log('Sent reset password email via api. Response: ', response);
                    }).catch((error) => {
                        console.error('Error during reset password API call: ', error);
                        alert('⚠️ Purtroppo qualcosa è andato storto! Riprova più tardi.');
                    })
                }
            })
        }
    }

    if (deleteBtns) {
        deleteBtns.forEach(button => {
            button.addEventListener('click', function () {
                const eventID = this.getAttribute('data-event-id');
                const eventName = this.getAttribute('data-event-name');
                const eventDate = this.getAttribute('data-event-date');
                const eventAttendees = this.getAttribute('data-event-attendees');
                const eventDescription = this.getAttribute('data-event-description');

                deleteForm.classList.remove('dNone');
                deleteForm.classList.add('dBlock');
                deleteForm.querySelector('input[name="eventID"]').value = eventID;
                deleteForm.querySelector('input[name="eventName"]').value = eventName;
                deleteForm.querySelector('input[name="eventDate"]').value = eventDate;
                deleteForm.querySelector('input[name="eventAttendees"]').value = eventAttendees;
                deleteForm.querySelector('input[name="eventDescription"]').value = eventDescription;
                document.getElementById('formEventName').innerText = eventName;
                document.querySelector('#dashboardSec>div:first-child').classList.add('overlay');
            });
        });
    }

    if(deleteForm) {
        document.getElementById('closeBtn').addEventListener('click', function (event) {
            event.preventDefault();
            deleteForm.classList.add('dNone');
            deleteForm.classList.remove('dBlock');
            deleteForm.querySelector('input[name="eventID"]').value = '';
            deleteForm.querySelector('input[name="eventName"]').value = '';
            deleteForm.querySelector('input[name="eventDate"]').value = '';
            deleteForm.querySelector('input[name="eventAttendees"]').value = '';
            deleteForm.querySelector('input[name="eventDescription"]').value = '';
            document.getElementById('formEventName').innerText = '';
            document.querySelector('#dashboardSec>div:first-child').classList.remove('overlay');
        })
    }

    if (editBtns) {
        editBtns.forEach(button => {
            button.addEventListener('click', function () {
                const eventID = this.getAttribute('data-event-id');
                const eventName = this.getAttribute('data-event-name');
                const eventDate = this.getAttribute('data-event-date');
                [date, time] = eventDate.split(' ');
                const eventAttendees = this.getAttribute('data-event-attendees');
                const eventDescription = this.getAttribute('data-event-description');                

                editForm.classList.remove('dNone');
                editForm.classList.add('dBlock');
                editForm.querySelector('input[name="eventID"]').value = eventID;
                editForm.querySelector('input[name="eventName"]').value = eventName;
                editForm.querySelector('input[name="eventDate"]').value = date;
                editForm.querySelector('input[name="eventTime"]').value = time;
                editForm.querySelector('input[name="eventAttendees"]').value = eventAttendees;
                editForm.querySelector('input[name="eventDescription"]').value = eventDescription;
                document.querySelector('#dashboardSec>div:first-child').classList.add('overlay');
            });
        });
    }

    if(editForm) {
        document.getElementById('btnClose').addEventListener('click', function (event) {
            event.preventDefault();
            editForm.classList.add('dNone');
            editForm.classList.remove('dBlock');
            editForm.querySelector('input[name="eventID"]').value = '';
            editForm.querySelector('input[name="eventName"]').value = '';
            editForm.querySelector('input[name="eventDate"]').value = '';
            editForm.querySelector('input[name="eventTime"]').value = '';
            editForm.querySelector('input[name="eventAttendees"]').value = '';
            editForm.querySelector('input[name="eventDescription"]').value = '';
            document.querySelector('#dashboardSec>div:first-child').classList.remove('overlay');
        })
    }

    createBtn.addEventListener('click', function () {
        createForm.classList.remove('dNone');
        createForm.classList.add('dBlock');
        document.querySelector('#dashboardSec>div:first-child').classList.add('overlay');
    })

    if(createForm) {
        document.getElementById('btnCancel').addEventListener('click', function (event) {
            event.preventDefault();
            createForm.classList.add('dNone');
            createForm.classList.remove('dBlock');
            createForm.querySelector('input[name="eventName"]').value = '';
            createForm.querySelector('input[name="eventDate"]').value = '';
            createForm.querySelector('input[name="eventTime"]').value = '';
            createForm.querySelector('input[name="eventAttendees"]').value = '';
            createForm.querySelector('input[name="eventDescription"]').value = '';
            document.querySelector('#dashboardSec>div:first-child').classList.remove('overlay');
        })
    }
});