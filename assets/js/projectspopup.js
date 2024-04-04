function openForm() {
    var myForm = document.getElementById("myForm");
    if (myForm) {
        myForm.style.display = "block";
    } else {
        console.error("Element with ID 'myForm' not found.");
    }
}

function closeForm() {
    var myForm = document.getElementById("myForm");
    if (myForm) {
        myForm.style.display = "none";
    } else {
        console.error("Element with ID 'myForm' not found.");
    }
}
