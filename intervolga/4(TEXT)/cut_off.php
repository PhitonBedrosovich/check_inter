<?php
$text = <<<TXT
<p class="big">
	Год основания:<b>1589 г.</b> Волгоград отмечает день города в <b>2-е воскресенье сентября</b>. <br>В <b>2023 году</b> эта дата - <b>10 сентября</b>.
</p>
<p class="float">
	<img src="https://www.calend.ru/img/content_events/i0/961.jpg" alt="Волгоград" width="300" height="200" itemprop="image">
	<span class="caption gray">Скульптура «Родина-мать зовет!» входит в число семи чудес России (Фото: Art Konovalov, по лицензии shutterstock.com)</span>
</p>
<p>
	<i><b>Великая Отечественная война в истории города</b></i></p><p><i>Важнейшей операцией Советской Армии в Великой Отечественной войне стала <a href="https://www.calend.ru/holidays/0/0/1869/">Сталинградская битва</a> (17.07.1942 - 02.02.1943). Целью боевых действий советских войск являлись оборона  Сталинграда и разгром действовавшей на сталинградском направлении группировки противника. Победа советских войск в Сталинградской битве имела решающее значение для победы Советского Союза в Великой Отечественной войне.</i>
</p>
TXT;

/**
 * Функция для обрезки текста с сохранением HTML-форматирования
 * @param string $text Исходный текст с HTML-разметкой
 * @param int $wordCount Количество слов, до которых нужно обрезать текст
 * @return string Обрезанный текст с сохраненным форматированием
 */
function trimTextWithHTML($text, $wordCount) {
    $plainText = strip_tags($text);

    $quoteMap = [];
    $plainText = preg_replace_callback(
        '/[\'"]{1,2}[^\'"]+[\'"]{1,2}|«[^»]+»/u',
        function ($matches) use (&$quoteMap) {
            $key = '__QUOTE_' . count($quoteMap) . '__';
            $quoteMap[$key] = $matches[0];
            return $key;
        },
        $plainText
    );

    $words = preg_split('/[\s,\.]+/u', trim($plainText), -1, PREG_SPLIT_NO_EMPTY);

    // Фильтруем слова, исключая числа (кроме текстовых, например, "2-е")
    $filteredWords = array_filter($words, function ($word) {
        return !preg_match('/^[0-9]+$/u', $word);
    });

    $filteredWords = array_values($filteredWords);

    echo "<!-- Всего слов: " . count($filteredWords) . " -->\n";

    if (count($filteredWords) <= $wordCount) {
        return $text;
    }

    $trimmedWords = array_slice($filteredWords, 0, $wordCount);

    $trimmedWords = array_map(function ($word) use ($quoteMap) {
        return isset($quoteMap[$word]) ? trim($quoteMap[$word], '«»"\'') : $word;
    }, $trimmedWords);

    $tempText = implode(' ', $trimmedWords);

    $position = 0;
    $pattern = preg_quote($tempText, '/');
    $regex = '/(' . $pattern . ')(?:\s|$)/iu';

    if (preg_match($regex, $plainText, $matches, PREG_OFFSET_CAPTURE)) {
        $position = $matches[1][1] + strlen($matches[1][0]);
    }

    $htmlPosition = 0;
    $plainPos = 0;
    $inTag = false;
    for ($i = 0; $i < strlen($text); $i++) {
        if ($text[$i] === '<') {
            $inTag = true;
            continue;
        }
        if ($text[$i] === '>') {
            $inTag = false;
            continue;
        }
        if (!$inTag && $plainPos >= $position) {
            $htmlPosition = $i;
            break;
        }
        if (!$inTag) {
            $plainPos++;
        }
    }

    $trimmedHTML = substr($text, 0, $htmlPosition);

    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $trimmedHTML, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $xpath = new DOMXPath($dom);
    $lastTextNode = $xpath->query('//text()[normalize-space()]')->item($xpath->query('//text()[normalize-space()]')->length - 1);
    if ($lastTextNode) {
        $lastTextNode->nodeValue .= '...';
    }

    $html = $dom->saveHTML();
    libxml_clear_errors();

    $html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace(['<?xml encoding="UTF-8">', '<?xml encoding="UTF-8"?>'], '', $html));

    return trim($html);
}

// Обрезаем текст до 29 слов и выводим с сохранением форматирования
$trimmedText = trimTextWithHTML($text, 29);
echo $trimmedText;