
<div class="pagination" style="text-align: center">	
        <div class="btn-group">
            <?php
//            echo $this->Paginator->prev('< ' . __d('croogo', 'prev'));
//            echo $this->Paginator->numbers();
//            echo $this->Paginator->first('< ' . __d('croogo', 'first'));
//            echo $this->Paginator->prev('< ' . __d('croogo', 'prev'));


            echo $this->Paginator->prev('« Previous', array('class' => 'btn'), null, array('class' => 'btn disabled', 'escape' => 'true'));

            // Shows the page numbers
            echo $this->Paginator->numbers(array(
                'first' => 3,
                'last' => 3,
                'separator' => '', 
                'class' => 'btn'));

            echo $this->Paginator->next('Next »', array('class' => 'btn'), null, array('class' => 'btn'));
            ?>
        </div>
        <div>
            <?php
            // prints X of Y, where X is current page and Y is number of pages
            echo $this->Paginator->counter();
            ?>
        </div>
    </div>
