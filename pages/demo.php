<?php 

include "./db.php";

// Query to get oxygen and light intensity data
$sql = "
    SELECT 
        s.roomNo AS `Storage Room`,
        GROUP_CONCAT(DISTINCT CONCAT('Oxygen: ', IFNULL(s.oxygen, 'N/A'), ', Light Intensity: ', IFNULL(s.`light intensity`, 'N/A')) ORDER BY s.roomNo ASC) AS `Details`
    FROM 
        sensor s
    GROUP BY 
        s.roomNo
    LIMIT 25
";

$result = $conn->query($sql);

// Initialize an empty array to store the details
$details = [];

if ($result->num_rows > 0) {
    // Collect the details in an array
    while ($row = $result->fetch_assoc()) {
        $details[] = [
            'roomNo' => $row['Storage Room'],
            'details' => explode(',', $row['Details']) // Split the details into an array of oxygen and light intensity pairs
        ];
    }
} else {
    $details = [];
}

// Close the connection
$conn->close();

// Return the data as JSON for JavaScript
echo json_encode($details);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Room Details</title>
    <style>
        /* Add some basic styling */
        .details-list {
            display: none;
            margin-top: 10px;
        }
        .details-list li {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<!-- Button to display the details -->
<button id="showDetailsBtn">Show Oxygen and Light Intensity</button>

<!-- Div to show the room details -->
<div id="roomDetailsContainer"></div>

<!-- Include jQuery (for simplicity) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Trigger when the button is clicked
        $('#showDetailsBtn').on('click', function() {
            // Send AJAX request to fetch details from PHP
            $.ajax({
                url: 'fetch_details.php', // Make sure this path points to your PHP script
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var htmlContent = '';
                    data.forEach(function(room) {
                        htmlContent += `<h3>Room ${room.roomNo}</h3><ul class="details-list">`;
                        room.details.forEach(function(detail) {
                            htmlContent += `<li>${detail}</li>`;
                        });
                        htmlContent += '</ul>';
                    });

                    // Display the details in the container
                    $('#roomDetailsContainer').html(htmlContent);

                    // Toggle visibility of the details list
                    $('.details-list').slideToggle();
                },
                error: function() {
                    alert('Error fetching data!');
                }
            });
        });
    });
</script>

</body>
</html>
