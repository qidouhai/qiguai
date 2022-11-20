<?


//rss判断
function analyrss($isrsslink){
$isrsslink =file_get_contents($isrsslink);

$aton = "http://www.w3.org/2005/Atom";

$rdf = "http://www.w3.org/1999/02/22-rdf-syntax-ns";

$rss = "http://purl.org/dc/elements/1.1/";

$isatom = strstr($isrsslink,$atom);

$isrdf = strstr($isrsslink,$rdf);

$isrss = strstr($isrsslink,$rss);

if($isatom||$isrdf||$isrss){
return 1;
}else{
return 2;
}

}



