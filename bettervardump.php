<?php
/*  
  Sometimes you just need a var dump that looks good and is easy to see.
  The basic var_dump puts everything on one line, so I have wrapped it in <pre> tags.

  There are two ways to use this: see the commented out code.

  usage: vd($var1, $var2, .... $varN);

*/
function vd()
{
        $args = func_get_args();

        foreach($args as $arg)
        {
            echo '<pre>';
            var_dump($arg);
            echo '</pre><hr>';
        }

        /*
        Or you can do this: 
        $args = func_get_args();
 
        echo '<pre>';
        var_dump(...$args);
        echo '</pre>';
       */
}
