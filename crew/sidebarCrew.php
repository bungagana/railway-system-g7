

<div class="sidebar">
    <div class="profile_info profile_info_center">
        <img src="../images/profile.jpg" alt="Profile Picture">
        <h2><?php echo $crewId; ?></h2>
        <h4><?php echo $userRole; ?></h4>
    </div>

    <ul>
        <li><a href="../crew/dashCrew.php"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="../crew/scheduleView.php"><i class="fas fa-list"></i>Schedule</a></li>
        <li><a href="../crew/profileCrew.php"><i class="fas fa-address-card"></i>Profile</a></li>
        <li><a href="../php/index.php" onclick="return confirm('Are you sure you want to log out?')"><i class="fas fa-sign-out-alt"></i>Log Out</a></li>
    </ul>
</div>
