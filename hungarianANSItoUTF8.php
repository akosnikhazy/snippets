<?
function ansiToUtf8($line)
{
    // if you ever fight with the characters ő and ű 🤡

    // it is already utf8 so go away
    if (mb_check_encoding($line, 'UTF-8'))  return $line; 

    // try incov it can fail
    $utf8 = @iconv('CP1250', 'UTF-8//TRANSLIT//IGNORE', $line);

    // return incov result or fall back to mb convert
    return $utf8 !== false ? $utf8 : mb_convert_encoding($line, 'UTF-8', 'CP1250');

    // you might come up with better error handle here :)
}
