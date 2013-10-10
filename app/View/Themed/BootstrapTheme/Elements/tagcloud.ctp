<?php
	

echo $this->Html->script('jquery.tagcloud.min', false);	
$Node = ClassRegistry::init('Nodes.Node');
$nodes = $Node->find('all', array(
   'conditions' => array(
       'Node.status' => 1,
       'Node.promote' => 1,
       'Node.visibility_roles LIKE'=>'%"3"%',
   )
));
	
         

if (empty($title)){
	$title = "Your Favorite Tag's";	
}

if (empty($terms)){
	$termsList = array();
	// Build Tags
	foreach ($nodes as $file) {
			if (!empty($file['Node']['terms'])) {
				$aNodeTerm = json_decode( $file['Node']['terms'], true);
				foreach ($aNodeTerm as $k=>$nt) {
					if ( empty($termsList[$k]) ) {
						$termsList[$k] = array(
							'name' =>  $nt,
							'cant' => 0
						);
					}
					$termsList[$k]['cant'] = $termsList[$k]['cant'] + 1;
				}
				
			}
	}
}
?>

<div class="cloud-tags">
	<h3 class="border"><?php echo $title?></h3>
    <div class="tags">
    	<ul id="tags">
    		<?php
    		 foreach ($termsList as $tid=>$il) { ?>
    			<li value="<?php echo $il['cant'] ?>"><?php echo $this->Html->link($il['name'], '/search?term_id='.$tid) ?></li>
        	<?php } ?>
        </ul>
    </div>
</div>

<script>
	$("#tags").tagcloud({type:"list",sizemin:8}).find("li");
</script>
