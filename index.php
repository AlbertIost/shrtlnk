<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>SHRTLNK</title>
</head>
<body>
    <div class="header">
        <h1>ShrtLnk</h1>
        <h2>Укорачиватель ссылок</h2>
    </div>
    <div class="main">
        <div class="form">
            <form id="cut-form">
                <input class="link" id="link" name="link" type="text">
                <input class="btn " id="send" type="submit" value="Shrt">
                <input class="btn hidden" id="copy" type="button" value="✂">
            </form>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("form").submit(function () {
                // Получение ID формы
                var formID = $(this).attr('id');
                // Добавление решётки к имени ID
                var formNm = $('#' + formID);
                $.ajax({
                    type: "POST",
                    url: 'cut_link/cut_link.php',
                    data: formNm.serialize(),
                    beforeSend: function () {
                    },
                    success: function (data) {
                        $('input#link').val(data);
                        $('input.btn').toggleClass('hidden');
                    },
                    error: function (jqXHR, text, error) {
                    }
                });
                return false;
            });
            $('input#copy').click(function () {
                $('input#link').select();
                document.execCommand("copy");
            });
        });
    </script>
</body>
</html>
