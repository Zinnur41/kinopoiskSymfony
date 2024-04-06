document.addEventListener("DOMContentLoaded", function () {
    const deleteForm = document.querySelector('.deleteSubscribe');
    if (deleteForm) {
        deleteForm.addEventListener('click', (event) => {
            let isConfirm = confirm('Вы уверены,что хотите отменить подписку?');
            if (isConfirm) {
                return true
            } else {
                event.preventDefault();
            }
        })
    }
})

const confirmForm = document.querySelector('.subscribe');
let days = document.getElementsByName('days')[0];
let day = days.options[days.selectedIndex].text;

days.addEventListener('change', () => {
    day = days.options[days.selectedIndex].text;
});

confirmForm.addEventListener('click', (event) => {
    let isConfirm = confirm(`Вы уверены, что хотите оформить подписку на ${day}?`);
    if (isConfirm) {
        return true;
    } else {
        event.preventDefault();
    }
})