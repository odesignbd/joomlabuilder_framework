/* JoomlaBuilder Plugin - JavaScript Enhancements */

document.addEventListener("DOMContentLoaded", function () {
    console.log("JoomlaBuilder Plugin Loaded");

    // Handle button clicks
    document.querySelectorAll(".joomlabuilder-button").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            alert("JoomlaBuilder Button Clicked: " + this.textContent);
        });
    });

    // Form validation
    document.querySelectorAll(".joomlabuilder-form").forEach(form => {
        form.addEventListener("submit", function (event) {
            let isValid = true;
            this.querySelectorAll("input[required], select[required]").forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add("error");
                } else {
                    field.classList.remove("error");
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert("Please fill in all required fields.");
            }
        });
    });

    // Table row highlight on hover
    document.querySelectorAll(".joomlabuilder-table tr").forEach(row => {
        row.addEventListener("mouseover", function () {
            this.style.backgroundColor = "#f1f1f1";
        });
        row.addEventListener("mouseout", function () {
            this.style.backgroundColor = "";
        });
    });
});
 
