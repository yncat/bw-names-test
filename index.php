<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <title>名前リスト</title>
</head>

<body>
  <?php
  require_once("main.php");
  if (!isset($_REQUEST["action"])) {
    die("引数が指定されてません、ざんねーん");
  }
  switch ($_REQUEST["action"]) {
    case "show":
      show();
      break;
    case "click":
      click();
      break;
    case "edit":
      edit();
      break;
    case "submit":
      submit();
      break;
    default:
      die("そんな引数知りません、ざんねーん");
  }
  ?>
</body>

</html>