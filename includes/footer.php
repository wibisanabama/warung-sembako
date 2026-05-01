    <script>
        // Simple Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const icon = themeToggle.querySelector('i');
        
        // Check for saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            body.setAttribute('data-theme', savedTheme);
            updateIcon(savedTheme);
        }
        
        themeToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });
        
        function updateIcon(theme) {
            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                themeToggle.lastChild.textContent = ' Light Mode';
            } else {
                icon.className = 'fas fa-moon';
                themeToggle.lastChild.textContent = ' Dark Mode';
            }
        }
    </script>
</body>
</html>
