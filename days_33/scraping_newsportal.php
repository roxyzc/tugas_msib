<?php
$html = file_get_contents('https://www.newsportal.id/');

$data = array();
$counter = 0;

$t_start = strpos($html, "<div class='featuredui-block item0'>");

while ($t_start !== false && $counter < 5) {
    $t_html = substr($html, $t_start);

    // Link
    $t_link_start = strpos($t_html, "href='") + 6;
    $t_link_end = strpos($t_html, ".html", $t_link_start) + 5;
    $link = substr($t_html, $t_link_start, $t_link_end - $t_link_start);

    // Image
    $t_image_start = strpos($t_html, "data-src='") + 10;
    $t_image_end = strpos($t_html, "'/>", $t_image_start);
    $image = substr($t_html, $t_image_start, $t_image_end - $t_image_start);

    // Title
    $t_title_start = strpos($t_html, ".html' title='") + 14;
    $t_title_end = strpos($t_html, "'>", $t_title_start);
    $title = substr($t_html, $t_title_start, $t_title_end - $t_title_start);

    $data[$counter]['img'] = $image;
    $data[$counter]['title'] = $title;
    $data[$counter]['link'] = $link;

    $article_html = file_get_contents($link);

    $script_start = strpos($article_html, "<script type='application/ld+json'>") + 35;
    $t_article_html = substr($article_html, $script_start);
    $script_end = strpos($t_article_html, '</script>');
    $json = substr($t_article_html, 0, $script_end);
    $arr_data = json_decode($json, true);

    $data[$counter]['datePublished'] = $arr_data['datePublished'];

    $all_paragraphs = '';
    $pos = 0;

    while (($body_start = strpos($article_html, "<p>", $pos)) !== false) {
        $body_end = strpos($article_html, "</p>", $body_start);
        if ($body_end === false) {
            break;
        }

        $paragraph = substr($article_html, $body_start + 3, $body_end - $body_start - 3);
        $clean_paragraph = strip_tags($paragraph);
        $all_paragraphs .= $clean_paragraph . "\n";
        $pos = $body_end + 4;
    }


    $data[$counter]['body'] = trim($all_paragraphs);

    $t_start = strpos($html, "<div class='featuredui-block item", $t_start + 1);
    $counter++;
}

// Print data
$json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
$file = 'hasil.json';
file_put_contents($file, $json_data);

$data = json_decode($json_data, true);

print_r($data);
