<?php 
        $urlLinda = '';

        $urlBase = $this->action;
		foreach ($this->params->pass as $p) {
             $urlBase .= '/'.$p; 
        }


        foreach ($this->params->query as $k=>$d) {
            if ( is_array($d) ){
                foreach ($d as $v) {
                    $urlLinda .= $k."[]=$v&";  
                }
            } else {
                $urlLinda .= "$k=$d&";  
            }
        }
        $urlLinda = trim($urlLinda, '&');
        if ( $urlLinda ) {
        	$url = $urlBase.'.xls?'.$urlLinda;
        } else {
        	$url = $urlBase.'.xls';
        }

        echo $this->Html->link( 'Descargar Excel',
            Router::url($url, true), 
            array(
                'escape' => false,
                'icon' =>  'chevron-down', 
                'tooltip' => __d('croogo', 'Move down'),
                'class' => 'btn-descargar-xls btn btn-small btn-success',
                ));
    
