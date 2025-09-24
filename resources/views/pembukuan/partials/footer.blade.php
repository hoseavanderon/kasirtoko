<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/pembukuan/pembukuan.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof window.initPageScripts === "function") {
                window.initPageScripts();
            }

        });
        function toggleFullscreen(btn) {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    btn.querySelector("i").classList.remove("fa-expand");
                    btn.querySelector("i").classList.add("fa-compress");
                }).catch(err => {
                    console.error(`Error attempting fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen().then(() => {
                    btn.querySelector("i").classList.remove("fa-compress");
                    btn.querySelector("i").classList.add("fa-expand");
                });
            }
        }
    </script>
</body>
</html>
