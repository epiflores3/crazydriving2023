const PASSWORD_FORM = document.getElementById('password-form');

PASSWORD_FORM.addEventListener('submit', async (event) => {
   
    event.preventDefault();
  
    const FORM = new FormData(PASSWORD_FORM);

    const JSON = await dataFetch(USER_API, 'resetPassword', FORM);

    if (JSON.status) {
    
        sweetAlert(1, JSON.message, true, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});