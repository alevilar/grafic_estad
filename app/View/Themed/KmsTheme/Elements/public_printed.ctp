<?php
$Node = ClassRegistry::init('Nodes.Node');
$nodes = $Node->find('all', array(
   'conditions' => array(
       'Node.status' => 1,
       'Node.promote' => 1,
       'Node.type' => 'printed',
       'Node.visibility_roles LIKE'=>'%"3"%',
   )
));
?>
<div class="home-blog-container">
    <h2 class="green">List of Printed Contents</h2>
		<table border=0>
			<th>
				<td>No</td>
				<td>Title</td>
				<td>Excerpt</td>
			</th>
    <?php
    $count=1;
    foreach ($nodes as $n) {
        $this->Nodes->set($n);
        ?>
        <div class="blog-box">
            <div class="txt">
			<tr>
				<td><?php echo $count?></td>
				<td><?php echo $this->Nodes->field('title')?></td>
				<td><?php echo $this->Nodes->field('excerpt')?><?php echo $this->Html->link('More...', $this->Nodes->field('url')); ?></td>
			</tr>
			
            </div>                            
        </div>
        <?php
	$count++;
    }
    ?>   
		</table>
    <div class="clear"></div>
</div><!-- end of home-event-container -->
