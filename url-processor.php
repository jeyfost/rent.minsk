<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 23.08.2018
 * Time: 12:02
 */

include("scripts/connect.php");

$url = substr($_SERVER['REQUEST_URI'], 1);
$url = explode("/", $url);

/*
 * $url[0] — тип услуг (автомобили или квартиры)
 * $url[1] — конкретный автомобиль или квартира
 */

if($url[0] != "cars" and $url[0] != "apartments") {
    header("Location: /");
}

if($url[0] == "cars") {
    if(!empty($url[1])) {
        $pageCheckResult = $mysqli->query("SELECT COUNT(id) FROM rent_cars WHERE url = '".$mysqli->real_escape_string($url[1])."'");
        $pageCheck = $pageCheckResult->fetch_array(MYSQLI_NUM);

        if($pageCheck[0] == 0) {
            header("Location: /cars");
        }
    }
}

if(!empty($url[1])) {
    $type = "good";
} else {
    $type = "category";
}

$pageResult = $mysqli->query("SELECT * FROM rent_pages WHERE url = '".$url[0]."'");
$page = $pageResult->fetch_assoc();

?>

<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->

<html lang="ru">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />

    <title><?= $page['title'] ?></title>

    <meta name="description" content="<?= $page['description'] ?>" />
    <meta name="keywords" content="<?= $page['keywords'] ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="image/png" href="/img/system/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/img/system/favicon-16x16.png" sizes="16x16" />

    <link href="https://fonts.googleapis.com/css?family=Istok+Web|Montserrat" rel="stylesheet">

    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/libs/strip/dist/css/strip.css" />
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/media.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/libs/strip/dist/js/strip.pkgd.min.js"></script>
    <script src="/js/common.js"></script>

    <style>
        #page-preloader {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background: #fff; z-index: 100500;}
        #page-preloader .spinner {width: 160px; height: 20px; position: absolute; left: 50%; top: 40%; background: url('/img/system/spinner.gif') no-repeat 50% 50%; margin: 0 0 0 -80px;}
    </style>

    <script type="text/javascript">
        $(window).on('load', function () {
            const $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
            $spinner.delay(500).fadeOut();
            $preloader.delay(850).fadeOut();
        });
    </script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter51057086 = new Ya.Metrika2({
                        id:51057086,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/tag.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks2");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/51057086" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- Google Analytics counter --><!-- /Google Analytics counter -->
</head>

<body>
    <div id="page-preloader"><span class="spinner"></span></div>

    <div class="mobileMenu">
        <div class="row" id="mobileMenuClose"><i class="fa fa-times" aria-hidden="true" onclick="closeMobileMenu()"></i></div>
        <a href="/"><div class="row text-center mobile">Главная</div></a>
        <div class="row text-center mobile <?php if($url[0] == "cars") {echo "mobileActive";} ?>"><a href="/cars">Автомобили</a></div>
        <div class="row text-center mobile"><a href="/rent">Сдать авто</a></div>
        <div class="row text-center mobile"><a href="/reviews">Отзывы</a></div>
        <div class="row text-center mobile"><a href="/contacts">Контакты</a></div>
    </div>

    <div class="menuInner transition">
        <div class="menuContainer">
            <div class="logo">
                <a href="/"><img src="/img/system/logo_orange.png" /></a>
            </div>
            <div class="menuContent">
                <div class="menuPoints">
                    <a href="/">
                        <div class="menuPoint" style="margin-left: 15px;" onmouseover="pointInnerHover('mainLine', 'mainPointName', 1)" onmouseout="pointInnerHover('mainLine', 'mainPointName', 0)">
                            <div class="menuTopLine transition" id="mainLine"></div>
                            <div class="menuPointNameInner" id="mainPointName">Главная</div>
                        </div>
                    </a>
                    <a href="/cars">
                        <div class="menuPoint" <?php if($url[0] != "cars") {echo "onmouseover='pointInnerHover(\"carsLine\", \"carsPointName\", 1)' onmouseout='pointInnerHover(\"carsLine\", \"carsPointName\", 0)'";} ?>>
                            <div class="menuTopLine transition <?php if($url[0] == "cars") {echo "menuTopLineActive";} ?>" id="carsLine"></div>
                            <div class="menuPointNameInner transition <?php if($url[0] == "cars") {echo "menuPointActive";} ?>" id="carsPointName">Автомобили</div>
                        </div>
                    </a>
                    <a href="/rent">
                        <div class="menuPoint" onmouseover="pointInnerHover('rentLine', 'rentPointName', 1)" onmouseout="pointInnerHover('rentLine', 'rentPointName', 0)">
                            <div class="menuTopLine transition" id="rentLine"></div>
                            <div class="menuPointName transition" id="rentPointName">Сдать авто</div>
                        </div>
                    </a>
                    <a href="/reviews">
                        <div class="menuPoint" onmouseover="pointInnerHover('reviewsLine', 'reviewsPointName', 1)" onmouseout="pointInnerHover('reviewsLine', 'reviewsPointName', 0)">
                            <div class="menuTopLine transition" id="reviewsLine"></div>
                            <div class="menuPointNameInner transition" id="reviewsPointName">Отзывы</div>
                        </div>
                    </a>
                    <a href="/contacts">
                        <div class="menuPoint" onmouseover="pointInnerHover('contactsLine', 'contactsPointName', 1)" onmouseout="pointInnerHover('contactsLine', 'contactsPointName', 0)">
                            <div class="menuTopLine transition" id="contactsLine"></div>
                            <div class="menuPointNameInner transition" id="contactsPointName">Контакты</div>
                        </div>
                    </a>
                    <div class="clear"></div>
                </div>
                <div class="menuSeparator"></div>
                <div class="menuPhoneInner">
                    <a class="transition" href="tel: <?= COUNTRY_CODE.PHONE_CODE.str_replace('-', '', PHONE_NUMBER) ?>"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<span><?= COUNTRY_CODE ?> (<?= PHONE_CODE ?>) <b><?= PHONE_NUMBER ?></b></span></a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="mobileMenuIcon" onclick="showMobileMenu()"><i class="fa fa-bars" aria-hidden="true"></i></div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="ndra-container">
        <div class="section grey text-center">
            <?php
                switch($type) {
                    case "category":
                        if($url[0] == "cars") {
                            $textResult = $mysqli->query("SELECT * FROM rent_text WHERE name = 'cars'");
                            $text = $textResult->fetch_assoc();

                            echo "
                                <div class='wide text-left breadcrumbs'>
                                    <a href='/' class='transition'><i class='fa fa-home' aria-hidden='true'></i> Главная</a> / Автомобили
                                </div>
                                <br /><br />
                                <span class='headerFont'>Легковые автомобили</span>
                                <br /><br />
                            ";

                            $carResult = $mysqli->query("SELECT * FROM rent_cars WHERE car_type = '1'");
                            while($car = $carResult->fetch_assoc()) {
                                echo "
                                    <div class='tab'>
                                        <span class='tabName'>".$car['name']."</span>
                                        <br />
                                        <a href='/img/cars/big/".$car['photo']."' class='strip' data-strip-caption='".$car['name']."'><img src='/img/cars/small/".$car['preview']."' class='transition' /></a>
                                        <br /><br />
                                        <div class='text-left'>
                                            <b>Год выпуска:</b>&nbsp;".$car['year']."
                                            <br />
                                            <b>Тип двигателя:</b>&nbsp;".$car['engine']."
                                            <br />
                                            <b>Тип трансмиссии:</b>&nbsp;".$car['transmission']."
                                            <br />
                                            <b>Расход:</b>&nbsp;".$car['consumption']."
                                            <br />
                                            <b>Тип кузова:</b>&nbsp;".$car['body']."
                                            <br /><br />
                                            <b>Цена за 1 час, руб:</b>&nbsp;".$car['1_hour']."
                                            <br />
                                            <span>* Минимальный срок аренды: ".$car['min_term']."</span>
                                            <br /><br />
                                            <table>
                                                <thead class='bold td-grey'>
                                                    <tr>
                                                        <td>Срок аренды</td>
                                                        <td>Цена за сутки, руб. (пробег до 300 км)</td>
                                                        <td>Цена за сутки, руб. (пробег до 500 км)</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class='bold td-grey'>1 сутки</td>
                                                        <td>".$car['1_day']."</td>
                                                        <td>".$car['max_1_day']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>2 сутки</td>
                                                        <td>".$car['2_days']."</td>
                                                        <td>".$car['max_2_days']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>3-10 суток</td>
                                                        <td>".$car['3_10_days']."</td>
                                                        <td>".$car['max_3_10_days']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>10-20 суток</td>
                                                        <td>".$car['10_20_days']."</td>
                                                        <td>".$car['max_10_20_days']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>20-30 суток</td>
                                                        <td>".$car['20_30_days']."</td>
                                                        <td>".$car['max_20_30_days']."</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br /><br />
                                        <a href='/cars/".$car['url']."'><div class='promoButton transition'>Подробнее <i class='fa fa-angle-double-right' aria-hidden='true'></i></div></a>
                                    </div>
                                ";
                            }

                            $busCountResult = $mysqli->query("SELECT COUNT(id) FROM rent_cars WHERE car_type = '2'");
                            $busCount = $busCountResult->fetch_array(MYSQLI_NUM);

                            if($busCount[0] > 0) {
                                echo "
                                    <br /><br /><br /><br />
                                    <span class='headerFont'>Микроавтобусы</span>
                                    <br /><br />
                                ";

                                $carResult = $mysqli->query("SELECT * FROM rent_cars WHERE car_type = '2'");
                                while($car = $carResult->fetch_assoc()) {
                                    echo "
                                        <div class='tab'>
                                            <span class='tabName'>".$car['name']."</span>
                                            <br />
                                            <a href='/img/cars/big/".$car['photo']."' class='strip' data-strip-caption='".$car['name']."'><img src='/img/cars/small/".$car['preview']."' class='transition' /></a>
                                            <br /><br />
                                            <div class='text-left'>
                                                <b>Год выпуска:</b>&nbsp;".$car['year']."
                                                <br />
                                                <b>Тип двигателя:</b>&nbsp;".$car['engine']."
                                                <br />
                                                <b>Тип трансмиссии:</b>&nbsp;".$car['transmission']."
                                                <br />
                                                <b>Расход:</b>&nbsp;".$car['consumption']."
                                                <br />
                                                <b>Тип кузова:</b>&nbsp;".$car['body']."
                                                <br /><br />
                                                <b>Цена за 1 час, руб:</b>&nbsp;".$car['1_hour']."
                                                <br />
                                                <span>* Минимальный срок аренды: ".$car['min_term']."</span>
                                                <br /><br />
                                                <table>
                                                <thead class='bold td-grey'>
                                                    <tr>
                                                        <td>Срок аренды</td>
                                                        <td>Цена за сутки, руб. (пробег до 300 км)</td>
                                                        <td>Цена за сутки, руб. (пробег до 500 км)</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class='bold td-grey'>1 сутки</td>
                                                        <td>".$car['1_day']."</td>
                                                        <td>".$car['max_1_day']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>2 сутки</td>
                                                        <td>".$car['2_days']."</td>
                                                        <td>".$car['max_2_days']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>3-10 суток</td>
                                                        <td>".$car['3_10_days']."</td>
                                                        <td>".$car['max_3_10_days']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>10-20 суток</td>
                                                        <td>".$car['10_20_days']."</td>
                                                        <td>".$car['max_10_20_days']."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='bold td-grey'>20-30 суток</td>
                                                        <td>".$car['20_30_days']."</td>
                                                        <td>".$car['max_20_30_days']."</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                            <br /><br />
                                            <a href='/cars/".$car['url']."'><div class='promoButton transition'>Подробнее <i class='fa fa-angle-double-right' aria-hidden='true'></i></div></a>
                                        </div>
                                    ";
                                }

                                echo "
                                    <br /><br /><br /><br />
                                    <div class='section'>
                                        <div class='wide text-left custom'>".$text['text']."</div>
                                    </div>
                                ";
                            }
                        }
                        break;
                    case "good":
                        if($url[0] == "cars") {
                            $carResult = $mysqli->query("SELECT * FROM rent_cars WHERE url = '".$mysqli->real_escape_string($url[1])."'");
                            $car = $carResult->fetch_assoc();

                            echo "
                                <div class='wide text-left breadcrumbs'>
                                    <a href='/' class='transition'><i class='fa fa-home' aria-hidden='true'></i> Главная</a> / <a href='/cars' class='transition'>Автомобили</a> / ".$car['name']."
                                </div>
                                <br /><br />
                                <span class='headerFont'>".$car['name']."</span>
                                <br /><br />
                                <div class='wide text-center'>
                                    <img src='/img/cars/big/".$car['photo']."' class='mainPhoto' />
                                </div>
                                <div class='wide text-center'>
                                    <div class='photoPreview'>
                                        <a href='/img/cars/big/".$car['photo']."' class='strip' data-strip-group='apartment'><img src='/img/cars/small/".$car['preview']."' /></a>
                                    </div>
                            ";

                            $photoResult = $mysqli->query("SELECT * FROM rent_cars_photos WHERE car_id = '".$car['id']."'");
                            while($photo = $photoResult->fetch_assoc()) {
                                echo "
                                    <div class='photoPreview'>
                                        <a href='/img/cars/big/".$photo['photo']."' class='strip' data-strip-group='apartment'><img src='/img/cars/small/".$photo['preview']."' class='transition' /></a>
                                    </div>
                                ";
                            }

                            echo "
                                </div>
                                <br /><br />
                                <div class='wide text-center custom carsDescription'>
                                    <b><i class='fa fa-calendar' aria-hidden='true'></i> Год выпуска:</b>&nbsp;".$car['year']."
                                    <br />
                                    <b><i class='fa fa-rocket' aria-hidden='true'></i> Тип двигателя:</b>&nbsp;".$car['engine']."
                                    <br />
                                    <b><i class='fa fa-cogs' aria-hidden='true'></i> Тип трансмиссии:</b>&nbsp;".$car['transmission']."
                                    <br />
                                    <b><i class='fa fa-fire' aria-hidden='true'></i> Расход:</b>&nbsp;".$car['consumption']."
                                    <br />
                                    <b><i class='fa fa-car' aria-hidden='true'></i> Тип кузова:</b>&nbsp;".$car['body']."
                            ";

                            if($car['car_type'] == 2) {
                                echo "
                                    <br />
                                    <b><i class='fa fa-users' aria-hidden='true'></i> Количество мест:</b>&nbsp;".$car['places']."
                                ";
                            }

                            echo "
                                    <br /><br />
                                    <b><i class='fa fa-money' aria-hidden='true'></i> Цена за 1 час, руб:</b>&nbsp;".$car['1_hour']."
                                    <br />
                                    <span>* Минимальный срок аренды: ".$car['min_term']."</span>
                                    <br /><br />
                                    <table>
                                        <thead class='bold td-grey'>
                                            <tr>
                                                <td>Срок</td>
                                                <td>Цена с учётом пробега до 300 км/сутки, руб</td>
                                                <td>Цена с учётом пробега до 500 км/сутки, руб</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class='bold td-grey'>1 сутки</td>
                                                <td>".$car['1_day']."</td>
                                                <td>".$car['max_1_day']."</td>
                                            </tr>
                                            <tr>
                                                <td class='bold td-grey'>2 суток</td>
                                                <td>".$car['2_days']."</td>
                                                <td>".$car['max_2_days']."</td>
                                            </tr>
                                            <tr>
                                                <td class='bold td-grey'>3-10 суток</td>
                                                <td>".$car['3_10_days']."</td>
                                                <td>".$car['max_3_10_days']."</td>
                                            </tr>
                                            <tr>
                                                <td class='bold td-grey'>10-20 суток</td>
                                                <td>".$car['10_20_days']."</td>
                                                <td>".$car['max_10_20_days']."</td>
                                            </tr>
                                            <tr>
                                                <td class='bold td-grey'>20-30 суток</td>
                                                <td>".$car['20_30_days']."</td>
                                                <td>".$car['max_20_30_days']."</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br /><br />
                            ";

                            if($car['car_type'] == 2) {
                                echo "<div class='text-left' style='color: #333; font-family: \"Istok Web\", sans-serif; font-size: 16px;'>".$car['description']."</div><br /><br />";
                            }

                            echo "
                                    <a href='/cars'><div class='promoButton transition'><i class='fa fa-angle-double-left' aria-hidden='true'></i> Назад к списку автомобилей</div></a>
                                </div>
                            ";
                        }
                        break;
                    default:
                        break;
                }
            ?>
        </div>
    </div>

    <div class="section" id="footer" style="padding: 0;">
        <br /><br />
        <div class="wide">
            <div class="footerLogo"><a href="/"><img src="/img/system/logo.png" /></a></div>
            <div class="footerContacts">
                <div class="footerContactsContainer">
                    <a class="transition" href="tel: <?= COUNTRY_CODE.PHONE_CODE.str_replace('-', '', PHONE_NUMBER) ?>"><i class="fa fa-mobile" aria-hidden="true"></i>&nbsp;<?= COUNTRY_CODE." (".PHONE_CODE.") ".PHONE_NUMBER ?></a>
                </div>
                <div class="footerContactsContainer">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<?= COMPANY_ADDRESS ?>
                    <br />
                    <a class="transition" href="mailto: <?= CONTACT_EMAIL ?>"><i class="fa fa-at" aria-hidden="true"></i>&nbsp;<?= CONTACT_EMAIL ?>&nbsp;</a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <br />
        </div>
        <div class="line"></div>
        <div class="wide">
            <br />
            <div class="footerLeft" style="float: left;">Аренда &laquo;У ПАЛЫЧА&raquo; &copy; 2014 - <?= date('Y') ?></div>
            <div class="footerRight" style="float: right;">Создание сайта: <a href="https://airlab.by/" style="color: #cfcfcf;"><span class="maker transition">airlab</span></a></div>
            <div class="clear"></div>
            <br /><br />
        </div>
    </div>
</body>

</html>