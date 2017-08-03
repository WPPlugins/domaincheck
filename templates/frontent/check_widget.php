
<?php echo $args['before_widget'] ?>
    <?php if (!empty($instance['title'])) : ?>
        <?php echo $args['before_title'] . $instance['title'] . $args['after_title'] ?>
    <?php endif ?>
    
    <?php echo do_shortcode(
            "[domaincheck button='{$instance['button']}' available='{$instance['available']}' registered='{$instance['registered']}']") ?>
<?php echo $args['after_widget'] ?>
