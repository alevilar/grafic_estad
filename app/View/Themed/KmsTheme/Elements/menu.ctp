
<div class="navbar-inner">
    <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php
        // debug($this);
        ?>
        <div class="nav-collapse collapse" id="menu-<?php echo $menu['Menu']['id']; ?>">
            <?php echo $this->Menus->nestedLinks($menu['threaded'], $options); ?>
        </div>

        <form class="navbar-search pull-right">
            <input type="text" class="search-query" placeholder="Search">
        </form>

    </div>
</div>
