<p>Главная</p>

<?php 

foreach ($posts as $key => $val):?>
    <h3><?php echo $val['title'];?></h3>
    <p><?php echo $val['description'];?></p>
    <hr>
<?php endforeach; ?>

 