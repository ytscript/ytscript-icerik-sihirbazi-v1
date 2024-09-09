<?php

/**
 * Ytscript: İçerik Sihirbazı v2
 *
 * Bu dosya, Ytscript: İçerik Sihirbazı v2 için önemli işlevleri içerir.
 *
 * @package Ytscript: İçerik Sihirbazı v2
 */


$lisansdurum = get_option("lisansdurum");
if ($lisansdurum == "Lisansınız aktif değil!" || $lisansdurum == "Lisans aktif değil!") {
    include("apipage.php");
    exit;
} else {
    include("api.php");
}
$openai_api_key = get_option('apideger');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css'>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>

</style>
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
        <label for="tab1"><i class="icon-bolt"></i>Başlık Üret</label>

        <input type="radio" name="pcss3t" id="tab2" class="tab-content-2">
        <label id="basliktanuret" for="tab2"><i class="icon-picture"></i>Başlıklardan Makale Üret</label>

        <input type="radio" name="pcss3t" id="tab3" class="tab-content-3">
        <label for="tab3"><i class="icon-picture"></i>Makale Üret</label>

        <input type="radio" name="pcss3t" id="tab4" class="tab-content-4">
        <label for="tab4"><i class="icon-cogs"></i>Düzenleme yap</label>

        <input type="radio" name="pcss3t" id="tab5" class="tab-content-last">
        <label for="tab5"><i class="icon-globe"></i>Paylaş</label>

        <ul>
            <li class="tab-content tab-content-first typography" id="tab-content">
                <div class="wrap2">
                    <h2>Başlık Oluştur</h2>
                    <div class="">Bu eklenti aracını kullanarak İçerik Sihirbazı İçerik Üret eklentisi için analize
                        dayalı, dikkat çekici, harika başlıklar oluşturabilirsiniz.</div>
                    <div class="form">
                        <form method="post" id="baslikuretform">
                            <div class="alan">
                                <div class="label2" for="dil">
                                    <b>Dil:</b><br>
                                    <select class="select-box2" name="dil" id="dil">
                                        <option value="Turkish" selected>Türkçe</option>
                                        <option value="Armenian">Armenian</option>
                                        <option value="Arabic">Arabic</option>
                                        <option value="Bulgarian">Bulgarian</option>
                                        <option value="Chinese">Chinese</option>
                                        <option value="English">English</option>
                                        <option value="French">French</option>
                                        <option value="German">German</option>
                                        <option value="Italian">Italian</option>
                                        <option value="Japanese">Japanese</option>
                                        <option value="Persian">Persian</option>
                                        <option value="Portuguese">Portuguese</option>
                                        <option value="Romanian">Romanian</option>
                                        <option value="Russian">Russian</option>
                                        <option value="Spanish">Spanish</option>
                                        <option value="Uzbekistan">Uzbek</option>
                                        <option value="Turkmenistan">Turkmen</option>
                                    </select>
                                    <div class="info-message">Üretilecek başlıkların dilini bu alandan seçebilirsiniz.
                                    </div>
                                </div>
                                <div class="label2" for="icerik_turu">
                                    <b>İçerik Türü:</b><br>
                                    <input class="form-control col-8" type="text" name="icerik_turu" id="icerik_turu" required>
                                    <div class="info-message">Blog içeriği, kurumsal blog, tanıtım, biyografi veya
                                        ne/nedir içerik türlerinden birini giriniz.</div>
                                </div>
                            </div>
                            <div class="alan">
                                <div class="label2" for="sektor"><b>Konu:</b><br>
                                    <input class="form-control col-8" type="text" name="sektor" id="sektor" required>
                                    <div class="info-message">Bir konu yazınız. Örneğin; "Psikolojik rahatsızlıklar ve
                                        nedenleri."</div>
                                </div>
                                <div class="label2" for="baslik_adedi"><b>Başlık Sayısı:</b><br>
                                    <input class="form-control col-8" type="number" name="baslik_adedi" id="baslik_adedi" min="1" value="10">
                                    <div class="info-message">Başlık sayısı seçiniz. Bazen daha az veya daha fazla
                                        başlık üretebilir.</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top:10px;margin-bottom:10px;gap:10px;align-items:center;justify-content:baseline;">
                                <div>
                                    <input class="btn btn-primary" name="baslikuret" id="baslikUretBtn" type="submit" value="Başlık Üret ✎">
                                </div>
                                <div style="color:black; font-style: italic; font-family:'Courier New', Courier, monospace;">
                                    <p id="islemler"></p>
                                </div>
                            </div>
                        </form>
                        <div id="generatedTitles">

                        </div>
                    </div>
                </div>
            </li>
            <li class="tab-content tab-content-2 typography" id="tab-content">
                <div class="basliklar">
                    <div class="wrap2">
                        <h2>Başlıklardan Makale Oluştur</h2>
                        <div style="font-size:medium; font-width:bold;"></div>
                        <div class="form">
                            <form method="post">
                                <div class="alan">
                                    <div class="label2" for="dil">
                                        <b>Seçilen Başlıklar:</b><br>
                                        <ul id="secilenbasliks">
                                        </ul>
                                    </div>
                                    <div class=""><span style="color:red;">Dikkat!</span> Seçtiğiniz Her Başlık için ayrı ayrı makale oluşturulacak.</div>
                                    <br>
                                </div>
                                <div class="alan">
                                    <input class="btn btn-primary" name="makaleleriuret" type="button" onclick="makaleleriUret()" value="Makaleleri Üret ✎">
                                </div>
                            </form>
                            <div class="alan">
                                <div class="makaleler">
                                    <div class="newPost">
                                        <h3 id="editorMakaleSayi"></h3>
                                        <input type="text" id="editorMakaleBaslk" placeholder="Enter title here">
                                        <div class="toolbar">
                                            <button type="button" data-func="bold"><i class="fa fa-bold"></i></button>
                                            <button type="button" data-func="italic"><i class="fa fa-italic"></i></button>
                                            <button type="button" data-func="underline"><i class="fa fa-underline"></i></button>
                                            <button type="button" data-func="justifyleft"><i class="fa fa-align-left"></i></button>
                                            <button type="button" data-func="justifycenter"><i class="fa fa-align-center"></i></button>
                                            <button type="button" data-func="justifyright"><i class="fa fa-align-right"></i></button>
                                            <button type="button" data-func="insertunorderedlist"><i class="fa fa-list-ul"></i></button>
                                            <button type="button" data-func="insertorderedlist"><i class="fa fa-list-ol"></i></button>
                                            <div class="customSelect">
                                                <select data-func="fontname">
                                                    <optgroup label="Serif Fonts">
                                                        <option value="Bree Serif">Bree Serif</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Palatino Linotype">Palatino Linotype</option>
                                                        <option value="Times New Roman">Times New Roman</option>
                                                    </optgroup>
                                                    <optgroup label="Sans Serif Fonts">
                                                        <option value="Arial">Arial</option>
                                                        <option value="Arial Black">Arial Black</option>
                                                        <option value="Asap" selected>Asap</option>
                                                        <option value="Comic Sans MS">Comic Sans MS</option>
                                                        <option value="Impact">Impact</option>
                                                        <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                                        <option value="Tahoma">Tahoma</option>
                                                        <option value="Trebuchet MS">Trebuchet MS</option>
                                                        <option value="Verdana">Verdana</option>
                                                    </optgroup>
                                                    <optgroup label="Monospace Fonts">
                                                        <option value="Courier New">Courier New</option>
                                                        <option value="Lucida Console">Lucida Console</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="customSelect">
                                                <select data-func="formatblock">
                                                    <option value="h1">Heading 1</option>
                                                    <option value="h2">Heading 2</option>
                                                    <option value="h4">Subtitle</option>
                                                    <option value="p" selected>Paragraph</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="editor" id="editoralani" contenteditable></div>
                                        <div class="buttons">
                                            <!--<button type="button">save draft</button>-->
                                            <button data-func="clear" type="button">clear</button>
                                            <button data-func="save" type="button">save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li id="tab-content" class="tab-content tab-content-3 typography">
                <div class="wrap2">
                    <h2>Makale Oluştur</h2>
                    <div style="font-size:medium; font-width:bold;">Bu alanı kullanabilmek için başlık üret veya
                        aşağıdaki kutucuğa başlık yaz.</div>
                    <div class="form">
                        <form method="post" onsubmit="return false;">
                            <div class="alan">
                                <div class="alan">
                                    <div class="label2" for="tekilbaslik"><b>Başlık:</b><br>
                                        <input class="form-control col-8" type="text" name="tekilbaslik" id="tekilbaslik" required>
                                        <div class="info-message">Bir başlık yazın. Örnek: Yapay Zekanın Sıradan
                                            Hayatımıza Etkisi Ne Nedir? </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alan">
                                <input class="btn btn-primary" name="baslikuret" id="tekil_makale_uret" onclick="tekilMakale();" type="button" value="Makale Oluştur ✎">
                            </div>
                        </form>
                        <hr>
                        <div class="tekilMakaleyaz">
                            <h3 id="tekilMakBaslik">
                            </h3>
                            <p id="tekmak"></p>
                            <button class="btn btn-primary" onclick="postEt();" type="button" value="Paylaş">Paylaş</button>

                        </div>
                    </div>

                </div>
            </li>

            <li id="tab-content" class="tab-content tab-content-4 typography">
            </li>

            <li id="tab-content" class="tab-content tab-content-last typography">

            </li>
        </ul>
    </div>
    <!--/ tabs -->
</div>
<img id="maskot" style="transform: scaleX(-1);" src="<?php echo $foto; ?>">
</div>

<script>
    document.addEventListener('click', function(event) {
        // "Başlıklarla Makaleler Üret" butonunu seçelim
        const makaleleriUretButton = event.target.closest('#makaleleriUretButton');
        // 2. sekme etiketini seçelim
        const tab2 = document.getElementById('tab2');
        const basliktanuret = document.getElementById('basliktanuret');

        if (makaleleriUretButton && tab2) {
            // "Başlıklarla Makaleler Üret" butonuna tıklama olayı ekleyelim
            makaleleriUretButton.addEventListener('click', function() {
                // Butona tıklandığında 2. sekmeye geçişi sağlayalım
                tab2.click();
                basliktanuret.removeAttribute("hidden");
                CheckBoxUpdate();
            });
        }

        const clearAllCheck = event.target.closest('#clearAllCheck');
        if (clearAllCheck) {
            const checkboxes = document.querySelectorAll('.input-group-text input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false; // Tüm checkbox'ları işaretle
            });

            const elements = document.querySelectorAll('.liLists');
            // Her bir elementi silme
            elements.forEach(function(element) {
                element.remove();
            });
        }
    });

    document.addEventListener('click', function(event) {
        const selectAllButton = event.target.closest('#selectAllButton');
        if (selectAllButton) {
            const checkboxes = document.querySelectorAll('.input-group-text input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true; // Tüm checkbox'ları işaretle
            });
        }
    });

    document.getElementById("baslikuretform").addEventListener("submit", function(event) {

        event.preventDefault(); // Formun varsayılan davranışını engelle
        ClearTitles();
        var icerik_turu = document.getElementById("icerik_turu").value;
        var sektor = document.getElementById("sektor").value;
        var baslik_adedi = document.getElementById("baslik_adedi").value;
        var dil = document.getElementById("dil").value;
        var apikey = "<?php echo get_option('apideger'); ?>";
        var islemler = document.getElementById('islemler');
        var metin = "Content Type: " + icerik_turu + ", Sector: " + sektor + ", Title: " + baslik_adedi + ", ApiKey: " + apikey;
        var mesajlar = ['İşlem Başlatıldı.', 'İşlem Başlatıldı..', 'İşlem Başlatıldı...', 'İstekler Alınıyor.'];
        // AJAX isteği oluştur
        console.log("ajax isteği oluşturuyorum.");
        var generatedTitlesDiv = document.getElementById('generatedTitles');
        if (generatedTitlesDiv.innerHTML.trim() === '') {
            document.getElementById('islemler').innerHTML = "Yükleniyor...";
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "İstek Alındı...";
            }, 500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Erişim Sağlandı!";
            }, 1000);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Makale Yazarı aranıyor...";
            }, 1500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Başlıklar Yazılıyor...";
            }, 2000);
        } else {
            document.getElementById('islemler').innerHTML = "Yükleniyor...";
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "İstek Alındı...";
            }, 500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Erişim Sağlandı!";
            }, 1000);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Makale Yazarı aranıyor...";
            }, 1500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Yeni Başlıklar isteniyor...";
            }, 2000);
        }

        CheckBoxUpdate();
        var xhr = new XMLHttpRequest();
        var url = "<?php echo plugins_url('functions.php', __FILE__); ?>";
        var params = "icerik_turu=" + icerik_turu + "&sektor=" + sektor + "&baslik_adedi=" + baslik_adedi + "&dil=" + dil + "&metin=" + metin + "&apikey=" + apikey;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Gelen yanıtı al
                var response = xhr.responseText;
                // HTML içine yerleştirme işlemi
                document.getElementById("generatedTitles").innerHTML = response;
                console.log("Oluşturulan Başlık: " + response);
                islemler.innerHTML = null;
            }
        };

        xhr.send(params);

    });
    document.addEventListener("DOMContentLoaded", function() {
        var wpwrapDiv = document.getElementById("wpwrap");
        if (wpwrapDiv) {
            wpwrapDiv.style.background = "#bdcbe5";
        }
    });

    var makalelerDiv = document.querySelector('.makaleler');
    async function tekilMakale(tekilbaslik) {
        event.preventDefault();
        tekilbaslik = document.getElementById("tekilbaslik").value;
        var makalealani = document.getElementById('tekmak');
        var tekilMakBaslik = document.getElementById('tekilMakBaslik');
        var apiKey = '<?php echo get_option("apideger"); ?> ';

        var generatedTitlesDiv = document.getElementById('generatedTitles');
        if (generatedTitlesDiv.innerHTML.trim() === '') {
            document.getElementById('islemler').innerHTML = "Yükleniyor...";
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "İstek Alındı...";
            }, 500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Erişim Sağlandı!";
            }, 1000);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Makale Yazarı aranıyor...";
            }, 1500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Başlıklar Yazılıyor...";
            }, 2000);
        } else {
            document.getElementById('islemler').innerHTML = "Yükleniyor...";
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "İstek Alındı...";
            }, 500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Erişim Sağlandı!";
            }, 1000);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Makale Yazarı aranıyor...";
            }, 1500);
            setTimeout(function() {
                document.getElementById('islemler').innerHTML = "Yeni Başlıklar isteniyor...";
            }, 2000);
        }
        try {
            var tekilMakaleEkle = document.querySelector('.tekilMakaleyaz');
            tekilMakBaslik.innerHTML = tekilbaslik;
            const makale = await makaleyiChatGPTUzerindenOlustur(tekilbaslik, apiKey);
            console.log('Makale oluşturuldu:', makale);
            makalealani.innerHTML = makale;
        } catch (error) {
            console.error('Makale oluşturma hatası:', error);
        }
    }
    async function makaleleriUret() {

        var secilenBasliklar = document.querySelectorAll('#secilenbasliks li');
        var basliklar = [];
        secilenBasliklar.forEach(function(li) {
            basliklar.push(li.textContent);
        });

        var apiKey = '<?php echo get_option("apideger"); ?> ';

        for (let i = 0; i < basliklar.length; i++) {
            try {
                const makale = await makaleyiChatGPTUzerindenOlustur(basliklar[i], apiKey);
                console.log('Makale', i + 1, 'oluşturuldu:', makale);
                ekleMakale(makalelerDiv, makale, i, basliklar[i]);
            } catch (error) {
                console.error('Makale oluşturma hatası:', error);
            }
        }
    }
    async function ekleMakale(makalelerDiv, makale, index, baslik) {
        const icerikAlani = document.getElementById("editoralani");
        const editorMakaleBaslk = document.getElementById("editorMakaleBaslk");
        const editorMakaleSayi = document.getElementById("editorMakaleSayi");
        editorMakaleBaslk.value = `${baslik}`;
        icerikAlani.innerHTML = `${makale}`;
        editorMakaleSayi.innerHTML = `<b>Makale ${index + 1}`;
    }

    async function makaleyiChatGPTUzerindenOlustur(baslik, apiKey) {
        const apiURL = 'https://api.openai.com/v1/chat/completions';
        const makaleUzunlugu = 500;
        const dil = "tr";
        const anahtarkelimeler = baslik.split(' ').join(', ');
        console.log(anahtarkelimeler);

        const data = {
            'model': 'gpt-3.5-turbo-16k',
            'messages': [{
                'role': 'system',
                'content': `Generate a ${makaleUzunlugu} word article on the topic of "${baslik}" in the "${dil}" language. Write SEO-friendly articles based on these keywords "${anahtarkelimeler}".`
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
                return responseData.choices[0].message.content;
            } else {
                throw new Error('Makale oluşturma isteği başarısız oldu.');
            }
        } catch (error) {
            throw new Error('Hata oluştu: ' + error);
        }
    }

    function ClearTitles() {
        const elements = document.querySelectorAll('.liLists');
        // Her bir elementi silme
        elements.forEach(function(element) {
            element.remove();
        });
    }

    function CheckBoxUpdate() {
        ClearTitles();
        const checkList = document.getElementsByClassName('baslik-checkbox');
        for (let i = 0; i < checkList.length; i++) {
            if (checkList[i].checked) {
                const textName = checkList[i].id.replace('check', 'text');
                console.log(textName);
                const checkText = document.getElementById(textName).value;
                console.log(checkText);
                const ulCheck = document.getElementById('secilenbasliks');
                const li = document.createElement('li');
                li.setAttribute('class', 'liLists');
                li.innerText = checkText;
                ulCheck.appendChild(li);
            }
        }
    }



    // post etme işlemi


    function postEt() {
        const xhr = new XMLHttpRequest();
        const url = '<?php echo plugins_url('postet.php', __FILE__); ?>'; // PHP kodunun bulunduğu sayfanın URL'si

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send( /*Here goes your POST data if any*/ );
    }


    // editor

    $('.newPost button[data-func]').click(function() {
        document.execCommand($(this).data('func'), false);
    });

    $('.newPost select[data-func]').change(function() {
        var $value = $(this).find(':selected').val();
        document.execCommand($(this).data('func'), false, $value);
    });

    if (typeof(Storage) !== "undefined") {

        $('.editor').keypress(function() {
            $(this).find('.saved').detach();
        });
        $('.editor').html(localStorage.getItem("wysiwyg"));

        $('button[data-func="save"]').click(function() {
            $content = $('.editor').html();
            localStorage.setItem("wysiwyg", $content);
            $('.editor').append('<span class="saved"><i class="fa fa-check"></i></span>').fadeIn(function() {
                $(this).find('.saved').fadeOut(500);
            });
        });

        $('button[data-func="clear"]').click(function() {
            $('.editor').html('');
            localStorage.removeItem("wysiwyg");
        });


    }
</script>