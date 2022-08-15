$(function () {
    $("#btn").on("click", function (event) {
        id = $("#id").val();
        $.ajax({
            type: "POST",
            url: "",
            data: { id: id },
            dataType: "json",
        }).done(function (data) {});
    });
});
