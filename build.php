<?php
echo "[FA] font-awesome => iconset\n";

function nodearray($g) {
  $a=array();
  for ($x = 0; $x <= $g->length; $x++) {
    $a[$x]=$g->item($x);
  }
  return $a;
}

function getProp($e,$n) {
  return $e->attributes->getNamedItem($n)->nodeValue;
}

$doc=new DOMDocument();
@$doc->loadHTML(file_get_contents("http://www.bootstrapcdn.com/fontawesome/"));
$url=$doc->getElementById("fontawesomecss1_form")->getAttribute("value");
$svg=str_replace("css/font-awesome.min.css","fonts/fontawesome-webfont.svg",$url);

$doc=new DOMDocument();
@$doc->loadHTML(str_replace("&#x","",file_get_contents($svg)));
file_put_contents("./test.css",file_get_contents($url));
$res=new DOMDocument();
@$res->loadHTML('<link rel="import" href="../bower_components/iron-icon/iron-icon.html"><link rel="import" href="../bower_components/iron-iconset-svg/iron-iconset-svg.html"><iron-iconset-svg name="fa" size="179.2"><svg><defs></defs></svg>
</iron-iconset-svg>');
$defs=$res->getElementsByTagName("defs")->item(0);
$g=nodearray($doc->getElementsByTagName("glyph"));
$id=0;
$c=array();
foreach($g as $glyph) {
  if (!is_null($glyph)) {
    $g=$res->createElement("g");
    $path=$res->createElement("path");
    $path->setAttribute("transform","scale(0.1,-0.1) translate(0,-1536)");
    $path->setAttribute("d",$glyph->getAttribute("d"));
    $g->appendChild($path);
    $uni=str_replace(";","",$glyph->getAttribute("unicode"));
    $c[$uni]=$g;
  }
}
$csss=explode("}",file_get_contents("test.css"));
$css=array();
unset($csss[0]);

foreach ($csss as $item) {
  if (exec("echo '$item' | grep content -o") != "") {
    $item=str_replace([".fa-",':before','{content:"','"}','"'],"",$item);
    $css[]=$item;
  }
}

foreach($css as $item) {
  if ($item != "") {
    $a=explode('\f',$item);
    foreach(explode(",",$a[0]) as $ga) {
      if (!isset($c["f".$a[1]])) {echo "[FAIL] nothing matches $ga";} else {
        $g=$c["f".$a[1]]->cloneNode(true);
        $g->setAttribute("id",$ga);
        $defs->appendChild($g);
      }
    }
  }
}
echo "[DONE] saved as fa.html\n";
foreach(array("test.css") as $f) {unlink($f);}
$res->saveHTMLFile("./fa.html");
?>
