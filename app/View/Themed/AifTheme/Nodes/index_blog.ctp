<h2>Blog</h2>
<div class="blog-container">

    <?php
    if (count($nodes) == 0) {
        echo __d('croogo', 'No items found.');
    }
    ?>

    <?php
    foreach ($nodes as $node):
        
        $this->Nodes->set($node);
        ?>
        <div id="node-<?php echo $this->Nodes->field('id'); ?>" class="blog-box node node-type-<?php echo $this->Nodes->field('type'); ?>">

            <div class="post_title">
                <h3><?php echo $this->Html->link($this->Nodes->field('title'), $this->Nodes->field('url')); ?></h3>
                <p class="posted-by-text"><?php echo $this->Nodes->info(); ?></p>
            </div>

            <div class="post_content">

                <p><?php echo $this->Nodes->body(); ?></p>
                
                <?php echo $this->Html->link("<span>Read More →</span>", $this->Nodes->field('url'), array(
                    'escape' => false,
                    'title' => 'Read More',
                    'rel' => 'bookmark',
                    'style' => 'opacity: 1',
                    'class' => 'ka_button small_button',                    
                )); ?>

                <div class="post_date"><span class="day"><?php echo date('d', strtotime($this->Nodes->field('created'))); ?></span><br><span class="month"><?php echo date('M', strtotime($this->Nodes->field('created'))); ?></span></div>
                <div class="post_comments"><?php echo $this->Html->link("<span>".$this->Nodes->field('comment_count')."</span>", $this->Html->url($this->Nodes->field('url'), true) . '#comments', array('escape' => false));?></div>
                <div class="post_footer">
                    <div class="post_cats">
                        <p>
                            <?php
                            if (is_array($this->Nodes->node['Taxonomy']) && count($this->Nodes->node['Taxonomy']) > 0) {
                                            
                                            $nodeTerms = Hash::combine($this->Nodes->node, 'Taxonomy.{n}.Term.slug', 'Taxonomy.{n}.Term.title');
                                            $nodeTermLinks = array();
                                            if (count($nodeTerms) > 0) {
                                                    foreach ($nodeTerms as $termSlug => $termTitle) {
                                                            $nodeTermLinks[] = $this->Html->link($termTitle, array(
                                                                    'plugin' => 'nodes',
                                                                    'controller' => 'nodes',
                                                                    'action' => 'term',
                                                                    'type' => $this->Nodes->field('type'),
                                                                    'slug' => $termSlug,
                                                            ));
                                                    }
                                                    echo __d('croogo', 'Posted in') . ' ' . implode(', ', $nodeTermLinks);
                                            }
                                    }
                            ?>
                        </p>
                    </div>
                </div>
            </div><!-- end of post_content -->

        </div>
    
        <?php
    endforeach;
    ?>

    <div class="paging"><?php echo $this->Paginator->numbers(); ?></div>


    <div class="clearfix"></div>
</div><!-- end of blog-container -->