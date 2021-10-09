const navbar = document.getElementById("dropdown");
const dropdownContent = document.getElementById("dropdown-content");

dropdownContent.style.display = "none";

document.addEventListener("click", function(event) {
    if (event.target == navbar
        && dropdownContent.style.display == "none"
    ) {
        dropdownContent.style.display = "flex";
    } else {
        dropdownContent.style.display = "none";
    }
});