document.addEventListener("DOMContentLoaded", function () {
    const moduleContainer = document.querySelector(".mod-joomlabuilder");
    if (!moduleContainer) return;

    const templateItems = moduleContainer.querySelectorAll(".template-item");
    templateItems.forEach(item => {
        item.addEventListener("mouseover", () => {
            item.style.backgroundColor = "#e9ecef";
            item.style.borderColor = "#adb5bd";
        });

        item.addEventListener("mouseout", () => {
            item.style.backgroundColor = "#ffffff";
            item.style.borderColor = "#ddd";
        });
    });

    const buttons = moduleContainer.querySelectorAll(".btn");
    buttons.forEach(button => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            alert("Button Clicked: " + button.textContent);
        });
    });
});
 
