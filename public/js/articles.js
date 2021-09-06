document.addEventListener("DOMContentLoaded", function () {
    $("#msg-box").on("click", function () {
        $("#msg-box").css("display", "none");
    });

    $("#error-box").on("click", function () {
        $("#error-box").css("display", "none");
    });
});
