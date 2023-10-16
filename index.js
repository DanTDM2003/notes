const note_box = document.querySelectorAll(".note-box");
note_box.forEach((element) => {
    element.addEventListener("mouseover", () => {
        element.firstElementChild.style.display = "flex";
    })
    element.addEventListener("mouseout", () => {
        element.firstElementChild.style.display = "none";
    })
});

document.getElementById("trash-btn").onclick = function() {
    window.location.href = "trash.php";
    //window.location.reload();
}

function changePage() {
    window.location.href = "notes-manage.php";
}

function deleteNote() {
    window.location.href = "delete-note.php";
}