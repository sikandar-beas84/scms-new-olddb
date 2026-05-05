<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .notice-item {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .notice-item h3 {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }
    .notice-item .date {
        font-size: 0.9rem;
        color: #888;
    }
    .read-more-btn {
        text-align: center;
        margin-top: 20px;
    }
.notice-item {
    min-height: 195px;
}
       .read-more {
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
    }

    .read-more:hover {
        text-decoration: underline;
    }
</style>

<section class="notice-box">
    <div class="container">
        <div class="row">
            <?php foreach($notice_board as $k => $v) { ?>
    <div class="col-md-4 <?= $k >= 5 ? 'd-none' : '' ?>">
        <div class="notice-item">
            <h3><?= $v->notice_title; ?></h3>
            <p>
                <?php 
                    $description = $v->description;
                    $short_desc = strlen($description) > 50 ? substr($description, 0, 50) . '...' : $description;
                ?>
                <span class="short-description"><?= $short_desc; ?></span>
                <?php if (strlen($description) > 50): ?>
                    <span class="full-description d-none"><?= $description; ?></span>
                    <a href="javascript:void(0);" class="read-more" onclick="toggleReadMore(this)">Read More</a>
                <?php endif; ?>
            </p>
            <p class="date"><i class="fas fa-calendar-alt"></i> <?= date('F j, Y', strtotime($v->notice_date)); ?></p>
        </div>
    </div>
<?php } ?>

        </div>
  
    </div>
</section>

<script>
    function toggleReadMore(link) {
        const shortDesc = link.previousElementSibling.previousElementSibling;
        const fullDesc = link.previousElementSibling;

        if (fullDesc.classList.contains('d-none')) {
            shortDesc.classList.add('d-none');
            fullDesc.classList.remove('d-none');
            link.textContent = 'Read Less';
        } else {
            shortDesc.classList.remove('d-none');
            fullDesc.classList.add('d-none');
            link.textContent = 'Read More';
        }
    }
</script>

