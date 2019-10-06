<?php require APPROOT . '/views/inc/header.php'; ?>

<?php flash('post_message'); ?>

<div class="row mb-3">
    <div class="com-md-6">
        <h1><?= $data['title'] ?></h1>
    </div>
    <div class="col-md-6">
        <a href="<?= URLROOT ?>/posts/add" class="btn btn-primary pull-right">
            <i class="fa fa-pencil"></i> Add Post
        </a>
    </div>
</div>

    <?php foreach($data['posts'] as $post): ?>
        <div class="card card-body mb-3">
            <h4 class="card-title"><?= $post->title ?></h4>

            <div class="bg-light p-2 mb-3">
                written by <?= $post->name ?>
                on <?= date("F j, Y, g:i a", strtotime($post->created_at)) ?>
            </div>

            <p class="card-text">
                <?= $post->body ?>
            </p>

            <a href="<?= URLROOT ?>/posts/show/<?=$post->id ?>" class="btn btn-dark">
                More
            </a>
        </div>
    <?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
