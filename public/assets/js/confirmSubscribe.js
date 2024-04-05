let form = document.querySelector('.subscribe');
form.addEventListener('click', (event) => {
    let isConfirm = confirm('Вы уверены, что хотите оформить подписку?');
    if (isConfirm) {
        return true;
    } else {
        event.preventDefault();
    }
})