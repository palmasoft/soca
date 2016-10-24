<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zopim
 *
 * @author Puro Ingenio Samario
 */
class Zopim {

    //put your code here
    public static function chat_soporte($ID_ZOPIM = '2s4Wlb3KIaz7u1RrJQ2r5nGqqhpYfqEP') {
        echo "<!--Start of Zopim Live Chat Script-->
            <script type=\"text/javascript\">
            window.\$zopim||(function(d,s){var z=\$zopim=function(c){z._.push(c)},\$=z.s=
            d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
            _.push(o)};z._=[];z.set._=[];\$.async=!0;\$.setAttribute('charset','utf-8');
            \$.src='//v2.zopim.com/?" . $ID_ZOPIM . "';z.t=+new Date;\$.
            type='text/javascript';e.parentNode.insertBefore(\$,e)})(document,'script');
            </script>
            <!--End of Zopim Live Chat Script-->";
    }

}
