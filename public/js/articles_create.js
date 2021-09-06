let request = new XMLHttpRequest();

// 擋住表單 submit, 插入 state 後再送出
// 一開始以原生 XHR + formData object 送出 reqest
// 但無法處理回傳之錯誤訊息
// 改用 AJAX + $("form").serialize() 處理表單資料
// 可以成功處理回傳錯誤訊息 JSON 
// 另上述兩種方法皆無法以 laravel 內建功能 redirect
// 使用 window.location 做跳轉
function createArticle(state) {
    // let formData = new FormData($("#create-article")[0]);
    // formData.append("state", state);
    // request.open("POST", "/firstLaravel/public/articles");
    // request.setRequestHeader(
    //     "X-CSRF-TOKEN",
    //     $('meta[name="csrf-token"]').attr("content")
    // );
    // request.send(formData);
    // console.log($("#create-article").serialize() + `&state=${state}`);
    if ($("#error-box div").length > 0) {
        $("#error-box").remove();
    }
    $.ajax(
        {
            type: "POST",
            // processData: false,
            // contentType: false,
            // cache: false,
            contentType: "application/x-www-form-urlencoded",
            dataType: "json",
            url: "/firstLaravel/public/articles",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: $("#create-article").serialize() + `&state=${state}`,
            success: function (response) {
                window.location = response.url;
            },
            error: function (response) {
                console.log(response.responseJSON.errors);
                $("#error-box").append(
                    `<div class="errors p-3 bg-red-400 text-red-50 rounded fixed top-0 w-full flex justify-between items-center" id="msg-box"><ul class="list-none font-bold text-base font-sans"></ul></div>`
                );
                $.each(response.responseJSON.errors, function (key, value) {
                    $("#msg-box ul").append(
                        '<li class="font-bold text-base font-sans m-1">' +
                            value +
                            "</li>"
                    );
                });
            },
        },
        "json"
    );
}

document.addEventListener("DOMContentLoaded", function () {
    $("#btn-draft").on("click", function (event) {
        event.preventDefault();
        createArticle("draft");
    });

    $("#btn-publish").on("click", function (event) {
        event.preventDefault();
        createArticle("published");
    });
});
