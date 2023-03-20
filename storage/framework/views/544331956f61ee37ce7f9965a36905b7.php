<?php $__env->startComponent('mail::message'); ?>
# Welcome to the first Newletter
Dear <?php echo e($email); ?>,
We look forward to communicating more with you. For more information visit our blog.
<?php $__env->startComponent('mail::button', ['url' => 'https://laraveltuts.com']); ?>
Blog
<?php echo $__env->renderComponent(); ?>
Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/nagwa/Documents/chatbot/resources/views/emails/users.blade.php ENDPATH**/ ?>