<?php

require_once "conexionRSS.php";

$sXML = download("https://feeds.elpais.com/mrss-s/pages/ep/site/elpais.com/portada");
$oXML = new SimpleXMLElement($sXML);

require_once "conexionBBDD.php";

$sqlInsert = "INSERT INTO elpais (titulo, link, descripcion, categoria, fpubli, contenido) VALUES ($1, $2, $3, $4, $5, $6) ON CONFLICT (link) DO NOTHING";

pg_query($link, "BEGIN");

$insertCount = 0;
$valuesArray = [];

foreach ($oXML->channel->item as $item) {
    if ($insertCount >= 5) {
        break;
    }

    $categoriaFiltro = '';
    foreach ($item->category as $category) {
        if (in_array($category, ["Política", "Deportes", "Ciencia", "España", "Economía", "Música", "Cine", "Europa", "Justicia"])) {
            $categoriaFiltro = "[" . $category . "]" . $categoriaFiltro;
        }
    }

    $fPubli = strtotime($item->pubDate);
    $new_fPubli = date('Y-m-d', $fPubli);

    $content = $item->children("content", true);
    $encoded = (string)$content->encoded;

    $valuesArray[] = [
        (string)$item->title,
        (string)$item->link,
        (string)$item->description,
        $categoriaFiltro,
        $new_fPubli,
        $encoded
    ];

    $insertCount++;
}

if (count($valuesArray) > 0) {
    foreach ($valuesArray as $values) {
        pg_query_params($link, $sqlInsert, $values);
    }
}

pg_query($link, "COMMIT");
?>




