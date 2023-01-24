<?php if((isset($form_search) && $form_search == 1) || isset($word) || $word == ''): ?>
<div class="library-searches">
    <div class="search-block" style="width: 735px">
        <?php echo e(Form::open(array('id' => 'wordForm'))); ?>

            <?php echo e(csrf_field()); ?>

            <input type="text" style="width: 700px" name="search_word" placeholder="Get meaning of any word" value="<?php echo e(($word != ''? $word: '')); ?>" class="search-input">
            <button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        <?php echo e(Form::close()); ?>

    </div>
</div>
<?php endif; ?>
<?php if(isset($word) && $word != ''): ?>
<div class="title" style="text-align:left;">       
    <h3 class="word"><?php echo e($word); ?></h3>
    <?php if(isset($phonetic)): ?>
        <span class="punctuation"><?php echo e($phonetic); ?></span>
    <?php endif; ?>
    <?php if(isset($meanings)): ?>
        <?php $__currentLoopData = $meanings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meaning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="definition_type"><?php echo e($meaning->partOfSpeech); ?></div>
            <ul>
                <?php if(isset($meaning->definitions)): ?>
                    <?php $__currentLoopData = $meaning->definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($definition->definition); ?></li>
                        <?php if(isset($definition->example)): ?>
                            <li style="font-style: italic;">"<?php echo e($definition->example); ?>"</li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/words/meaning.blade.php ENDPATH**/ ?>