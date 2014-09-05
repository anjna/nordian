<?php
/*
Credits: Bit Repository
*/

class Filter_String  {

var $strings;
var $text;
var $keep_first_last;
var $replace_matches_inside_words;

function filter()
{
$new_text = '';


$regex = '/<\/?(?:\w+(?:=["\'][^\'"]*["\'])?\s*)*>/'; // Tag Extractor

preg_match_all($regex, $this->text, $out, PREG_OFFSET_CAPTURE);

$array = $out[0];

if(!empty($array))
{
	if($array[0][1] > 0)
	{
	$new_text .= $this->do_filter(substr($this->text, 0, $array[0][1]));
	}

   foreach($array as $value)
   {
   $tag = $value[0];
   $offset = $value[1];

   $strlen = strlen($tag); // characters length of the tag

   $start_str_pos = ($offset + $strlen); // start position for the non-tag element
   $next = next($array);

   // end position for the non-tag element
   $end_str_pos = $next[1];

   // no end position? 
   // This is the last text from the string and it is not followed by any tags
   if(!$end_str_pos) $end_str_pos = strlen($this->text);


// Start constructing the new resulted string. We'll add tags now!
   $new_text .= substr($this->text, $offset, $strlen);


   $diff = ($end_str_pos - $start_str_pos);

       // Is this a simple string without any tags? Apply the filter to it
       if($diff > 0)
       { 
       $str = substr($this->text, $start_str_pos, $diff);

       $str = $this->do_filter($str);

       $new_text .= $str; // Continue constructing the text with the (filtered) text
       }
   }
}
else // No tags were found in the string? Just apply the filter
{
$new_text = $this->do_filter($this->text);
}

return $new_text;
}

function do_filter($var)
{
if(is_string($this->strings)) $this->strings = array($this->strings);

   foreach($this->strings as $word)
   {
	  $word = trim($word);

	  $replacement = '';

	  $str = strlen($word);

	  $first = ($this->keep_first_last) ? $word[0] : '';
	  $str = ($this->keep_first_last) ? $str - 2 : $str;
	  $last = ($this->keep_first_last) ? $word[strlen($word) - 1] : '';

	  $replacement = str_repeat('*', $str);

	  if($this->replace_matches_inside_words)
	  {
	     $var = str_replace($word, $first.$replacement.$last, $var);
	  }
	  else
	  {
	     $var = preg_replace('/\b'.$word.'\b/i', $first.$replacement.$last, $var);
	  }
   }

return $var;
}

}
/*
$filter = new Filter_String;

$filter->strings = array('consectetuer','consequat','turpis', 'href','sala');

$filter->text = 'Lorem ipsum dolor sit amet, sala sjdakfljasklj  href <a href="http://www.domain.com/">consectetuer</a> adipiscing elit. Nulla mi nunc, consequat vitae, condimentum at, iaculis at, turpis. Praesent suscipit. Maecenas et lectus.';

$filter->keep_first_last = false;
$filter->replace_matches_inside_words = false;

$new_text = $filter->filter();

echo $new_text;
*/



function StripSearch($var,$antispamarray)
{
	
    $flgg=0;
    $pattern[0]='/\"/';
    $pattern[1]='/\(/';
    $pattern[2]='/\)/';
    $pattern[3]='/\{/';
    $pattern[4]='/\}/';
    $pattern[5]='/\[/';
	$pattern[6]='/\]/';
	$pattern[7]='/\-/';
	$pattern[8]='/\\//';
	$pattern[9]='/\\\/';
	$pattern[10]='/\^/';
	$pattern[1]='/\?/';
	$pattern[12]='/\_/';
	$pattern[13]='/\|/';
	$pattern[14]='/\*/';
    $pattern[15]='/\=/';
    $pattern[16]='/\n/';
    $pattern[17]='/\./';
    $resultAfterStrip = "";
    foreach($pattern as $pattern1)
    {    
        if(preg_match($pattern1,$var))
        {
            if($resultAfterStrip == "")
            {
                $resultAfterStrip=preg_replace($pattern1,' ',$var);
            }
            else
            {
                $resultAfterStrip=preg_replace($pattern1,' ',$resultAfterStrip);
            }    
        }
    }
    
	echo $resultAfterStrip; die;
	
    if(empty($resultAfterStrip))
    {
        $resultAfterStrip=$var;
    }
     $resultAfterStrip=' '.$resultAfterStrip.' ';

    foreach($antispamarray as $antispam)
    {
        $antispam1="/\b".$antispam."\b/i";
        $resultAfterStrip1=preg_match($antispam1,$resultAfterStrip);    
        if ($resultAfterStrip1 == 0)
        {    
        }
        else
        {
            $flgg=2;
        }    
    }
    if($flgg==2)
    return true;
    else
    return false;
        
}

  
  $antispamarray = array('consectetuer','consequat','turpis', 'href','sala');
  $message = ' hsfhjkashfjkhsajk sjajfjsafjklsaj consequat jdlsajflads <consequat ]'; 
  $messageIs=StripSearch($message,$antispamarray);
  
  
  echo $messageIs;
  
  die;



?>