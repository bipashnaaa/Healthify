<?php
function displaySidebar($links) {
?>
<div class="sidebar-wrapper">
    <div class="dashboard-logo">
        <h2>Healthify</h2>
    </div>
    <div class="dashboard-cta">
        <div class="links">
            <?php foreach ($links as $link) : ?>
                <a href="<?=$link['link']?>">
                <img src="../img/<?=$link['title']?>-icon.png" style="max-width:20px;">
                    <sup><?=ucwords($link['title'])?></sup>
                </a> <br>
            <?php endforeach; ?>
        </div>
        <a class="logout" href="../layouts/logout.php">
            <img src="../img/logout-icon.png">
            <sup>Sign out</sup>
        </a>
    </div>
</div>
<?php
}
?>