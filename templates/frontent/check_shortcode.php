
<form method="post" action="<?php echo esc_attr($_SERVER["REQUEST_URI"]) ?>">
    <input name="domain" />
    <input type="hidden" name="checkId" value="<?php echo $atts['checkId']  ?>" />
    <button type="submit" >
        <?php echo $atts['button']  ?>
    </button>
</form>

<?php if (isset($atts["isavailable"]) && is_bool($atts["isavailable"])): ?>
<p>
    <?php if ($atts["isavailable"]): ?>
        <?php printf($atts["available"], $atts["domain"]) ?>
    <?php else: ?>
        <?php printf($atts["registered"], $atts["domain"]) ?>
    <?php endif ?>
</p>
<?php endif ?>

<?php if (!empty($atts['error'])): ?>
<p>
    <?php echo $atts['error'] ?>
</p>
<?php endif; ?>
