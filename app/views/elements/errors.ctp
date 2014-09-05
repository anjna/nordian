<?php
if (!empty($errors)) { ?>
<div class="errors">
    <h3>Oops! Something went wrong.</h3>
    <ul>
        <?php foreach ($errors as $field => $error) { ?>
        <li><?php echo $error; ?></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>