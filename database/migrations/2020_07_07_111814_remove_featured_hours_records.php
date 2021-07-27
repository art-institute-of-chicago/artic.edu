<?php

use Illuminate\Database\Migrations\Migration;

use App\Models\FeaturedHour;

class RemoveFeaturedHoursRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        if ($visitPage) {
            $visitPage->featured_hours()->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $data = [
            'external_link' => '/learn-with-us/ryan-learning-center',
            'position' => 1,
            'page_id' => 6,
            'published' => false,
            'de' => ['title' => 'The Ryan Learning Center', 'copy' => '<p>10:30-17:00 und donnerstags bis 20:00 Uhr<br>Freier Eintritt</p>', 'active' => true],
            'en' => ['title' => 'The Ryan Learning Center', 'copy' => '<p>10:30–5:00 and Wednesday, Thursday, and Friday until 8:00<br><a href="&quot;https://www.artic.edu/learn-with-us/ryan-learning-center">Access is currently limited. Learn more.</a><br>Free admission</p>', 'active' => true],
            'es' => ['title' => 'El Centro Educativo Ryan', 'copy' => '<p>De 10:30 a.m. a 5:00 p.m. y los jueves hasta las 8:00 p.m.&nbsp;<br>Entrada libre</p>', 'active' => true],
            'fr' => ['title' => 'Le centre d ́apprentissage Ryan', 'copy' => '<p>10h30-17h et les jeudis jusqu\'à 20h<br>Entrée libre&nbsp;</p>', 'active' => true],
            'ja' => ['title' => 'ライアンラーニングセンター', 'copy' => '<p>AM 10:30–PM 5:00、木曜日のみPM 8:00まで<br>入場無料</p>', 'active' => true],
            'pt' => ['title' => 'The Ryan Learning Center', 'copy' => '<p>das 10h30 às 17h e quintas-feiras até às 20h.<br>Entrada gratuita</p>', 'active' => true],
            'zh' => ['title' => 'Ryan Learning Center开放时间', 'copy' => '<p>每天上午10:30至下午5:00，周四开放至晚上8:00<br>RLC 免费入馆</p>', 'active' => true],
        ];
        $hour = FeaturedHour::create($data);

        $data = [
            'external_link' => '/library',
            'position' => 2,
            'page_id' => 6,
            'published' => false,
            'de' => ['title' => 'Die Ryerson und Burnham Bibliotheken', 'copy' => '<p>Montag–Freitag 13:00–17:00<br>Samstag–Sonntag GESCHLOSSEN</p>', 'active' => true],
            'en' => ['title' => 'The Ryerson and Burnham Libraries', 'copy' => '<p>Monday–Friday 1:00–5:00<br>Saturday–Sunday CLOSED</p>', 'active' => true],
            'es' => ['title' => 'Las bibliotecas Ryerson y Burnham', 'copy' => '<p>De lunes a viernes de 1:00 p.m. a 5:00 p.m. <br>Sábado y domingo CERRADO</p>', 'active' => true],
            'fr' => ['title' => 'Les bibliothèques Ryerson et Burnham', 'copy' => '<p>Lundi–vendredi 13h–17h<br>Samedi-dimanche FERMÉ&nbsp;</p>', 'active' => true],
            'ja' => ['title' => 'ライヤーソン & バーナム図書館', 'copy' => '<p>月曜－金曜&nbsp;PM1:00–5:00<br>土曜－日曜 閉館</p>', 'active' => true],
            'pt' => ['title' => 'The Ryerson and Burnham Libraries', 'copy' => '<p>Segundas e sextas-feiras das 13 às 17h<br>Sábados e domingos - FECHADO</p>', 'active' => true],
            'zh' => ['title' => 'Ryerson和Burnham图书馆开放时间', 'copy' => '<p>周一至周五下午1:00至5:00<br>周六至周日闭馆休息</p>', 'active' => true],
        ];
        $hour = FeaturedHour::create($data);

        $data = [
            'external_link' => 'http://shop.artic.edu',
            'position' => 3,
            'page_id' => 6,
            'published' => false,
            'de' => ['title' => 'Museumsshops', 'copy' => '<p>10:30-17:00 und donnerstags bis 20:00 Uhr</p>', 'active' => true],
            'en' => ['title' => 'Museum Shops', 'copy' => '<p>10:30–5:00 and Wednesday, Thursday, and Friday until 8:00</p>', 'active' => true],
            'es' => ['title' => 'Tiendas del museo', 'copy' => '<p>De 10:30 a.m. a 5:00 p.m. y los jueves hasta las 08:00 p.m.</p>', 'active' => true],
            'fr' => ['title' => 'Magasins du musée', 'copy' => '<p>10h30-17h30 et le jeudi jusqu\'à 20h00&nbsp;</p>', 'active' => true],
            'ja' => ['title' => '館内売店', 'copy' => '<p>AM 10:30–PM 5:30、木曜日のみPM 8:00まで</p>', 'active' => true],
            'pt' => ['title' => 'Lojas do Museu', 'copy' => '<p>das 10h30 às 17h30 e quintas-feiras até às 20h</p>', 'active' => true],
            'zh' => ['title' => '博物馆商店', 'copy' => '<p>上午10:30至下午5:30，周四开放至晚上8:00</p>', 'active' => true],
        ];
        $hour = FeaturedHour::create($data);
    }
}
