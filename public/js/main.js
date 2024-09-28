document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function (event) {

        document.getElementById('loading-spinner').style.display = 'block';
        document.getElementById('loading-overlay').style.display = 'block';

        const submitButtons = this.querySelectorAll('button[type="submit"]');

        submitButtons.forEach(button => {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        });
    });
});
