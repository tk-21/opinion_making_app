$(".delete-btn").click(function () {
    //クリックされたボタンのデータidを取得
    let todo_id = $(this).data("id");
    if (confirm("削除しますがよろしいですか？ id:" + todo_id)) {
        //一度ボタンが押されたら非活性化する
        $(".delete-btn").prop("disabled", true);
        let data = {};
        data.todo_id = todo_id;

        $.ajax({
            url: "../../controllers/delete.php", //通信先
            type: "post",
            data: data, //データを渡して通信
        }).then(
            //成功したとき
            function (data) {
                let json = JSON.parse(data); //オブジェクト化
                console.log("success", json);
                if (json.result == "success") {
                    //index.phpに遷移させる
                    window.location.href = "./index.php";
                } else {
                    //削除に失敗
                    console.log("failed to delete");
                    alert("failed to delete.");
                    //削除ボタン活性化
                    $(".delete-btn").prop("disabled", false);
                }
            },
            //失敗したとき
            function () {
                console.log("fail");
                alert("fail");
                //削除ボタン活性化
                $(".delete-btn").prop("disabled", false);
            }
        );
    }
});
