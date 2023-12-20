

<div class="sidebar">
    <div class="profile_info profile_info_center">
        <img src="../images/profile.jpg" alt="Profile Picture">
        <h2><?php echo $crewId; ?></h2>
        <h4><?php echo $userRole; ?></h4>
    </div>

    <ul>
        <li><a href="../admin/navAdmin.php"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="../admin/viewSchedule.php"><i class="fas fa-list"></i>Schedule</a></li>
        <li><a href="../admin/crewView.php"><i class="fas fa-list"></i>Crew</a></li>
        <li><a href="../admin/department.php"><i class="fas fa-project-diagram"></i>Department</a></li>
        <li><a href="../admin/profile.php"><i class="fas fa-address-card"></i>Profile</a></li>
        <li><a href="../php/index.php" onclick="return confirm('Are you sure you want to log out?')"><i class="fas fa-sign-out-alt"></i>Log Out</a></li>
    </ul>
</div>
