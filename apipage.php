<?php

/**
 * Ytscript: İçerik Sihirbazı v2
 *
 * Bu dosya, Ytscript: İçerik Sihirbazı v2 için önemli işlevleri içerir.
 *
 * @package Ytscript: İçerik Sihirbazı v2
 */



// Değeri kaydetmek için
include("api.php");
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.1.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="page">
    <h1 class="baslik" style="font-family: Gabriela, Georgia, serif;">Ytscript: İçerik Sihirbazı</h1>
    <?php
    $foto = plugins_url('ytscriptbot.png', __FILE__);
    ?>

    <!-- tabs -->
    <div class="pcss3t pcss3t-effect-scale pcss3t-theme-1">

        <input type="radio" name="pcss3t" checked id="tab1" class="tab-content-first">
        <label for="tab1"><i class="icon-bolt"></i>Lisans Ayarları</label>
        <input type="radio" name="pcss3t" id="tab2" class="tab-content-last">
        <label for="tab2"><i class="icon-bolt"></i>Api Ayarları</label>
        <ul>
            <li class="tab-content tab-content-first typography">
                <h2>Lisans</h2>
                <?php

                $lisansdurum = get_option("lisansdurum");
                if ($lisansdurum == "Lisansınız aktif değil!" || $lisansdurum == "Lisans aktif değil!") {

                ?>
                    <form class="licform" method="post">
                        <div class="mb-3">
                            <h4 for="veri" class="form-label">Lisans Anahtarı Girin</h4>
                            <p class="form-label" style="margin:0px;padding:0px;">Lütfen Eklendi dosyaları içerisindeki lisans.txt dosyasında yer alan lisansı giriniz.</p>
                            <input type="text" class="form-control col-4" id="veri" name="veri" placeholder="XXXX -XXXX -XXXX -XXXX">
                            <p class="form-label" style="margin:0px;padding:0px;">Lütfen Lisansa Tanımlı Müşteri Adınızı Girin</p>
                            <input type="text" class="form-control col-4" id="clientname" name="clientname" placeholder="Nepoex Yazılım Çözümleri">
                        </div>
                        <button type="submit" class="btn btn-primary" id="guncelleBtn">Güncelle</button>
                        <button type="button" class="btn btn-danger" id="silBtn">Sil</button>
                    </form>
                <?php
                } else {
                    $aktifrenk = "green";
                }

                if (isset($_POST['veri']) && isset($_POST['clientname'])) {
                    $key = $_POST['veri'];
                    $clientName = $_POST['clientname'];
                    update_option('license', $key);
                    update_option('clientname', $clientName);

                    $activateResult = $nepoexAPI->activate_license($key, $clientName);
                    if ($activateResult['status']) {
                        $durum = "Lisans etkinleştirildi, lütfen bekleyin...";
                        update_option("lisansdurum", $durum);

                        //header refresh 3 second
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Form gönderildikten sonra 3 saniye sonra sayfanın yenilenmesi için JavaScript kullan
                            echo '<script>setTimeout(function() { location.reload(); }, 3000);</script>';
                        }
                        $aktifrenk = "green";
                    } else {
                        $durum = "Lisans Durumu: Lisans aktif değil!";
                        update_option("lisansdurum", $durum);
                        $aktifrenk = "";
                    }
                } else {
                }

                ?>
                <div class="licdurum" style="background-color:<?php echo $aktifrenk ?>;">
                    <div>
                        Lisans Durumu:&nbsp;
                    </div>
                    <div>
                        <div class=""><?php echo $lisansdurum = get_option("lisansdurum"); ?></div>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="licform" style="background-color:cadetblue;color:white;">
                        <div class="mb-3">
                            <h4 for="veri" class="form-label" style="color:white;">Lisans detayları</h4>
                            <p class="form-label" style="margin:0px;padding:0px;">Lisans Anahtarı:</p>
                            <input type="text" class="form-control col-4" id="veri" name="veri" disabled placeholder="<?php
                                                                                                                        try {
                                                                                                                            echo $placedeger = substr($key, 0, 6) . str_repeat('X', strlen($key) - 6);
                                                                                                                        } catch (\Throwable $th) {
                                                                                                                            echo "hata";
                                                                                                                        }

                                                                                                                        ?>">
                            <p class="form-label" style="margin:0px;padding:0px;">Müşteri Adı:</p>
                            <input type="text" class="form-control col-4" id="clientname" name="clientname" disabled placeholder="Nepoex Yazılım Çözümleri">
                        </div>
                    </div>
                </div>

            </li>
            <li class="tab-content tab-content-last typography">
                <form>
                    <div class="mb-3">
                        <label for="veri" class="form-label">Veri</label>
                        <input type="text" class="form-control col-4" id="veri" name="veri">
                    </div>
                    <button type="submit" class="btn btn-primary" id="guncelleBtn">Güncelle</button>
                    <button type="button" class="btn btn-danger" id="silBtn">Sil</button>
                </form>
                <p>Şu anki api:</p>
                <p><?php echo substr_replace($openai_api_key, str_repeat('*', max(0, strlen($openai_api_key) - 40)), 5); ?></p>
            </li>
        </ul>
    </div>
    <!--/ tabs -->
</div>
<img id="maskot" style="transform: scaleX(-1);" src="<?php echo $foto; ?>">
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var wpwrapDiv = document.getElementById("wpwrap");
        if (wpwrapDiv) {
            wpwrapDiv.style.background = "#bdcbe5";
        }
    });
</script>