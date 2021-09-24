window.onload = function() {
    const modSearchInput = document.getElementById("mod-search-input");

    modSearchInput.addEventListener("keyup", function(event) {
        if (event.key == "Enter") {
            window.location.href = "/search/" + modSearchInput.value;
        }
    });
};