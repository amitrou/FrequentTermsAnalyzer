<?php
  include('frequentTermsAnalyzer.php');

  $myCaption = 'áéí';
  //encode
  $myCaptionEncoded = htmlentities($myCaption, ENT_QUOTES);
  //reverse (decode)
  $myCaptionDecoded = html_entity_decode($myCaptionEncoded);
  print $myCaptionDecoded."\n\n";
  
  $a = "Lo confirm&oacute; el titular de la procuradur&amp;iacute;a, Carlos Gonella.  Dijo que el Gobierno apunta a a adecuar el R&amp;eacute;gimen Penal Cambiario que tiene m&amp;aacute;s de 40 a&amp;ntilde;os.";
  $a = str_replace('&amp;', '&', $a);
  $b = html_entity_decode($a, ENT_NOQUOTES);
  print($b); exit;
  
  $generalTextFile  = file_get_contents('data/wikipedia_new_york_city.txt');
  $generalTextFile .= file_get_contents('data/wikipedia_social_media.txt');
  $generalTextFile .= file_get_contents('data/wikipedia_personal_finance.txt');
  $generalTextFile .= file_get_contents('data/wikipedia_barbicue.txt');
  $candidates = explode(' ', vacuumCleaner($generalTextFile));
  $analyzer   = new frequentTermsAnalyzer($candidates);
  $excludedWords = $analyzer->getFrequentWords();
  #print_r($excludedWords);
  
  $dataFile = 'data/wikipedia_personal_finance.txt';
  $particularTextFile = file_get_contents($dataFile);
  $candidates = explode(' ', vacuumCleaner($particularTextFile));
  $analyzer   = new frequentTermsAnalyzer($candidates, $excludedWords);
  $compoundWords = $analyzer->getCompoundTerms();
  print "Processing data file: ". $dataFile ."\n";
  print_r($compoundWords);
  
  function vacuumCleaner($str){
    $str = strtolower($str);
    $str = preg_replace('/[^a-z ]/', '', $str);
    return preg_replace('/\s+/', ' ', $str);
  }
?>