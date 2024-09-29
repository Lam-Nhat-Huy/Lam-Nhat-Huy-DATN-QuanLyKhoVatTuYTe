function submitAnimation(event) {
    event.preventDefault();

    document.getElementById('loading').style.display = 'block';
    document.getElementById('loading-overlay').style.display = 'block';

    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');

    submitButton.disabled = true;

    // setTimeout(() => {
    //     document.getElementById('loading').style.display = 'none';
    //     document.getElementById('loading-overlay').style.display = 'none';

    //     submitButton.disabled = false;

    // }, 2000);
    form.submit();
}