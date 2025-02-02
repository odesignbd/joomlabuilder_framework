/* JoomlaBuilder Frontend Template - Custom JavaScript */

document.addEventListener("DOMContentLoaded", function () {
    console.log("JoomlaBuilder Template Loaded");

    // Toggle Dark Mode
    const darkModeToggle = document.createElement("button");
    darkModeToggle.innerText = "Toggle Dark Mode";
    darkModeToggle.classList.add("dark-mode-toggle");
    document.body.prepend(darkModeToggle);
    
    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");
        localStorage.setItem("darkMode", document.body.classList.contains("dark-mode") ? "enabled" : "disabled");
    });
    
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
    }

    // Smooth Scroll for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function (event) {
            event.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 50,
                    behavior: "smooth"
                });
            }
        });
    });

    // Mobile Menu Toggle
    const menuToggle = document.createElement("button");
    menuToggle.innerText = "Menu";
    menuToggle.classList.add("menu-toggle");
    document.querySelector(".navbar").prepend(menuToggle);
    
    menuToggle.addEventListener("click", function () {
        document.querySelector(".navbar").classList.toggle("open");
    });
});
 
