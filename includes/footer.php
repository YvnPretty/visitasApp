    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('themeToggle');
            const root = document.documentElement;
            
            // Función para cambiar tema
            btn.addEventListener('click', () => {
                const isDark = root.getAttribute('data-bs-theme') === 'dark';
                const newTheme = isDark ? 'light' : 'dark';
                root.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });

            // Cargar tema guardado al inicio
            const saved = localStorage.getItem('theme') || 'light';
            root.setAttribute('data-bs-theme', saved);
        });
    </script>
</body>
</html>
