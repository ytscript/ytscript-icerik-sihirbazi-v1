<?php
/*
Plugin Name: Ytscript: İçerik Sihirbazı v2
Plugin URI: https://ytscript.com
Description: İçerik Sihirbazı İçerik Üret eklentisinde kullanmak üzere, seçeceğiniz kategorilerde özgün başlıklar üretmenizi sağlar.
Version: 1.2
Author: ytscript
Author URI: https://ytscript.com
License: GNU
*/

if (!defined('ABSPATH')) die;
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(0);
set_time_limit(180);

include('functions.php');

function ytscript_content_wizard()
{
    add_menu_page(
        'Ytscript: İçerik Sihirbazı', // Menü başlığı
        'Ytscript: İçerik Sihirbazı', // Menü adı
        'manage_options', // Gerekli yetki seviyesi
        'ytscript_content_wizard', // Menu slug
        'ytscript_content_wizard_page', // Sayfa içeriğini göstermek için kullanılan işlev adı
        'dashicons-admin-plugins', // Icon
        99 // Sıra numarası
    );

    add_submenu_page(
        'ytscript_content_wizard',
        'Ayarlar',
        'Ayarlar',
        'manage_options',
        'ayarlar',
        'alt_menu_callback_function' // Alt menü için içerik gösteren işlev adı
    );
}

function ytscript_content_wizard_page()
{
    include('content.php');
}
function alt_menu_callback_function()
{
    // Başka dosyadan içeriği dahil etme
    include 'apipage.php';
}

add_action('admin_menu', 'ytscript_content_wizard');
wp_enqueue_style('style', plugins_url('style.css', __FILE__), '', '1.0');


// Meta kutuyu eklemek için aksiyon ekliyoruz
add_action('add_meta_boxes', 'ytscript_content_generator_meta_box');

function ytscript_content_generator_meta_box()
{
    add_meta_box(
        'ytscript-content-generator',
        'Ytscript Başlık Üretici',
        'ytscript_content_generator_meta_box_callback',
        'post',
        'side',
        'high'
    );
    add_meta_box(
        'ytscript-makale-generator',
        'Ytscript Makale Üretici',
        'ytscript_makale_generator_meta_box_callback',
        'post',
        'side',
        'high'
    );
}


function ytscript_makale_generator_meta_box_callback($post)
{
    // Güvenlik için nonce alanı ekleyin (eğer gerekliyse)
    // wp_nonce_field('ytscript_content_generator_nonce', 'ytscript_content_generator_nonce_field');
?>
    <p>
        <label for="icerik_turu">Başlık:</label><br>
        <input type="text" id="baslik" name="icerik_turu" style="width:100%;" placeholder="Örneğin: Blog Yazısı" />
    </p>
    <p>
        <label for="sektor">Anahtar Kelimeler:</label><br>
        <input type="text" id="anahtar_kelimeler" name="sektor" style="width:100%;" placeholder="Örneğin: Teknoloji" />
    </p>
    <p>
        <label for="dil">Makale Uzunluğu:</label><br>
        <input type="number" id="makale_uzunlugu" name="dil" style="width:100%;" placeholder="Örneğin: Türkçe" />
    </p>
    <p>
        <button type="button" id="generate-article-button" class="button button-primary" onclick="makaleyiChatGPTUzerindenOlustur()">Makale Üret</button>
    </p>
<?php
}


function ytscript_content_generator_meta_box_callback($post)
{
    // Güvenlik için nonce alanı ekleyin (eğer gerekliyse)
    // wp_nonce_field('ytscript_content_generator_nonce', 'ytscript_content_generator_nonce_field');
?>
    <p>
        <label for="icerik_turu">İçerik Türü:</label><br>
        <input type="text" id="icerik_turu" name="icerik_turu" style="width:100%;" placeholder="Örneğin: Blog Yazısı" />
    </p>
    <p>
        <label for="sektor">Sektör:</label><br>
        <input type="text" id="sektor" name="sektor" style="width:100%;" placeholder="Örneğin: Teknoloji" />
    </p>
    <p>
        <label for="dil">Dil:</label><br>
        <input type="text" id="dil" name="dil" style="width:100%;" placeholder="Örneğin: Türkçe" />
    </p>
    <p>
        <label for="baslik_adedi">Başlık Adedi:</label><br>
        <input type="number" id="baslik_adedi" name="baslik_adedi" style="width:100%;" value="1" min="1" />
    </p>
    <p>
        <button type="button" id="generate-title-button" class="button button-primary">Başlık Üret</button>
    </p>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#generate-title-button').click(function() {
                var icerikTuru = $('#icerik_turu').val();
                var sektor = $('#sektor').val();
                var dil = $('#dil').val();
                var baslikAdedi = $('#baslik_adedi').val();
                var apikey = "<?php echo get_option('apideger'); ?>";
                var yeniYazi = "yeniyazi";

                // Form verilerini kontrol edin
                if (icerikTuru === '' || sektor === '' || dil === '' || baslikAdedi === '') {
                    alert('Lütfen tüm alanları doldurun.');
                    return;
                }

                // Butonu devre dışı bırak ve yükleme göstergesi ekle
                $(this).prop('disabled', true).text('Başlık Üretiliyor...');

                // AJAX isteği için verileri hazırlayın
                var data = {
                    icerik_turu: icerikTuru,
                    sektor: sektor,
                    dil: dil,
                    baslik_adedi: baslikAdedi,
                    apikey: apikey,
                    yeniYazi: yeniYazi
                };

                // functions.php dosyasının URL'sini alın
                var functionsPhpUrl = '<?php echo plugins_url('functions.php', __FILE__); ?>';

                $.ajax({
                    url: functionsPhpUrl,
                    type: 'POST',
                    data: data,
                    success: function(response) {

                        console.log('Başlık Üretme Yanıtı:', response);
                        let title = document.getElementById('title');
                        let titleText = document.getElementById('title-prompt-text');
                        title.value = response;
                        titleText.style.display = 'none';

                    },
                    error: function(xhr, status, error) {
                        console.error('Başlık üretilemedi:', error);
                    },
                    complete: function() {
                        // Butonu yeniden etkinleştir ve metnini sıfırla
                        $('#generate-title-button').prop('disabled', false).text('Başlık Üret');
                    }
                });
            });
        });


        // makale üret

        async function makaleyiChatGPTUzerindenOlustur() {
            let baslik = document.getElementById('baslik').value;
            let anahtarkelimeler = document.getElementById('anahtar_kelimeler').value;
            let makaleUzunlugu = document.getElementById('makale_uzunlugu').value;
            let apiKey = '<?php echo get_option('apideger'); ?>';
            const apiURL = 'https://api.openai.com/v1/chat/completions';
            console.log(anahtarkelimeler);

            let prompt = `Please write a high-quality, engaging, and SEO-optimized article of approximately ${makaleUzunlugu} words on the topic "${baslik}". The article should be well-researched and informative, providing valuable information to the reader. It should have a clear structure that includes introduction, body, and conclusion sections. Include the following keywords naturally and strategically into the content, and these keywords should appear in subheadings like H2, H3, H4: ${anahtarkelimeler}. Include an image that contains your Focus Keyword, and add the Focus Keyword as alt text to this image. The keyword density should be appropriate, and the Focus Keyword and its combination should appear at least 3-5 times in the content. Keep links as short as possible; make sure they are not longer than 92 characters. Add DoFollow links to external sources and include internal links within your content. The tone used should be appropriate for the specified tone [specify tone: e.g., professional, friendly, conversational] and target audience [specify target audience: e.g., general readers, industry professionals, students]. Include relevant headings and subheadings to enhance readability and SEO. Ensure all information is accurate, up-to-date, and original (plagiarism-free). Seamlessly incorporate keywords into the content and avoid keyword stuffing. Follow best practices for SEO and content writing. If applicable, include examples, statistics, or quotes to support key points. The article should provide real value to the reader and encourage engagement. Write using only HTML tags for the article structure.`;
            const data = {
                'model': 'gpt-3.5-turbo-16k',
                'messages': [{
                    'role': 'system',
                    'content': prompt
                }]
            };

            const headers = {
                'Authorization': 'Bearer ' + apiKey,
                'Content-Type': 'application/json'
            };

            try {
                const response = await fetch(apiURL, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    const responseData = await response.json();
                    console.log(responseData.choices[0].message.content); // Print the response content to the console
                    tinymce.activeEditor.setContent(responseData.choices[0].message.content);
                    return responseData.choices[0].message.content;
                } else {
                    throw new Error('Makale oluşturma isteği başarısız oldu.');
                }
            } catch (error) {
                throw new Error('Hata oluştu: ' + error);
            }
        }
    </script>
<?php
}
