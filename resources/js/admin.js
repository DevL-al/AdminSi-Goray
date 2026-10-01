/* =====================================================
   SIDEBAR
===================================================== */

const sidebar = document.getElementById("sidebar");
const sidebarToggle = document.getElementById("sidebarToggle");
const sidebarClose = document.getElementById("sidebarClose");
const sidebarOverlay = document.getElementById("sidebarOverlay");

if (sidebarToggle) {
    sidebarToggle.addEventListener("click", function () {
        sidebar.classList.add("open");

        sidebarOverlay.classList.add("show");
    });
}

if (sidebarClose) {
    sidebarClose.addEventListener("click", function () {
        sidebar.classList.remove("open");

        sidebarOverlay.classList.remove("show");
    });
}

if (sidebarOverlay) {
    sidebarOverlay.addEventListener("click", function () {
        sidebar.classList.remove("open");

        sidebarOverlay.classList.remove("show");
    });
}

/* =====================================================
   DARK MODE
===================================================== */

const themeToggle = document.getElementById("themeToggle");
const themeIcon = document.getElementById("themeIcon");

const savedTheme = localStorage.getItem("sigoray-theme");

if (savedTheme === "dark") {
    document.body.classList.add("dark");

    if (themeIcon) {
        themeIcon.textContent = "light_mode";
    }
}

if (themeToggle) {
    themeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark");

        const isDark = document.body.classList.contains("dark");

        if (isDark) {
            localStorage.setItem("sigoray-theme", "dark");

            themeIcon.textContent = "light_mode";
        } else {
            localStorage.setItem("sigoray-theme", "light");

            themeIcon.textContent = "dark_mode";
        }
    });
}
