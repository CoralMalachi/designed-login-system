<?php
if(count($errors_messages) > 0): ?>
<div class="errors">
    <?php foreach ($errors_messages as $x): ?>
        <span class="glyphicon glyphicon-warning-sign">

        </span>
        <span id="space">
                <?php echo  $x ?>
            </span>
    <br/>
<!--    <p>--><?php //echo $x ?><!--</p>-->
    <?php endforeach ?>
</div>
<?php endif ?>