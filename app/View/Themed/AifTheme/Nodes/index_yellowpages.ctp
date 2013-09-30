<div class="round-boxes">

    <h2>Expert Yellow Pages </h2>
    <div class="yellowpages-container">

        <div class="search-page">
            <p class="title">Search by Yellow Pages</p>
            
            <?php echo $this->element('nodes_index_search'); ?>
            
        </div>

        <div class="browse-export">
            <p class="title">Browse for an expert by name</p>
            <div class="browse-box">
                <ul>
                    <li><?php echo $this->Html->link('A', '/yellowpages/letter/a');?></li>
                    <li><?php echo $this->Html->link('B', '/yellowpages/letter/b');?></li>
                    <li><?php echo $this->Html->link('C', '/yellowpages/letter/c');?></li>
                    <li><?php echo $this->Html->link('D', '/yellowpages/letter/d');?></li>
                    <li><?php echo $this->Html->link('E', '/yellowpages/letter/e');?></li>
                    <li><?php echo $this->Html->link('F', '/yellowpages/letter/f');?></li>
                    <li><?php echo $this->Html->link('G', '/yellowpages/letter/g');?></li>
                    <li><?php echo $this->Html->link('H', '/yellowpages/letter/h');?></li>
                    <li><?php echo $this->Html->link('I', '/yellowpages/letter/i');?></li>
                    <li><?php echo $this->Html->link('J', '/yellowpages/letter/j');?></li>
                    <li><?php echo $this->Html->link('K', '/yellowpages/letter/k');?></li>
                    <li><?php echo $this->Html->link('L', '/yellowpages/letter/l');?></li>
                    <li><?php echo $this->Html->link('M', '/yellowpages/letter/m');?></li>
                    <li><?php echo $this->Html->link('N', '/yellowpages/letter/n');?></li>
                    <li><?php echo $this->Html->link('O', '/yellowpages/letter/o');?></li>
                    <li><?php echo $this->Html->link('P', '/yellowpages/letter/p');?></li>
                    <li><?php echo $this->Html->link('Q', '/yellowpages/letter/q');?></li>
                    <li><?php echo $this->Html->link('R', '/yellowpages/letter/r');?></li>
                    <li><?php echo $this->Html->link('S', '/yellowpages/letter/s');?></li>
                    <li><?php echo $this->Html->link('T', '/yellowpages/letter/t');?></li>
                    <li><?php echo $this->Html->link('U', '/yellowpages/letter/u');?></li>
                    <li><?php echo $this->Html->link('V', '/yellowpages/letter/v');?></li>
                    <li><?php echo $this->Html->link('W', '/yellowpages/letter/w');?></li>
                    <li><?php echo $this->Html->link('X', '/yellowpages/letter/x');?></li>
                    <li><?php echo $this->Html->link('Y', '/yellowpages/letter/y');?></li>
                    <li><?php echo $this->Html->link('Z', '/yellowpages/letter/z');?></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>

        <div class="directory-result">
            <?php if (!empty($this->params->params['letter'])) { ?>
            <p class="title">Experts' names starting with '<?php echo strtoupper($this->params->params['letter']); ?>'.</p>
            <p class="subtitle">Click on an expert's name to see his or her full details. Click on a keyword to see experts in related fields.</p>
            <?php } ?>
            
            <div class="result-box">
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
                            <td width="30%" class="search-txt">Past(s):</td>
                            <td width="70%" class="search-txt"><?php echo $this->Nodes->field("excerpt"); ?></td>
                        </tr>
                        <tr>
                            <td width="30%" class="search-txt">Areas of expertise:</td>
                            <td width="70%" class="search-txt"><?php echo $this->Nodes->body(); ?></td>
                        </tr>
                        <tr>
                            <td width="30%" class="search-txt">Keywords:</td>
                            <td width="70%" class="search-txt"><?php echo $terms ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody></table>
            </div>
        </div>
    </div><!-- end of yellowpages-container -->
    <div class="clear"></div>
</div>

