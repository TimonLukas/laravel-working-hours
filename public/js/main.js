$(".btn-danger").on("click", function (e) {
    var answer = confirm("Are you sure?");
    if (answer !== true) {
        e.preventDefault();
    }
});