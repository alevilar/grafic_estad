
<h2>Printed Materials</h2>
<div class="yellowpages-container">

    <?php echo $this->element('nodes_index_search');?>

    
    <?php echo $this->element('Kms.tagcloud', array('title' => 'Browse for Tags'));?>


    <div class="directory-result">

        <p class="title">Search Result</p>

        <div class="result-box">
            <?php
            if (count($nodes) == 0) {
                echo __d('croogo', 'No items found.');
            }
            ?>
            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="search-tbl">
                <tbody>
                    <?php
                    foreach ($nodes as $node):
                        $this->Nodes->set($node);

                        $terms = '';
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
                                $terms = implode(', ', $nodeTermLinks);
                            }
                        }
                        ?>

                        <tr>
                            <td width="30%" class="search-heading">&nbsp;</td>
                            <td width="70%" class="search-heading"><?php echo $this->Html->link($this->Nodes->field('title'), $this->Nodes->field('url')); ?></td>
                        </tr>
                        <tr>
                            <td width="30%" class="search-txt">Category:</td>
                            <td width="70%" class="search-txt"><?php echo $terms ?></td>
                        </tr>
                        <tr>
                            <td width="30%" class="search-txt">Autor:</td>
                            <td width="70%" class="search-txt"><?php echo $this->Nodes->field('User.name'); ?></td>
                        </tr>
    <!--                            <tr>
                            <td width="30%" class="search-txt">Tags:</td>
                            <td width="70%" class="search-txt"><a href="#">poverty</a> | <a href="#">social exclusion</a> | <a href="#">youth disadvantage</a> | <a href="#">rural poverty</a></td>
                        </tr>-->

                        <?php
                    endforeach;
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div><!-- end of yellowpages-container -->

<div class="clear"></div>