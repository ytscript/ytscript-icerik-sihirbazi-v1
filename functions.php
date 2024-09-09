<?php

/**
 * Ytscript: İçerik Sihirbazı v2
 *
 * Bu dosya, Ytscript: İçerik Sihirbazı v2 için önemli işlevleri içerir.
 *
 * @package Ytscript: İçerik Sihirbazı v2
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_POST['icerik_turu']) && isset($_POST['sektor']) && isset($_POST['baslik_adedi']) && isset($_POST['apikey'])) {
    echo '<div class="wrap">';
    echo '<h2>Oluşturulan başlıklar:</h2>';
    $icerik_turu = $_POST['icerik_turu'];
    $sektor = $_POST['sektor'];
    $baslik_adedi = intval($_POST['baslik_adedi']);
    $dil = $_POST['dil'];
    $openai_api_key = $_POST['apikey'];
    $basliklar = array();
    $unique_titles = array();
    $metin = "Content Type: $icerik_turu, Sector: $sektor, Title $baslik_adedi";
    $olusturulan_baslik = openai_metin_ile_baslik_olustur($metin, $openai_api_key, $icerik_turu, $sektor, $dil, $baslik_adedi);
    $olusturulan_baslik = str_replace('"', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace(':', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('!', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('.', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('Tıkla', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('Tıklayın', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('İncele', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('İnceleyin', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('Oku', '', $olusturulan_baslik);
    $olusturulan_baslik = str_replace('Okuyun', '', $olusturulan_baslik);
    $unique_title = ucfirst($olusturulan_baslik);
    if (!in_array($unique_title, $unique_titles)) {
        $unique_titles[] = $unique_title;
        $basliklar[] = $unique_title;
    }
    echo '</div>';
    $string = $basliklar[0];
    $rows = explode("\n", $string);
    foreach ($rows as $row) {
        $parts = explode(
            " ",
            $row,
            2
        );
        $number = $parts[0];
        $title = $parts[1];

?>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input onblur="CheckBoxUpdate()" type="checkbox" id="<?php echo $number; ?>check" class="baslik-checkbox form-control" aria-label="Checkbox for following text input">
                </div>
            </div>
            <input type="text" id="<?php echo $number; ?>text" class=" form-control col-8" value="<?php echo $title ?>">
        </div>
    <?php
        $titles[] = $title;
    }

    ?>

    <button type="button" onblur="CheckBoxUpdate()" class="btn btn-info col-4" id="selectAllButton">Tümünü Seç</button>
    <button type="button" onclick="CheckBoxClear()" class="btn btn-danger col-4" id="clearAllCheck">Temizle</button>

    <hr>
    <button type="button" class="btn btn-primary btn-lg btn-block pulsating-button" id="makaleleriUretButton">Seçilen Başlıklarla Makaleler Üret</button>


<?php
}
}
else{
}
function openai_metin_ile_baslik_olustur($metin, $api_key, $icerik_turu, $sektor, $dil, $baslik_adedi)
{
    $api_url = 'https://api.openai.com/v1/chat/completions';
    $headers = array(
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json',
    );
    $data = array(
        'model' => 'gpt-3.5-turbo-16k',
        'messages' => array(
            array(
                'role' => 'system',
                'content' => 'Generate exactly "' . $baslik_adedi . '" titles related to the subject of "' . $sektor . '" and in line with the content type of "' . $icerik_turu . '". Titles should be written in the "' . $dil . '" language. Titles should be creative. Avoid using scientific terms. Generate titles suitable for blog content. The number of headings should be 1. Do not reuse the same or similar headlines. Titles must be unique.',
            ),
            array(
                'role' => 'user',
                'content' => $metin,
            ),
        ),
    );
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_data = json_decode($response, true);
    $olusturulan_baslik = $response_data['choices'][0]['message']['content'];
    return $olusturulan_baslik;
}

function seo_uygun_makale_olustur($basliklar, $anahtar_kelimeler, $api_key, $icerik_turu, $sektor, $dil, $makale_uzunlugu)
{
    $api_url = 'https://api.openai.com/v1/chat/completions';
    $headers = array(
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json',
    );

    $makaleler = array();

    foreach ($basliklar as $baslik) {
        foreach ($anahtar_kelimeler as $anahtar_kelime) {
            $data = array(
                'model' => 'gpt-3.5-turbo-16k',
                'messages' => array(
                    array(
                        'role' => 'system',
                        'content' => 'Generate a ' . $makale_uzunlugu . ' word article on the topic of "' . $baslik . '" in the "' . $dil . '" language. The article should be SEO-friendly and related to the "' . $sektor . '" sector.',
                    ),
                    array(
                        'role' => 'user',
                        'content' => $anahtar_kelime,
                    ),
                ),
            );

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            curl_close($ch);

            $response_data = json_decode($response, true);
            $makale = $response_data['choices'][0]['message']['content'];

            $makaleler[] = $makale;
        }
    }

    return $makaleler;
}
