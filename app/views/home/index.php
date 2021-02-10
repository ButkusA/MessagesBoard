<?php
defined('CORE_PATH') or exit('no access');
$home = new HomeController();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Žinutės</title>
    <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css"/>
</head>
<body>
<div id="wrapper">
    <h1>Jūsų žinutės</h1>
    <form method="post" id='form' action="PostController/index">
        <p class="<?php if (!empty($_GET['fullname'])) echo 'err' ?>">
            <label for="fullname">Vardas, pavardė *</label><br/>
            <?php if (!empty($_GET['fullname'])) echo $_GET['fullname'] ?>
            <input id="fullname" type="text" name="fullname" value=""/>
        </p>
        <p class="<?php if (!empty($_GET['birthdate'])) echo 'err' ?>">
            <label for="birthdate">Gimimo data * (yyyy/mm/dd)</label><br/>
            <?php if (!empty($_GET['birthdate'])) echo $_GET['birthdate'] ?>
            <input id="birthdate" type="text" name="birthdate" value=""/>
        </p>
        <p class="<?php if (!empty($_GET['email'])) echo 'err' ?>">
            <label for="email">El.pašto adresas</label><br/>
            <?php if (!empty($_GET['email'])) echo $_GET['email'] ?>
            <input id="email" type="text" name="email" value=""/>
        </p>
        <p class="<?php if (!empty($_GET['message'])) echo 'err' ?>">
            <label for="message">Jūsų žinutė *</label><br/>
            <?php if (!empty($_GET['message'])) echo $_GET['message'] ?>
            <textarea id="message" name="message" class="text"></textarea>
        </p>
        <p>
            <span>* - privalomi laukai</span>
            <input type="submit" value="Skelbti" id="submit"/>
            <img src="img/ajax-loader.gif" alt="Loading..." id="img"/>
        </p>
    </form>
    <ul id="posts">
        <?php if (empty ($data)) {
            echo '<li>' . '<strong>' . 'Šiuo metu žinučių nėra. Būk pirmas!' . '</strong>' . '</li>';
        }
        ?>
        <li>
            <?php if ((!empty($data)) and $data): ?>
                <?php $data = json_decode($data) ?>
                <?php foreach ($data as $key => $value) {
                    if (!empty($value->Useremail)) {
                        $link = '<a href="' . $value->Useremail . '">' . $value->UserfullName . '</a>';
                    } else {
                        $link = $value->UserfullName;
                    }
                    echo '<li id=' . "$value->id" . '>' . '<span>' . $value->time . '</span>' . $link . ', ' . $value->UserbirthDate . 'm.' . '<br />'
                        . $value->Usermessage . '</li>';
                }
                ?>
            <?php endif; ?>
        </li>
    </ul>
    <p id="pages">
        <?php if (!empty ($data)): ?>
            <?php if (sizeof($data) > LISTINPAGE): ?>
                <?php if ($home->getPNumber() > 1): ?>
                    <a href="./?page=<?php echo(($home->getPNumber()) - 1) ?>" title="atgal">atgal</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $home->getPages(); $i++): ?>

                    <a href="?page=<?php echo $i ?>" title="<?php echo $i ?>"><?php echo $i ?></a>

                <?php endfor; ?>
                <?php if ($home->getPages() > 1 && $home->getPNumber() < $home->getPages()): ?>
                    <a href="?page=<?php echo(($home->getPNumber()) + 1) ?>" title="toliau">toliau</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </p>
</div>
</body>
<script language="JavaScript" type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/app.js"></script>
</html>
<footer>&copy; by Aldas Butkus</footer>