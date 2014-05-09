<?php
echo $this->Html->script('/bootstrap_datetimepicker/js/bootstrap-datetimepicker.min');
echo $this->Html->css('/bootstrap_datetimepicker/css/bootstrap-datetimepicker.min');
echo $this->Html->css('/jqplot/jquery.jqplot.min');
?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->

<?php
echo $this->Html->script(array(
    '/jqplot/jquery.jqplot.min',
    '/jqplot/plugins/jqplot.pieRenderer.min',
    '/jqplot/plugins/jqplot.donutRenderer.min',
));
?>


<style>
    select{
        width: 100%;
    }

    input{
        width: 100%;
    }

    .date input{
        width: auto;
    }

    .bootstrap-datetimepicker-widget{
        top: 400px;
    }
</style>


<h1>Gráfico Matriz Mimo</h1>




<?php echo $this->element('el_graf_mimo'); ?>

<div id="searchsajax"></div>

<?php echo $this->element('search'); ?>

<script type="text/javascript">

    $(document).ready(function() {

        $('#LogMstationGrafMimoForm').on('submit', function(){
            $.get(this.action + "?" + $(this).serialize()).success(function(a,b){
                var newEl = $('<div>');
                newEl.html(a);
                $("#searchsajax").append(newEl);
            });
            return false;
        });
        
        $('#datetimepicker1').datetimepicker({
            format: 'yyyy-MM-dd hh:mm:ss',
            language: 'es-ES'
        });

        $('#datetimepicker2').datetimepicker({
            format: 'yyyy-MM-dd hh:mm:ss',
            language: 'es-ES'
        });
    
    });
</script>