<div class="search-page">
    <div class="search-box">
        <?php
        echo $this->Form->create('Node', array('class' => 'form-search'));
        echo $this->Form->text('q', array('label' => false, 'class' => 'searchinput'));
        echo $this->Form->button('search', array('class' => 'button blue medium', 'type' => 'submit'));
        echo $this->Form->end();
        ?>
    </div>
</div>