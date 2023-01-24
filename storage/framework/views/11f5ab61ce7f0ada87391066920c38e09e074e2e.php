<?php if(isset($results)): ?>
    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="panel module">
        <span class="head text">
            <?php 
                $data = (array) $result;
            ?> 
            <a href="<?= $data["link"] ?>" target="_blank"><?= $data['link'] ?></a>
        </span>
        <span class="title text"> <a href="<?= $data["link"] ?>" target="_blank"><?= $data['title'] ?></a> </span>
        <span class="text description"> <p><?= (isset($data["snippet"])?$data["snippet"]:'') ?></p></span>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/google_search/search_result.blade.php ENDPATH**/ ?>