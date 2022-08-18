// $(function () {
//     $("#btn").on("click", function (event) {
//         event.preventDefault();
//     }),
//         // id = $("#id").val();
//         $.ajax({
//             type: "POST",
//             url: "",
//             data: { id: id },
//             dataType: "json",
//         })
//             .done(function (data) {})
//             .fail(function (data) {})
//             .always(function (data) {});
// });

// $("#objection_register").on("click", function () {
//     let data = {
//         topic_id: $("#topic_id").val(),
//         form_type: $("#form_type").val(),
//         objection: $("#objection").val(),
//     };

//     $.ajax({
//         url: window.location.href,
//         type: "post",
//         data: data,
//     }).then(
//         //     //成功したとき
//         function (data) {
//             alert("成功");
//         // let json = JSON.parse(data); //オブジェクト化
//         // console.log("success", json);
//         //     if (json.result == "success") {
//         //         //index.phpに遷移させる
// let uri = new URL(window.location.href);
// let url = uri.href;
// window.location.href = url;
//         //     } else {
//         //         //削除に失敗
//         //         console.log("failed to delete");
//         //         alert("failed to delete.");
//         //         //削除ボタン活性化
//         //         $(".delete-btn").prop("disabled", false);
//         //     }
//         }
//         //     //失敗したとき
//         //     function () {
//         //         console.log("fail");
//         //         alert("fail");
//         //         //削除ボタン活性化
//         //         $(".delete-btn").prop("disabled", false);
//         //     }
//     );
//     return false;
// });

$(".delete_objection").on("click", function () {
    let uri = new URL(window.location.href);
    let url = uri.origin;

    let topic_id = $("#topic_id").val();

    let objection_id = $(this).data("id");

    let data = {
        objection_id: objection_id,
    };

    $.ajax({
        url: url + "/delete",
        type: "post",
        data: data,
    }).then(
        //     //成功したとき
        function (data) {
            if (data) {
                alert("成功");
            }
            //         // let json = JSON.parse(data); //オブジェクト化
            //         // console.log("success", json);
            //         //     if (json.result == "success") {
            //         //         //index.phpに遷移させる

            window.location.href = url + "/detail?id=" + topic_id;
            // //         //     } else {
            //         //         //削除に失敗
            //         //         console.log("failed to delete");
            //         //         alert("failed to delete.");
            //         //         //削除ボタン活性化
            //         //         $(".delete-btn").prop("disabled", false);
            //         //     }
        }
        //     //失敗したとき
        //     function () {
        //         console.log("fail");
        //         alert("fail");
        //         //削除ボタン活性化
        //         $(".delete-btn").prop("disabled", false);
        //     }
    );
});

// });
// $(".todo-checkbox").change(function () {
//     let todo_id = $(this).data("id");
//     //data配列にtodo_idを渡す

//     let data = {};
//     data.todo_id = todo_id;

//     $.ajax({
//         url: "./update_status.php", //通信先
//         type: "post", //リクエストメソッド
//         data: data, //データを渡して通信
//     }).then(
//         //ajax通信に成功したとき
//         function (data) {
//             let json = JSON.parse(data); //文字列データをjson化する
//             console.log("success", json);
//             //jsonのresultプロパティがsuccessだったら、
//             if (json.result == "success") {
//                 console.log("success");

//                 //.todo-checkboxクラスから見て2つ上の親要素の中にある.statusクラスのテキストを取得
//                 let text = $(this).parent().parent().find(".status").text();
//                 console.log(text);

//                 //入れ替え
//                 if (text == "完了") {
//                     text = "未完了";
//                 } else if (text == "未完了") {
//                     text = "完了";
//                 }

//                 //入れ替えたものを設定
//                 $(this).parent().parent().find(".status").text(text);
//             } else {
//                 //削除に失敗
//                 console.log("failed to update status");
//                 alert("failed to update status.");
//             }
//         }.bind(this), //ajax通信の中でthisがうまく取得できないときはbind(this)が記述する
//         //ajax通信に失敗したとき
//         function () {
//             console.log("fail");
//             alert("failed to ajax");
//         }
//     );
// });
