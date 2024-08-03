document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-link');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            const target = this.getAttribute('data-tab');

            tabs.forEach(tab => {
                tab.classList.remove('active');
            });

            this.classList.add('active');

            contents.forEach(content => {
                content.classList.remove('active');
            });

            document.getElementById(target).classList.add('active');
        });
    });

    document.querySelector('.tab-link').click();
});
