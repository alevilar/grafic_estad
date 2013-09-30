<div class="home-event-container">
        <h2 class="red">Upcoming Events / Programmes</h2>

        <?php 
        $AC = ClassRegistry::init('KmsCalendar.Activity');
        $acts = $AC->get(5);
        
        foreach ($acts as $a) {
            ?>
            <div class="event-box">
                <div class="imgdiv"><?php echo $this->Html->image('/login/images/event1.jpg');?></div>
                <div class="txt">
                    <?php
                    $time = "";
                    $time = empty($a['Activity']['time']) || $a['Activity']['time'] == '00:00:00' ? '' : date('H:i',strtotime($a['Activity']['time']));
                    $date = date('M d, Y',strtotime($a['Activity']['date']));
                    ?>
                        <p class="title"><?php echo $a['Activity']['title']; ?><br /><span><?php echo "$date $time"; ?></span></p>
                    <p><?php echo $a['Activity']['description']; ?></p>
                </div>  
            </div>
            <?php
        }
        ?>
    <div class="clear"></div>
</div><!-- end of home-event-container -->