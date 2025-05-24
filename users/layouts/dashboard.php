<?php
function displayDashboard()
{
?>
    <div class="dashboard-wrapper">
        <div class="header-section">
            <div class="profile">
                Welcome, <?= $_SESSION['userInfo']['name'] ?>!
            </div>
        </div>
        
<?php
}
?>