<?php

$sql = "SELECT * FROM crew_schedule";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Crew ID</th>
                <th>Name</th>
                <th>Job Roles</th>
                <th>Duty</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['crew_id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['job_roles']}</td>
                <td>{$row['duty']}</td>
                <td>{$row['start_time']}</td>
                <td>{$row['end_time']}</td>
                <td><a href='#'>View</a></td>
              </tr>";
    }
	?>