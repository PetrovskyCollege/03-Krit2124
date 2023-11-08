<?php
session_start();
include_once 'DB/db.php';
$db = new DB("bestiary", "localhost");
$connect = $db->connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бестиарий</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="headerUpperString">
                <h1>Бестиарий</h1>
                <div class="headerButtons">
                    <div>
                        <button class="headerButton" id="accountButton"><img src="/img/user.png" alt="Аккаунт"></button>
                        
                        <div class="dropDownContainer userBox">
                            <? 
                                if (isset($_SESSION['userName'])) {
                                    echo "Вы вошли как: ".$_SESSION['userName'];
                            ?>

                            <form action="index.php" method="POST">
                                <button type="submit" class="userFormButton userFormMainButton" id="logoutSubmitButton" name="logoutButton">Выйти</button>
                            </form>

                            <?
                                } else {
                            ?>

                            <form action="index.php" method="POST" class="loginForm">
                                <h2>Авторизация</h2>
                                <input type="text" name="loginOrEmailToLogin" placeholder="Логин или Email">
                                <input type="password" name="passToLogin" placeholder="Пароль">
                                <div class="userFormButtons">
                                    <button type="submit" class="userFormButton userFormMainButton" id="loginSubmitButton" name="logButton">Войти</button>
                                    <input type="button" class="userFormButton userFormSecondaryButton" id="regButton" value="Регистрация">
                                </div>
                            </form>

                            <form action="index.php" method="POST" class="regForm">
                                <h2>Регистрация</h2>
                                <input type="text" name="loginToReg" placeholder="Логин">
                                <input type="email" name="emailToReg" placeholder="Email">
                                <input type="password" name="passToReg" placeholder="Пароль">
                                <input type="password" name="passRepeatedToReg" placeholder="Повторите пароль">
                                <div class="userFormButtons">
                                    <button type="submit" class="userFormButton userFormMainButton" id="regSubmitButton" name="regButton">Зарегистрироваться</button>
                                    <input type="button" class="userFormButton userFormSecondaryButton" id="loginButton" value="Вход">
                                </div>
                            </form>

                            <?
                                }
                            ?>
                        </div>
                        
                    </div>
                    <button class="headerButton"><img src="/img/plus.png" alt="Добавить НИПа"></button>
                    <button class="headerButton"><img src="/img/chest.png" alt="Список добавленных НИПов"></button>
                    <button class="headerButton"><img src="/img/emptyHeart.png" alt="Список избранного (пустой)" class="emptyFavList"><img src="/img/filledHeart.png" alt="Список избранного" class="filledFavList"></button>
                </div>
            </div>
            
            <div class="headerFilters">
                <div class="mainFilters">
                    <button id="openOrCloseFilters" class="buttonWithArrowDown openOrCloseFilters">
                        <img src="img/funnel.png" alt="Вывести/скрыть остальные фильтры">
                    </button>
                    <input id="nameInput" type="text" placeholder="Название" class="inputWithLoupe">
                    <button id="usersNPCInput" class="checkBoxInputGreen">Пользовательские НИПы</button>
                </div>

                <div class="dropDownContainer filtersContainer additionalFilters">
                    <button id="dangerLevelInput" class="buttonWithArrowDown">Уровень опасности</button>
                    <div>
                        <button id="worldviewInput" class="buttonWithArrowDown">Мировоззрение</button>
                        <div class="dropDownContainer filtersContainer worldviewVariations">
                            <button id="lawfulGood" class="usualButton">ЗД</button>
                            <button id="neutralGood" class="usualButton">НД</button>
                            <button id="chaoticGood" class="usualButton">ХД</button>

                            <button id="lawfulNeutral" class="usualButton">ЗН</button>
                            <button id="neutral" class="usualButton">НН</button>
                            <button id="chaoticNeutral" class="usualButton">ХН</button>

                            <button id="lawfulEvil" class="usualButton">ЗЗ</button>
                            <button id="neutralEvil" class="usualButton">НЗ</button>
                            <button id="chaoticEvil" class="usualButton">ХЗ</button>

                            <button id="noWorldview" class="usualButton">Без мировоззрения</button>
                        </div>
                    </div>
                    <button id="speciesInput" class="buttonWithArrowDown">Вид</button>
                    <button id="subspeciesInput" class="buttonWithArrowDown">Подвид</button>
                    <button id="NPCWithoutImageInput" class="checkBoxInputGreen">НИПы без изображения</button>
                    <button id="habitatInput" class="buttonWithArrowDown">Места обитания</button>
                    <button id="languageInput" class="buttonWithArrowDown">Языки</button>
                    <button id="sizeInput" class="buttonWithArrowDown">Размер</button>
                    <button id="speedTypeInput" class="buttonWithArrowDown">Способы перемещения</button>
                    <button id="damageVulnerabilityInput" class="buttonWithArrowDown">Уязвимость к урону</button>
                    <button id="damageResistanceInput" class="buttonWithArrowDown">Сопротивление к урону</button>
                    <button id="damageImmunityInput" class="buttonWithArrowDown">Иммунитет к урону</button>
                    <button id="senseInput" class="buttonWithArrowDown">Чувства</button>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section>
            
        </section>
    </main>

    <script src="/js/script.js"></script>
</body>
</html>

<?php

if (isset($_POST["logButton"])) {
    if (empty($_POST["loginOrEmailToLogin"]) || empty($_POST["passToLogin"])) {
        echo '<div role="alert"> Error: введите логин и пароль</div>';

    } else {
        $row = $connect->query("SELECT * FROM `user` WHERE (`login` = '{$_POST["loginOrEmailToLogin"]}' OR `email` = '{$_POST["loginOrEmailToLogin"]}') AND `password` = '{$_POST["passToLogin"]}'");
        $user = $row->fetch();
        if (empty($user)) {
            echo '<div role="alert"> Error: логин или пароль введены неверно</div>';
        } else {
            $_SESSION['userName'] = $user["login"];
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}

if (isset($_POST["regButton"])) {
    if (empty($_POST["loginToReg"]) || empty($_POST["passToReg"])) {
        echo '<div role="alert"> Error: введите логин и пароль</div>';
    } else {
        if ($_POST["passToReg"] == $_POST["passRepeatedToReg"]) {
            $sql = $connect->query("INSERT INTO `user` (`id`, `login`, `email`, `password`, `created_at`, `id_access_type`) 
            VALUES (NULL, '{$_POST["loginToReg"]}', '{$_POST["emailToReg"]}', '{$_POST["passToReg"]}', CURDATE(), '2')");

            if ($sql) {
                $_SESSION['userName'] = $_POST["loginToReg"];
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo '<div role="alert"> Error: Произошла ошибка при регистрации</div>';
            }
        } else {
            echo '<div role="alert"> Error: Пароли должны совпадать</div>';
        }
    }
}

if (isset($_POST["logoutButton"])) {
    unset($_SESSION['userName']);
    echo "<meta http-equiv='refresh' content='0'>";
}

?>